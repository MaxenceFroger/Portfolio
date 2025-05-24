package Froger;

import org.graphstream.graph.Edge;
import org.graphstream.graph.Graph;
import org.graphstream.graph.Node;

import javax.swing.*;
import javax.swing.text.AbstractDocument;
import javax.swing.text.AttributeSet;
import javax.swing.text.BadLocationException;
import javax.swing.text.DocumentFilter;
import java.awt.*;
import java.util.*;

public class ControlPanel extends JInternalFrame {
    private final TableRoutagePanel tableRoutagePanel;
    private final Graph graph;
    ArrayList<String> nodes = new ArrayList<>();
    ArrayList<DefaultComboBoxModel<String>> listeModelNodes = new ArrayList<>();
    ArrayList<String> pc = new ArrayList<>();
    ArrayList<DefaultComboBoxModel<String>> listeModelPC = new ArrayList<>();

    public ControlPanel(GraphPanel graphPanel, TableRoutagePanel tableRoutagePanel) {
        super("Panneau de Contrôle", true, true, true, true);
        this.graph = graphPanel.getGraph();
        this.tableRoutagePanel = tableRoutagePanel;
        setSize(500, 500);
        setLocation(20,0);
        setVisible(true);
        setDefaultCloseOperation(HIDE_ON_CLOSE);
        add(initPanneauControl());
    }

