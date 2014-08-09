<?php
use \Michelf\MarkdownExtra;
use function Aoloe\debug as debug;
class Module_abstract {
    protected $page_css = array();
    public function get_css() {return $this->page_css;}
    protected $page_js = array();
    public function get_js() {return $this->page_js;}
    protected $page_fonts = array();
    public function get_fonts() {return $this->page_fonts;}
    public function get_content() {return "";}
}

class Accueil extends Module_abstract {
    public function __construct() {
        // $this->page_css = array('css/lightSlider.css');
        $this->page_js = array (
            get_web_ressource('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', 'js/jquery.min.js'),
            'js/jquery.lightSlider.min.js',
            'js/jquery.anyslider.min.js',
        );
    }

    private $show = array();
    public function set_show($show) {$this->show = $show;}

    public function get_content() {
        $result = "";
        $template = new Aoloe\Template();
        include_once('library/Facebook.php');
        $content_facebook = null;
        $facebook = new Facebook();
        // debug('get_web_ressource', get_web_ressource());
        // debug('show', $this->show);
        foreach ($this->show as $item) {
            // debug('item', $item);
            switch ($item) {
                case 'facebook' :
                    if (get_web_ressource()) {
                        $facebook_feed = $facebook->get_page_feed(161424603891516);
                        $template->clear();
                        $template->set('feed', $facebook_feed);
                        $content_facebook = $template->fetch('template/accueil_sidebar_facebook.php');
                    }
            }
        }
        // debug('news_facebook', $news_facebook);
        // debug('news', $news);
        
        $template->clear();
        $template->set('facebook', $content_facebook);
        $template->set('news', array());
        $content_news = $template->fetch('template/accueil_news.php');

        $template->clear();
        $file_content = 'content/accueil.md';
        if (file_exists($file_content)) {
            $content = file_get_contents($file_content);
            $content = MarkdownExtra::defaultTransform($content);
        }
        $template->set('content', $content);
        $template->set('facebook', $content_news);
        $template->set('news', $content_news);
        $result = $template->fetch('template/accueil.php');
        return $result;
    }
}
