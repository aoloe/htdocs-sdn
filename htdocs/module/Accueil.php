<?php
// use function Aoloe\debug as debug;

class Accueil extends Aoloe\Module_abstract {
    public function __construct() {
        // $this->page_css = array('css/lightSlider.css');
    }

    private $opening = null;
    public function set_opening($opening) {$this->opening = $opening;}
    private $sidebar = array();
    public function set_sidebar($sidebar) {$this->sidebar = $sidebar;}

    public function get_content() {
        $result = "";
        $template = new Aoloe\Template();
        $markdown = new Aoloe\Markdown();
        $content_sidebar = array();
        $content = "<h1>Bienvenue!</h1>";
        // Aoloe\debug('opening', $this->opening);
        if (isset($this->opening)) {
            $markdown->clear();
            $content = $markdown->parse('content/opening/'.$this->opening);
        }
        // debug('sidebar', $this->sidebar);
        foreach ($this->sidebar as $item) {
            // debug('item', $item);
            switch ($item) {
                case 'facebook' :
                    if ($this->site->is_online()) {
                        $this->site->add_js('js/jquery.min.js', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
                        $this->site->add_js('js/jquery.anyslider.min.js');
                        include_once('library/Facebook.php');
                        $facebook = new Facebook();
                        $facebook_feed = $facebook->get_page_feed(161424603891516);
                        $template->clear();
                        $template->set('feed', $facebook_feed);
                        $content_sidebar[] = $template->fetch('template/accueil_sidebar_facebook.php');
                    }
                break;
                case 'magazine' :
                        include_once('module/Magazine.php');
                        $magazine = new Magazine();
                        $magazine->set_site($this->site);
                        $issue = $magazine->get_teaser();
                        // // debug('issue', $issue);
                        $template->clear();
                        $template->set('path', $this->site->get_path_relative());
                        $template->set('issue', $issue);
                        $content_sidebar[] = $template->fetch('template/accueil_sidebar_magazine.php');

                break;
                case 'news' :
                    include_once('module/News.php');
                    $news = new News();
                    $news->set_site($this->site);
                    $teaser = $news->get_teaser();
                    // debug('teaser', $teaser);
                    $template->clear();
                    $template->set('path', $this->site->get_path_relative());
                    $template->set('content', $teaser);
                    $content_sidebar[] = $template->fetch('template/accueil_sidebar_news.php');
                break;
                case 'last_changes' :
                    $markdown->clear();
                    $markdown->set_url_img_prefix($this->site->get_path_relative('content/'));
                    $markdown->set_url_a_prefix($this->site->get_path_relative());
                    if ($content_last_changes =  $markdown->parse('content/last_changes.md')) {
                        $template->clear();
                        $template->set('title', 'Mises à jour');
                        $template->set('content', $content_last_changes);
                        $content_sidebar[] = $template->fetch('template/accueil_sidebar_item.php');
                    }
                break;
            }
        }
        // debug('news_facebook', $news_facebook);
        // debug('news', $news);

        /*
        $markdown->clear();
        $content = $markdown->parse('content/accueil.md');
        */

        $template->clear();
        $template->set('content', $content);
        $template->set('sidebar', $content_sidebar);
        $result = $template->fetch('template/accueil.php');
        return $result;
    }
}
