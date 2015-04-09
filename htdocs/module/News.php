<?php

if (!defined('SCANDIR_SORT_DESCENDING')) {
    define('SCANDIR_SORT_DESCENDING', 1); // until php 5.4
}

// use function Aoloe\debug as debug;

class News extends Aoloe\Module_abstract {
    private $news_path = 'content/news/';
    private $archive_name = 'archive';
    private $archive = false;

    /**
     * @return the path where the news are, using $this->archive to check if it's in
     * archive mode.
     */
    private function get_news_path($directory = null) {
        return $this->news_path.(isset($directory) ? trim($directory, '/').'/' : '');
    }

    /**
     * get the list of the md files in $news_path or one of its subdirectories
     */
    private function get_news_list($directory = null) {
        $result = array();

        $path = $this->get_news_path(isset($directory) ? $directory : null);
        // Aoloe\debug('path', $path);

        return  array_filter(
            scandir($path, SCANDIR_SORT_DESCENDING),
            function ($item) {
                return (($item != 'README.md') && (substr($item, -3) == '.md'));
            }
        );
        return $result;
    }

    private function get_content_markdown($filename, $directory = null) {
        $result = "";
        $path = $this->get_news_path($directory);
        $markdown = new Aoloe\Markdown();
        // Aoloe\debug('path', $path);
        $detail = file_get_contents($path.$filename);
        $markdown->clear();
        $markdown->set_text($detail);
        $result = $markdown->parse();
        return $result;
    }

    private function get_teaser_markdown($filename, $directory = null) {
        $result = "";
        $markdown = new Aoloe\Markdown();
        // Aoloe\debug('directory', $directory);
        $news_teaser = file_get_contents($this->get_news_path($directory).$filename);
        // show each article up to <!-- teaser !>, otherwise just the title
        if ($position = strpos($news_teaser, '<!-- teaser -->')) {
            $news_teaser = substr($news_teaser, 0, $position);
        } else {
            $news_teaser = substr($news_teaser, 0, strpos($news_teaser, "\n"));
        }
        $news_teaser = preg_replace('/(#+)/', '#\1', $news_teaser);
        // TODO: use the current url instead of actualite/news
        $news_url = $this->site->get_path_relative($this->url_request.'/'.pathinfo($filename, PATHINFO_FILENAME));
        $news_teaser = preg_replace('/^##(.*?)\n/', '##[\1]('.$news_url.')', $news_teaser);
        $news_teaser .= "\n\n[Lire l'article...](".$news_url.")";
        // debug('news_teaser', $news_teaser);
        $markdown->clear();
        $markdown->set_text($news_teaser);
        $result = $markdown->parse();
        return $result;
    }
    
    public function get_content() {
        $content_news_detail = null;
        $detail_filename = null;

        // TODO: as soon as we know how to sanitize below, only read the list when no article chosen
        if (isset($this->url_query) && (trim($this->url_query, '/') == $this->archive_name)) {
            $this->archive = true;
        }

        $news_list = $this->get_news_list($this->archive ? $this->archive_name : null);

        if (isset($this->url_query) && !$this->archive) {
            // Aoloe\debug('news_list', $news_list);

            // Aoloe\debug('url_query', $this->url_query);
            $detail_filename = $this->url_query.'.md';
            $content_news_detail = null;
            if (in_array($detail_filename, $news_list)) {
                $content_news_detail = $this->get_content_markdown($detail_filename);
                // debug('content_news_detail', $content_news_detail);
            } else {
                $archive_list = $this->get_news_list($this->archive_name);
                if (in_array($detail_filename, $archive_list)) {
                    $content_news_detail = $this->get_content_markdown($detail_filename, $this->archive_name);
                }
                $this->archive = false;
            }
            // TODO: sanitize url_query so that i cannot read outside of news_path
            // (or check that the one is a subpath of the other)
        }

        // $news_list = $this->get_news_list();

        // Aoloe\debug('archive', $this->archive);
        $content_news = array();
        foreach ($news_list as $item) {
            // Aoloe\debug('item', $item);
            if (isset($detail_filename) && ($detail_filename == $item)) {
                continue;
            }
            $content_news[] = $this->get_teaser_markdown($item, $this->archive ? $this->archive_name : null);
            // TODO: ### in list of news should just be shown as bold
        }

        if (is_null($content_news_detail)) {
            $markdown = new Aoloe\Markdown();
            $markdown->set_url_prefix($this->site->get_path_relative());
            $content_sidebar = $markdown->parse('content/news_sidebar.md');

            $template = new Aoloe\Template();
            $template->clear();
            $template->set('path', $this->site->get_path_relative());
            $template->set('content', $content_news);
            // TODO: do we want the list of news in the sidebar while showing the details?
            $template->set('sidebar', $content_sidebar);
            $result = $template->fetch('template/news.php');
        } else {
            $template = new Aoloe\Template();
            $template->clear();
            $template->set('path', $this->site->get_path_relative());
            $template->set('content', $content_news_detail);
            // TODO: do we want the list of news in the sidebar while showing the details?
            $template->set('sidebar', $content_news);
            $result = $template->fetch('template/news_detail.php');
        }
        return $result;
    }

    /**
     * if there is a .md file in content/news_teaser/ use it instead of the latest article?
     * (and also the picture in there...)
     */
    public function get_teaser($number = null) {
        $result = "";
        $markdown = new Aoloe\Markdown();
        if (is_null($number)) {
            $first = $last = 0;
        } elseif (strpos($number, '-')) {
            list($first,$last) = explode('-', $number);
            $first--;
            $last--;
        } else {
            $first = $last = $number - 1;
        }

        $news_list = $this->get_news_list();
        $start = 0;
        $end = count($news_list);
        if ($first > $last) {
            $news_list = array_reverse($news_list);
            list($start, $end) = array($end, $start);
        }
        // Aoloe\debug('start', $start);
        // Aoloe\debug('end', $end);
        // Aoloe\debug('first', $first);
        // Aoloe\debug('last', $last);
        // die();

        if (file_exists('content/news/teaser/teaser.md')) {
            $news_teaser = file_get_contents('content/news/teaser/teaser.md');
            $markdown->set_url_img_prefix($this->site->get_path_relative('content/news/teaser/'));
            $markdown->set_url_a_prefix($this->site->get_path_relative());
            $markdown->set_text($news_teaser);
            $result = $markdown->parse();
        }
        if ((count($news_list) > 0) && ($start > 0)) {
            // debug('number', $number);
            for ($i = $start; ($start <= $end) ? ($i < $end) : ($i >= $end); ($start <= $end) ? $i++ : $i--) {
                $news = array_shift($news_list);
                // Aoloe\debug('i', $i);
                if (($i <= max($first, $last)) && ($i >= min($first, $last))) {
                    // Aoloe\debug('i ok', $i);
                    // Aoloe\debug('news', $news);
                    $news_teaser = file_get_contents($this->get_news_path().$news);
                    $news_teaser = substr($news_teaser, 0, strpos($news_teaser, "\n"));
                    $news_teaser = preg_replace('/(#+)/', '##\1', $news_teaser);
                    $news_url = $this->site->get_path_relative('actualite/nouvelles/'.pathinfo($news, PATHINFO_FILENAME));
                    $news_teaser .= "\n\n[Lire l'article...](".$news_url.")";
                    $markdown->set_url_prefix($this->site->get_path_relative());
                    $markdown->set_text($news_teaser);
                    $result .= $markdown->parse();
                }
            }
        }
        if (empty($result)) {
            $result = "<p>no teaser yet</p>\n";
        }
        return $result;
    }
}
