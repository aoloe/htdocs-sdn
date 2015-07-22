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
            $parameter = null;
            if (strpos($item, ',') !== false) {
                list($item, $parameter) = explode(',', $item);
            }
            // Aoloe\debug('parameter', $parameter);
            switch ($item) {
                case 'facebook' :
                    if ($this->site->is_online()) {
                        $this->site->add_js('js/jquery.min.js', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
                        $this->site->add_js('js/jquery.anyslider.min.js');
                        include_once('library/Facebook.php');
                        $facebook = new Facebook();
                        $facebook_feed = $facebook->get_page_feed('100001743249948', '100001743249948', 'AWgirdIQ7k7i7zPZ');
                        $template->clear();
                        $template->set('feed', $facebook_feed);
                        $content_sidebar[] = $template->fetch('template/accueil_sidebar_facebook.php');
                    }
                break;
                case 'twitter' :
                    if (true || $this->site->is_online()) {
                        // TODO: if possible directly use simpkins/tweetledee
                        $this->site->add_js('js/jquery.min.js', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
                        $this->site->add_js('js/jquery.anyslider.min.js');
                        include_once('library/Twitter.php');
                        $twitter = new Twitter();
                        $twitter_feed = $twitter->get_page_feed('sdnch');
                        $template->clear();
                        $template->set('feed', $twitter_feed);
                        $content_sidebar[] = $template->fetch('template/accueil_sidebar_twitter.php');
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
                    $teaser = $news->get_teaser($parameter);
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