    private JPanel initPanneauControl() {
        JPanel panneau = new JPanel();
        //panneau.add(initChargerFichier());
        panneau.setLayout(new BoxLayout(panneau, BoxLayout.Y_AXIS));
        panneau.add(Box.createVerticalGlue());  // Espacement entre les composants
        panneau.add(initAjoutNod());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initAjoutEdge());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initAjoutPC());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initAjoutConnection());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initRemoveNod());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initRemoveEdge());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initRemovePC());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initRemoveConnection());
        panneau.add(Box.createVerticalGlue());
        panneau.add(initFindRoute());
        panneau.setPreferredSize(new Dimension(400, 500));
        return panneau;
    }


    private JPanel initAjoutNod() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());
        JLabel label = new JLabel("Ajouter un commutateur:");
        JTextField text = new JTextField(10);
        JButton button = new JButton("Ajouter");

        button.addActionListener(e -> addNode(text.getText()));

        panneau.add(label);
        panneau.add(text);
        panneau.add(button);
        return panneau;
    }

    public JPanel initRemoveNod() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());
        JLabel label = new JLabel("Supprimer un commutateur:");
        JComboBox<String> nod1 = new JComboBox<>(creerDefaultComboBoxModelNod());
        JButton button = new JButton("Supprimer");
        button.addActionListener(e -> removeNode(nod1.getModel().getSelectedItem().toString()));
        panneau.add(label);
        panneau.add(nod1);
        panneau.add(button);
        return panneau;
    }

    private JPanel initAjoutPC() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());
        JLabel label = new JLabel("Ajouter un PC:");
        JTextField text = new JTextField(10);
        JButton button = new JButton("Ajouter");

        button.addActionListener(e -> addPC(text.getText()));

        panneau.add(label);
        panneau.add(text);
        panneau.add(button);
        return panneau;
    }

    public JPanel initRemovePC() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());
        JLabel label = new JLabel("Supprimer un PC:");
        JComboBox<String> PC1 = new JComboBox<>(creerDefaultComboBoxModelPC());
        JButton button = new JButton("Supprimer");
        button.addActionListener(e -> removePC(PC1.getModel().getSelectedItem().toString()));
        panneau.add(label);
        panneau.add(PC1);
        panneau.add(button);
        return panneau;
    }

    public JPanel initAjoutEdge() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());
        JLabel label = new JLabel("Ajouter une liaison:");

        JLabel labelPoid = new JLabel("Poids: ");

        JTextField poids = new JTextField(10);

        setNumberInputFilter(poids);

        JComboBox<String> nod1 = new JComboBox<>(creerDefaultComboBoxModelNod());

        JComboBox<String> nod2 = new JComboBox<>(creerDefaultComboBoxModelNod());

        JButton button = new JButton("Ajouter");
        button.addActionListener(e -> addEdge(nod1.getModel().getSelectedItem().toString(),nod2.getModel().getSelectedItem().toString(),poids.getText()));
        panneau.add(label);
        panneau.add(labelPoid);
        panneau.add(poids);
        panneau.add(nod1);
        panneau.add(nod2);
        panneau.add(button);
        return panneau;
    }

    public JPanel initRemoveEdge() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());
        JLabel label = new JLabel("Supprimer une liaison:");

        JComboBox<String> nod1 = new JComboBox<>(creerDefaultComboBoxModelNod());

        JComboBox<String> nod2 = new JComboBox<>(creerDefaultComboBoxModelNod());

        JButton button = new JButton("Supprimer");
        button.addActionListener(e -> removeEdge(nod1.getModel().getSelectedItem().toString(),nod2.getModel().getSelectedItem().toString()));
        panneau.add(label);
        panneau.add(nod1);
        panneau.add(nod2);
        panneau.add(button);
        return panneau;
    }

    public JPanel initAjoutConnection() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());
        JLabel label = new JLabel("Connecter un PC:");

        JComboBox<String> pc = new JComboBox<>(creerDefaultComboBoxModelPC());

        JComboBox<String> node = new JComboBox<>(creerDefaultComboBoxModelNod());

        JButton button = new JButton("Connection");
        button.addActionListener(e -> addConnection(pc.getModel().getSelectedItem().toString(),node.getModel().getSelectedItem().toString()));
        panneau.add(label);
        panneau.add(pc);
        panneau.add(node);
        panneau.add(button);
        return panneau;
    }

    public JPanel initRemoveConnection() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());

        JLabel label = new JLabel("Déconnecter un PC:");
        JComboBox<String> pc = new JComboBox<>(creerDefaultComboBoxModelPC());

        JButton button = new JButton("Déconnecter");
        button.addActionListener(e -> removeConnection(pc.getModel().getSelectedItem().toString()));

        panneau.add(label);
        panneau.add(pc);
        panneau.add(button);

        return panneau;
    }

    public JPanel initFindRoute() {
        JPanel panneau = new JPanel();
        panneau.setLayout(new FlowLayout());

        JLabel label = new JLabel("Trouver le chemin optimale:");

        JComboBox<String> pc1 = new JComboBox<>(creerDefaultComboBoxModelPC());

        JComboBox<String> pc2 = new JComboBox<>(creerDefaultComboBoxModelPC());

        JButton button = new JButton("Chercher");
        button.addActionListener(e -> findRoute(pc1.getModel().getSelectedItem().toString(),pc2.getModel().getSelectedItem().toString()));
        panneau.add(label);
        panneau.add(pc1);
        panneau.add(pc2);
        panneau.add(button);

        return panneau;
    }

    private void findRoute(String pc1, String pc2) {
        if(pc1 != null && pc2 != null) {
            if(!pc1.equals(pc2)) {
                Node pc1Node = graph.getNode(pc1);
                Node pc2Node = graph.getNode(pc2);
                boolean PC1Connect = pc1Node.edges().findFirst().isPresent();
                boolean PC2Connect = pc2Node.edges().findFirst().isPresent();
                if(PC1Connect && PC2Connect) {
                    Node nodeSource = pc1Node.edges().findFirst().get().getOpposite(pc1Node);
                    Node nodeDestination = pc2Node.edges().findFirst().get().getOpposite(pc2Node);
                    ArrayList<Node> route = tableRoutagePanel.route(nodeSource, nodeDestination);
                    String affichage = route.toString() + " | poids : " + tableRoutagePanel.poidsRoute(route);
                    if(!route.isEmpty()) {JOptionPane.showMessageDialog(this, affichage, "Chemin Trouvé", JOptionPane.INFORMATION_MESSAGE);}
                    else {JOptionPane.showMessageDialog(this, "Chemin Inexistant!", "Error", JOptionPane.ERROR_MESSAGE);}
                }else {JOptionPane.showMessageDialog(this, "Input invalide! PC Deconnecter.", "Error", JOptionPane.ERROR_MESSAGE);}
            }else {JOptionPane.showMessageDialog(this, "Input invalide! Ne peut pas trouver un chemin vers lui même.", "Error", JOptionPane.ERROR_MESSAGE);}
        }else {JOptionPane.showMessageDialog(this, "Input invalide! PC inexistant.", "Error", JOptionPane.ERROR_MESSAGE);}
    }

    void addEdge(String node1String, String node2String, String poids) {
        if((graph.getNode(node1String) != null && graph.getNode(node2String) != null)) {
            Node node1 = graph.getNode(node1String);
            Node node2 = graph.getNode(node2String);
            String id = node1.getId()+node2.getId();
            if (!node1.equals(node2)){
                if(node1.getEdgeBetween(node2) == null){
                    if(!id.isEmpty()) {
                        if(!poids.isEmpty()) {
                            Edge edge = graph.addEdge(id, node1.getIndex(), node2.getIndex());
                            edge.setAttribute("poids", Integer.parseInt(poids));
                            edge.setAttribute("ui.label", edge.getAttribute("poids").toString());
                        }else {JOptionPane.showMessageDialog(this, "Input invalide! La liaison doit avoir un poids", "Error", JOptionPane.ERROR_MESSAGE);}
                    }else {JOptionPane.showMessageDialog(this, "Input invalide! La liaison doit avoir un nom", "Error", JOptionPane.ERROR_MESSAGE);}
                }else {JOptionPane.showMessageDialog(this, "Input invalide! La liaison existe déjà", "Error", JOptionPane.ERROR_MESSAGE);}
            }else {JOptionPane.showMessageDialog(this, "Input invalide! Impossible de lier un Noeud à lui même.", "Error", JOptionPane.ERROR_MESSAGE);}

        } else {JOptionPane.showMessageDialog(this, "Input invalide! Noeud inexistant.", "Error", JOptionPane.ERROR_MESSAGE);}
        tableRoutagePanel.updateTable();
    }

    private void removeEdge(String node1String, String node2String) {
        if((graph.getNode(node1String) != null && graph.getNode(node2String) != null)) {
            Node node1 = graph.getNode(node1String);
            Node node2 = graph.getNode(node2String);
            if(node1.getEdgeBetween(node2) != null){
                graph.removeEdge(node1.getIndex(), node2.getIndex());
            }else {JOptionPane.showMessageDialog(this, "Input invalide! La liaison n'existe pas", "Error", JOptionPane.ERROR_MESSAGE);}
        } else {JOptionPane.showMessageDialog(this, "Input invalide! Commutateur inexistant.", "Error", JOptionPane.ERROR_MESSAGE);}
        tableRoutagePanel.updateTable();
    }

    void addConnection(String PCString, String nodeString) {
        if((graph.getNode(PCString) != null && graph.getNode(nodeString) != null)) {
            Node pc = graph.getNode(PCString);
            Node node = graph.getNode(nodeString);
            String id = pc.getId()+node.getId();
                if(pc.getEdgeBetween(node) == null){
                    if(!id.isEmpty()) {
                        if(pc.edges().findAny().isEmpty()) {
                            Edge edge = graph.addEdge(id, pc.getIndex(), node.getIndex());
                            edge.setAttribute("poids", 0);
                            edge.setAttribute("ui.class", "connection");
                        }else {JOptionPane.showMessageDialog(this, "Input invalide! Un PC ne peut avoir qu'une connection", "Error", JOptionPane.ERROR_MESSAGE);}
                    }else {JOptionPane.showMessageDialog(this, "Input invalide! La connection doit avoir un nom", "Error", JOptionPane.ERROR_MESSAGE);}
                }else {JOptionPane.showMessageDialog(this, "Input invalide! La connection existe déjà", "Error", JOptionPane.ERROR_MESSAGE);}
        } else {JOptionPane.showMessageDialog(this, "Input invalide! Commutateur inexistant.", "Error", JOptionPane.ERROR_MESSAGE);}
        tableRoutagePanel.updateTable();
    }

    private void removeConnection(String PCString) {
        Node pc = graph.getNode(PCString);

        if (pc != null) {
            // Trouver le premier edge connecté au PC
            Optional<Edge> edgeOpt = pc.edges().findFirst();

            if (edgeOpt.isPresent()) {
                Edge edge = edgeOpt.get();
                // Supprimer l'edge
                graph.removeEdge(edge);
            } else {
                JOptionPane.showMessageDialog(this, "Ce PC n'a aucune connexion.", "Error", JOptionPane.ERROR_MESSAGE);
            }
        } else {
            JOptionPane.showMessageDialog(this, "PC inexistant.", "Error", JOptionPane.ERROR_MESSAGE);
        }

        tableRoutagePanel.updateTable();
    }

    void addNode(String nom) {
        if(graph.getNode(nom) == null) {
            if(!nom.isEmpty()) {
                Node nodeA = graph.addNode(nom);
                nodeA.setAttribute("ui.label", nom);
                nodes.add(nom);
                updateModels();
            }
            else {JOptionPane.showMessageDialog(this, "Input invalide! Le commutateur doit avoir un nom", "Error", JOptionPane.ERROR_MESSAGE);}

        }
        else {JOptionPane.showMessageDialog(this, "Input invalide! Le commutateur existe déjà", "Error", JOptionPane.ERROR_MESSAGE);}
        tableRoutagePanel.updateTable();
    }

    private void removeNode(String nom) {
        if(graph.getNode(nom) != null) {
            graph.removeNode(graph.getNode(nom));
            nodes.remove(nom);
            updateModels();
        }
        else {JOptionPane.showMessageDialog(this, "Input invalide! Le commutateur n'existe pas", "Error", JOptionPane.ERROR_MESSAGE);}
        tableRoutagePanel.updateTable();
    }

    void addPC(String nom) {
        if(graph.getNode(nom) == null) {
            if(!nom.isEmpty()) {
                Node nodeA = graph.addNode(nom);
                nodeA.setAttribute("ui.label", nom);
                nodeA.setAttribute("ui.class", "pc");
                pc.add(nom);
                updateModels();
            }
            else {JOptionPane.showMessageDialog(this, "Input invalide! Le PC doit avoir un nom", "Error", JOptionPane.ERROR_MESSAGE);}

        }
        else {JOptionPane.showMessageDialog(this, "Input invalide! Le PC existe déjà", "Error", JOptionPane.ERROR_MESSAGE);}
        tableRoutagePanel.updateTable();
    }

    private void removePC(String nom) {
        if(graph.getNode(nom) != null && graph.getNode(nom).getAttribute("ui.class").equals("pc")) {
            graph.removeNode(graph.getNode(nom));
            pc.remove(nom);
            updateModels();
        }
        else {JOptionPane.showMessageDialog(this, "Input invalide! Le PC n'existe pas", "Error", JOptionPane.ERROR_MESSAGE);}
        tableRoutagePanel.updateTable();
    }

    private DefaultComboBoxModel<String> creerDefaultComboBoxModelNod() {
        DefaultComboBoxModel<String> model = new DefaultComboBoxModel<>(nodes.toArray(new String[0]));
        listeModelNodes.add(model);
        return model;
    }

    private DefaultComboBoxModel<String> creerDefaultComboBoxModelPC() {
        DefaultComboBoxModel<String> model = new DefaultComboBoxModel<>(pc.toArray(new String[0]));
        listeModelPC.add(model);
        return model;
    }

    public void updateModels() {
        for (DefaultComboBoxModel<String> model : listeModelNodes) {
            model.removeAllElements();
            for (String node : nodes) {
                model.addElement(node);
            }
        }
        for (DefaultComboBoxModel<String> model : listeModelPC) {
            model.removeAllElements();
            for (String machine : pc) {
                model.addElement(machine);
            }
        }

    }



    public void reset() {
        graph.clear();
        graph.setAttribute("ui.stylesheet", "node { text-size: 20; fill-color : #7FFFD4; size : 30px; z-index:3;}" +
                "edge {text-alignment: above; text-size: 20; fill-color : #7FFFD4; z-index:2; text-background-mode: rounded-box; text-background-color:white; text-padding: 5px; stroke-mode:plain; stroke-width:3px;}" +
                "node.pc {fill-color : red;}" +
                "edge.connection {fill-color : red;}");
        nodes = new ArrayList<>();
        pc = new ArrayList<>();
        updateModels();
    }
    private void setNumberInputFilter(JTextField textField) {
        ((AbstractDocument) textField.getDocument()).setDocumentFilter(new DocumentFilter() {
            @Override
            public void insertString(FilterBypass fb, int offset, String string, AttributeSet attr) throws BadLocationException {
                if (isNumber(string)) {
                    super.insertString(fb, offset, string, attr);
                }
            }

            @Override
            public void replace(FilterBypass fb, int offset, int length, String string, AttributeSet attr) throws BadLocationException {
                if (isNumber(string)) {
                    super.replace(fb, offset, length, string, attr);
                }
            }

            @Override
            public void remove(FilterBypass fb, int offset, int length) throws BadLocationException {
                super.remove(fb, offset, length);
            }

            private boolean isNumber(String text) {
                return text.matches("[0123456789]*");
            }
        });
    }
}
