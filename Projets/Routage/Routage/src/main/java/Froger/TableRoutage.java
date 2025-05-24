package Froger;

import org.graphstream.graph.Edge;
import org.graphstream.graph.Graph;
import org.graphstream.graph.Node;

import java.util.*;

public class TableRoutage {
    private final Map<String, Map<String, List<Node>>> table;

    public TableRoutage() {
        this.table = new HashMap<>();
    }

    public void ajouterListe(String source, String destination, List<Node> liste) {
        table.putIfAbsent(source, new HashMap<>());
        table.get(source).put(destination, liste);
    }

    public void afficherTable() {
        System.out.println(this);
    }

    public String toString() {
        StringBuilder affichage = new StringBuilder();
        for (String noeud : table.keySet()) {
            affichage.append("Noeud ").append(noeud).append(" : \n");
            for (Map.Entry<String, List<Node>> entry : table.get(noeud).entrySet()) {
                affichage.append("  ").append(entry.getKey()).append(" → ").append(entry.getValue()).append("\n");
            }
        }
        return affichage.toString();
    }
}