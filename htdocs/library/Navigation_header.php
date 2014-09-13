<?php
class Navigation_header {
    private $site = null;
    public function set_site($site) {$this->site = $site;}
    private $module = array (
        'left' => array(),
        'right' => array(),
    );
    public function get_rendered() {
        $result = "";
        $template = new Aoloe\Template();
        $template->set('navigation_left', array (
            '<a href="/" style="color:#fbb93d; padding-right:10px;"><img src="'.$this->site->get_path_relative().'images/sortir_du_nucleaire_14.png"> Accueil</a>',
            // '<a href="/" style="color:black;"> 11 octobre: Sortie à Allaman</a>',
        ));
        $template->set('navigation_right', array (
            '<a href="/association/contact" style="color:#fbb93d;">✉</a> <a href="/association/contact" style="color:black;">Contact</a>',
        ));
        $result = $template->fetch('template/navigation_header.php');
        return $result;
    }
}
