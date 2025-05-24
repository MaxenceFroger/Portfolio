package Froger;

import org.graphstream.algorithm.Dijkstra;
import org.graphstream.graph.*;
import org.graphstream.graph.implementations.SingleGraph;

import javax.swing.*;
import java.awt.*;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class TableRoutagePanel extends JInternalFrame {
    JTextPane textPane;
    Graph graph;

    public TableRoutagePanel(GraphPanel graphPanel) {
        super("Table de Routage", true, true, true, true);
        this.graph = graphPanel.getGraph();
        setSize(200, 500);
        setLocation(1040, 0);
        setVisible(true);
        setDefaultCloseOperation(HIDE_ON_CLOSE);
        add(initTablePanel());
    }

    private JPanel initTablePanel() {
        JPanel panel = new JPanel(new BorderLayout()); // Utiliser BorderLayout pour un bon placement

        textPane = new JTextPane();
        textPane.setEditable(false);
        textPane.setContentType("text/plain"); // Assure un affichage de texte brut
        textPane.setPreferredSize(new Dimension(380, 780)); // Limite la taille

        JScrollPane scrollPane = new JScrollPane(textPane);
        scrollPane.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED);
        scrollPane.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_NEVER);

        panel.add(scrollPane, BorderLayout.CENTER); // Ajout au centre pour occuper tout l’espace

        return panel;
    }


    public void updateTable() {
        TableRoutage tableRoutage = construireTableRoutage();
        textPane.setText(tableRoutage.toString());
    }

    public TableRoutage construireTableRoutage() {
        TableRoutage tableRoutage = new TableRoutage();
        for (Node source : graph.nodes().toList()) {
            if ("pc".equals(source.getAttribute("ui.class"))) {
                continue; // Ignore les PC
            }

            for (Node destination : graph.nodes().toList()) {
                if ("pc".equals(destination.getAttribute("ui.class"))) {
                    continue; // Ignore les PC
                }

                Graph copy = cloneGraph();
                Node sourceCopy = copy.getNode(source.toString());
                Node destinationCopy = copy.getNode(destination.toString());
                java.util.List<Node> listVoisin = new ArrayList<>();

                // Ajout des voisins en excluant les PC
                sourceCopy.edges().forEach(edge -> {
                    Node voisin = edge.getOpposite(sourceCopy);
                    if (!"liaison".equals(edge.getAttribute("ui.class")) && !"pc".equals(voisin.getAttribute("ui.class"))) {
                        listVoisin.add(voisin);
                    }
                });

                if (!sourceCopy.equals(destinationCopy)) {
                    HashMap<Node, Integer> listVoisinTriee = new HashMap<>();
                    for (Node voisin : listVoisin) {
                        int poids = Integer.parseInt(sourceCopy.getEdgeToward(voisin).getAttribute("poids").toString());
                        copy.removeEdge(sourceCopy.getEdgeToward(voisin));
                        poids += poidsRoute(route(voisin, destinationCopy));
                        listVoisinTriee.put(voisin, poids);
                    }

                    List<Node> sortedNodes = listVoisinTriee.entrySet().stream()
                            .sorted(Map.Entry.comparingByValue()) // Trie par la valeur Integer
                            .map(Map.Entry::getKey) // Récupère uniquement les clés (Node)
                            .toList(); // Collecte en une liste triée
                    tableRoutage.ajouterListe(source.getId(), destination.getId(), sortedNodes);
                }
            }
        }

        return tableRoutage;
    }

    public ArrayList<Node> route(Node nodeA, Node nodeB) {
        ArrayList<Node> cheminMin = new ArrayList<>();
        int[] poidsMin = {Integer.MAX_VALUE}; // Utilisation d'un tableau pour modification dans la récursion
        exploreChemins(nodeA, nodeB, new ArrayList<>(), 0, poidsMin, cheminMin);
        return cheminMin;
    }

    private void exploreChemins(Node current, Node destination, ArrayList<Node> cheminActu, int poidsChemin, int[] poidsMin, ArrayList<Node> cheminMin) {
        cheminActu.add(current);

        if (current.equals(destination)) {
            if (poidsChemin < poidsMin[0]) { // Mettre à jour si meilleur chemin trouvé
                poidsMin[0] = poidsChemin;
                cheminMin.clear();
                cheminMin.addAll(new ArrayList<>(cheminActu));
            }
        } else {
            for (Edge edge : current.edges().toList()) {
                Node suivant = edge.getOpposite(current);

                // Récupérer le poids de l'edge (ou 0 s'il n'a pas d'attribut "poids")
                int poidsEdge = edge.hasAttribute("poids") ? Integer.parseInt(edge.getAttribute("poids").toString()) : 0;

                // Exclure les PC et les liaisons
                if (!"liaison".equals(edge.getAttribute("ui.class")) && !"pc".equals(suivant.getAttribute("ui.class"))) {
                    if (!cheminActu.contains(suivant) && poidsChemin + poidsEdge < poidsMin[0]) { // Élagage
                        exploreChemins(suivant, destination, cheminActu, poidsChemin + poidsEdge, poidsMin, cheminMin);
                    }
                }
            }
        }

        cheminActu.remove(cheminActu.size() - 1); // Backtracking
    }

    public Graph cloneGraph() {
        Graph copyGraphique = new SingleGraph("copy");

        // Cloner les nœuds, en incluant les attributs
        graph.nodes().forEach(node -> {
            Node newNode = copyGraphique.addNode(node.toString());
            newNode.setAttribute("ui.label", node.getAttribute("ui.label"));
            newNode.setAttribute("ui.class", node.getAttribute("ui.class")); // Copier l'attribut ui.class
        });

        // Cloner les arêtes
        graph.edges().forEach(edge -> {
            String id = edge.getNode0().toString() + edge.getNode1().toString();
            copyGraphique.addEdge(
                    id,
                    copyGraphique.getNode(edge.getNode0().toString()),
                    copyGraphique.getNode(edge.getNode1().toString()));

            // Copier l'attribut poids
            copyGraphique.getEdge(id).setAttribute("poids",
                    edge.hasAttribute("poids") ? Integer.parseInt(edge.getAttribute("poids").toString()) : 0
            );
            copyGraphique.getEdge(id).setAttribute("ui.class", edge.getAttribute("ui.class"));
        });

        return copyGraphique;
    }

    public int poidsRoute(ArrayList<Node> route) {
        int poids = 0;
        for(int i = 0; i < route.size()-1; i++) {
            Node nodeA = route.get(i);
            Node nodeB = route.get(i+1);
            poids += Integer.parseInt(nodeA.getEdgeBetween(nodeB).getAttribute("poids").toString());
        }
        return poids;
    }

    public void routeDijkstra(Node nodeDebut, Node nodeFin) {
        Dijkstra dijkstra = new Dijkstra(Dijkstra.Element.EDGE, null, "poids");

        // Compute the shortest paths in g from A to all nodes
        dijkstra.init(graph);
        dijkstra.setSource(nodeDebut);
        dijkstra.compute();
        System.out.println(dijkstra.getPath(nodeFin));

    }
}