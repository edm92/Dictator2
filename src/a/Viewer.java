package a;
/*
 * Copyright (c) 1995, 2008, Oracle and/or its affiliates. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   - Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   - Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in the
 *     documentation and/or other materials provided with the distribution.
 *
 *   - Neither the name of Oracle or the names of its
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */


        import javax.swing.JDesktopPane;
        import javax.swing.JMenu;
        import javax.swing.JMenuItem;
        import javax.swing.JMenuBar;
        import javax.swing.JFrame;
        import javax.swing.KeyStroke;

        import java.awt.event.*;
        import java.awt.*;

    /*
     * InternalFrameDemo.java requires:
     *   MyInternalFrame.java
     */

/**
 * Visualisation class for word by word display
 * from: http://docs.oracle.com/javase/tutorial/displayCode.html?code=http://docs.oracle.com/javase/tutorial/uiswing/examples/components/InternalFrameDemoProject/src/components/InternalFrameDemo.java
 * Created by e on 22/03/14.
 */
public class Viewer extends JFrame
        implements ActionListener {


        JDesktopPane desktop;
        public MyInternalFrame viewFrame;
        public MyInternalFrame textFrame;

        public Viewer() {
            super("Dictator2");

            //Make the big window be indented 50 pixels from each edge
            //of the screen.
            int inset = 50;
            Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
            setBounds(inset, inset,
                    screenSize.width  - inset*2,
                    screenSize.height - inset*2);

            //Set up the GUI.
            desktop = new JDesktopPane(); //a specialized layered pane
            createFrames(); //create first "window"
            setContentPane(desktop);
            setJMenuBar(createMenuBar());

            //Make dragging a little faster but perhaps uglier.
            desktop.setDragMode(JDesktopPane.OUTLINE_DRAG_MODE);
        }

        protected JMenuBar createMenuBar() {
            JMenuBar menuBar = new JMenuBar();

            //Set up the lone menu.
            JMenu menu = new JMenu("Document");
            menu.setMnemonic(KeyEvent.VK_D);
            menuBar.add(menu);

            //Set up the first menu item.
            JMenuItem menuItem = new JMenuItem("Reopen Windows");
            menuItem.setMnemonic(KeyEvent.VK_N);
            menuItem.setAccelerator(KeyStroke.getKeyStroke(
                    KeyEvent.VK_N, ActionEvent.ALT_MASK));
            menuItem.setActionCommand("new");
            menuItem.addActionListener(this);
            menu.add(menuItem);

            //Set up the second menu item.
            menuItem = new JMenuItem("Quit");
            menuItem.setMnemonic(KeyEvent.VK_Q);
            menuItem.setAccelerator(KeyStroke.getKeyStroke(
                    KeyEvent.VK_Q, ActionEvent.ALT_MASK));
            menuItem.setActionCommand("quit");
            menuItem.addActionListener(this);
            menu.add(menuItem);

            return menuBar;
        }

        //React to menu selections.
        public void actionPerformed(ActionEvent e) {
            if ("new".equals(e.getActionCommand())) { //new
                createFrames();
            } else { //quit
                quit();
            }
        }

        //Create a new internal frame.
        protected void createFrames() {
            if(viewFrame == null){
                viewFrame = new MyInternalFrame("Reader");
            }
            if(textFrame == null){
                textFrame = new MyInternalFrame("Text");
            }
            if(!viewFrame.isVisible())
                viewFrame.setVisible(true); //necessary as of 1.3
            if(!textFrame.isVisible())
                textFrame.setVisible(true); //necessary as of 1.3
            desktop.add(viewFrame);
            desktop.add(textFrame);
            try {
                textFrame.setSelected(true);
            } catch (java.beans.PropertyVetoException e) {}
        }

        //Quit the application.
        protected void quit() {
            System.exit(0);
        }

        /**
         * Create the GUI and show it.  For thread safety,
         * this method should be invoked from the
         * event-dispatching thread.
         */
        private static void createAndShowGUI() {
            //Make sure we have nice window decorations.
            JFrame.setDefaultLookAndFeelDecorated(true);

            //Create and set up the window.
            Viewer frame = new Viewer();
            frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

            //Display the window.
            frame.setVisible(true);
        }

        public static void main(String[] args) {
            //Schedule a job for the event-dispatching thread:
            //creating and showing this application's GUI.
            javax.swing.SwingUtilities.invokeLater(new Runnable() {
                public void run() {
                    createAndShowGUI();
                }
            });
        }


}
