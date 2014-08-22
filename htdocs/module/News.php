<?php

// use function Aoloe\debug as debug;

class News extends Aoloe\Module_abstract {
    private $news_path = 'content/news/';

    private function get_news_list() {
        $result = array();
        return  array_filter(
            scandir($this->news_path),
            function ($item) {
                return ($item != 'README.md') && (substr($item, 0, 1) != '.');
            }
        );
        return $result;
    }
    
    public function get_content() {
        $markdown = new Aoloe\Markdown();

        $content_news = array();
        foreach ($this->get_news_list() as $item) {
            // debug('item', $item);
            $news_teaser = file_get_contents($this->news_path.$item);
            // show each article up to <!-- teaser !>, otherwise just the title
            if ($position = strpos($news_teaser, '<!-- teaser -->')) {
                $news_teaser = substr($news_teaser, 0, $position);
            } else {
                $news_teaser = substr($news_teaser, 0, strpos($news_teaser, "\n"));
            }
            $news_teaser = preg_replace('/(#+)/', '#\1', $news_teaser);
            $news_url = $this->site->get_path_relative('actualite/news/'.pathinfo($item, PATHINFO_FILENAME));
            $news_teaser = preg_replace('/^##(.*?)\n/', '##[\1]('.$news_url.')', $news_teaser);
            $news_teaser .= "\n\n[Lire l'article...](".$news_url.")";
            // debug('news_teaser', $news_teaser);
            $markdown->clear();
            $markdown->set_text($news_teaser);
            $content_news[] = $markdown->parse();
            // TODO: ### in list of news should just be shown as bold
        }

        $markdown->clear();
        $markdown->set_url_prefix($this->site->get_path_relative());
        $content_sidebar = $markdown->parse('content/news_sidebar.md');

        $template = new Aoloe\Template();
        $template->clear();
        $template->set('path', $this->site->get_path_relative());
        $template->set('content', $content_news);
        $template->set('sidebar', $content_sidebar);
        $result = $template->fetch('template/news.php');
        return $result;
    }

    /**
     * if there is a .md file in content/news_teaser/ use it instead of the latest article?
     * (and also the picture in there...)
     */
    public function get_teaser() {
        $result = "";
        $markdown = new Aoloe\Markdown();
        if (file_exists('content/news_teaser/teaser.md')) {
            $news_teaser = file_get_contents('content/news_teaser/teaser.md');
            $markdown->set_url_img_prefix($this->site->get_path_relative('content/news_teaser/'));
            $markdown->set_url_a_prefix($this->site->get_path_relative());
            $markdown->set_text($news_teaser);
            $result = $markdown->parse();
        } elseif (count($news = $this->get_news_list()) > 0) {
            $news = reset ($news);
            // debug('news', $news);
            $news_teaser = file_get_contents($this->news_path.$news);
            $news_teaser = substr($news_teaser, 0, strpos($news_teaser, "\n"));
            $news_teaser = preg_replace('/(#+)/', '#\1', $news_teaser);
            $news_url = $this->site->get_path_relative('actualite/news/'.pathinfo($news, PATHINFO_FILENAME));
            $news_teaser .= "\n\n[Lire l'article...](".$news_url.")";
            $markdown->set_url_prefix($this->site->get_path_relative());
            $markdown->set_text($news_teaser);
            $result = $markdown->parse();
        } else {
            $result = "<p>no teaser yet</p>\n";
        }
        return $result;
    }
}
