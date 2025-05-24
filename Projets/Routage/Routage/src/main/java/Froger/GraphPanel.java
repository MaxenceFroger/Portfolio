package Froger;

import org.graphstream.graph.*;
import org.graphstream.graph.implementations.SingleGraph;
import org.graphstream.ui.swing_viewer.SwingViewer;
import org.graphstream.ui.swing_viewer.ViewPanel;
import org.graphstream.ui.view.View;
import org.graphstream.ui.view.Viewer;

import javax.swing.*;
import java.awt.*;

public class GraphPanel extends JInternalFrame {
    private Graph graph;

    public GraphPanel() {
        super("Graph Viewer", true, true, true, true);
        setSize(500, 500);
        setLocation(530, 0);
        setVisible(true);
        setDefaultCloseOperation(HIDE_ON_CLOSE);
        add(initGraph());
    }

    private JPanel initGraph() {
        System.setProperty("org.graphstream.ui", "swing");
        graph = new SingleGraph("Tutorial 1");
        setStyle();
        Viewer viewer = new SwingViewer(graph, Viewer.ThreadingModel.GRAPH_IN_ANOTHER_THREAD);
        viewer.enableAutoLayout();
        View view = viewer.addDefaultView(false);
        ((Component) view).setFocusable(false);
        return (ViewPanel) view;
    }

    private void setStyle() {
        graph.setAttribute("ui.stylesheet", "node { text-size: 20; fill-color : #7FFFD4; size : 30px; z-index:3;}" +
                "edge {text-alignment: above; text-size: 20; fill-color : #7FFFD4; z-index:2; text-background-mode: rounded-box; text-background-color:white; text-padding: 5px; stroke-mode:plain; stroke-width:3px;}" +
                "node.pc {fill-color : red;}" +
                "edge.liaison {fill-color : red;}");
    }

    public Graph getGraph() {
        return graph;
    }
}