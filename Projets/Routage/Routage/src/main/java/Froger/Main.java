package Froger;
import org.graphstream.stream.GraphParseException;

import javax.swing.*;
import javax.swing.filechooser.FileNameExtensionFilter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.Scanner;

public class Main extends JFrame {

    private final GraphPanel graphPanel;
    private final ControlPanel controlPanel;
    private final TableRoutagePanel tableRoutagePanel;

    public Main() {
        super("Affichage Main");
        JDesktopPane desktopPane = new JDesktopPane();
        setContentPane(desktopPane);

        initMenuBar();

        graphPanel = new GraphPanel();
        tableRoutagePanel = new TableRoutagePanel(graphPanel);
        controlPanel = new ControlPanel(graphPanel,tableRoutagePanel);

        desktopPane.add(graphPanel);
        desktopPane.add(controlPanel);
        desktopPane.add(tableRoutagePanel);

        setSize(1300, 600);
        setLocationRelativeTo(null);
        setDefaultCloseOperation(EXIT_ON_CLOSE);
        setVisible(true);
    }

    private void initMenuBar() {
        JMenuBar menuBar = new JMenuBar();
        JMenu fileMenu = new JMenu("File");
        JMenuItem chargerFichier = new JMenuItem("Charger Fichier");
        JMenuItem exitMenuItem = new JMenuItem("Exit");
        JMenu affichageMenu = new JMenu("Affichage");
        JMenuItem panelItem = new JMenuItem("Panneau de Contrôle");
        JMenuItem graphItem = new JMenuItem("Graph Viewer");
        JMenuItem tableItem = new JMenuItem("Table de Routage");

        chargerFichier.addActionListener(e -> {
            JFileChooser fileChooser = new JFileChooser();
            fileChooser.setCurrentDirectory(new File("."));
            fileChooser.setDialogTitle("Sélectionner un fichier");
            fileChooser.setFileSelectionMode(JFileChooser.FILES_ONLY);

            // Filtre pour ne permettre que les fichiers .txt et .dgs
            FileNameExtensionFilter filter = new FileNameExtensionFilter("Fichiers texte et DGS", "txt", "dgs");
            fileChooser.setFileFilter(filter);

            int returnValue = fileChooser.showOpenDialog(null);
            if (returnValue == JFileChooser.APPROVE_OPTION) {
                File fichier = fileChooser.getSelectedFile();
                chargerFichier(fichier.getAbsolutePath());
            }
        });
        exitMenuItem.addActionListener(e->System.exit(0));

        panelItem.addActionListener(e -> controlPanel.setVisible(true));
        graphItem.addActionListener(e -> graphPanel.setVisible(true));
        tableItem.addActionListener(e -> tableRoutagePanel.setVisible(true));

        fileMenu.add(chargerFichier);
        fileMenu.add(exitMenuItem);
        affichageMenu.add(panelItem);
        affichageMenu.add(graphItem);
        affichageMenu.add(tableItem);
        menuBar.add(fileMenu);
        menuBar.add(affichageMenu);
        setJMenuBar(menuBar);
    }

    void chargerFichier(String nomFichier) {
        try {
            File fichier = new File(nomFichier);
            Scanner sc = new Scanner(fichier);
            controlPanel.reset();
            // Vérifier si c'est un fichier .DGS
            if (nomFichier.toLowerCase().endsWith(".dgs")) {
                graphPanel.getGraph().read(fichier.getAbsolutePath());
                graphPanel.getGraph().nodes().forEach(node -> {
                    if ("pc".equals(node.getAttribute("ui.class"))) {
                        controlPanel.pc.add(node.toString());
                    } else {
                        controlPanel.nodes.add(node.toString());
                    }
                });
                controlPanel.updateModels();
            }
            else {
                while (sc.hasNextLine()) {
                    String line = sc.nextLine().trim();
                    if (line.isEmpty()) continue;

                    String[] parts = line.split(" ");

                    if (parts[0].equals("Node")) {
                        if (parts.length == 2) {
                            controlPanel.addNode(parts[1]);
                        }
                    } else if (parts[0].equals("Edge")) {
                        if (parts.length == 4) {
                            controlPanel.addEdge(parts[1], parts[2], parts[3]);
                        }
                    }
                    else if(parts[0].equals("PC")) {
                        if(parts.length == 2) {
                            controlPanel.addPC(parts[1]);
                        }
                    }
                    else if (parts[0].equals("Connection")) {
                        if (parts.length == 3) {
                            controlPanel.addConnection(parts[1], parts[2]);
                        }
                    }
                }
            }
            sc.close();
        } catch (FileNotFoundException e) {
            JOptionPane.showMessageDialog(this, "Input invalide! Fichier inexistant.", "Error", JOptionPane.ERROR_MESSAGE);
        } catch (IOException | GraphParseException e) {
            throw new RuntimeException(e);
        }
        tableRoutagePanel.updateTable();
    }


    public static void main(String[] args) {
        SwingUtilities.invokeLater(Main::new);
    }
}