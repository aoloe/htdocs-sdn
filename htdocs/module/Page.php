<?php

class Page extends Aoloe\Module_abstract {
    private $pages_path = 'content/page/';

    public function get_content() {

        $result = "this is a page";

        // Aoloe\debug('filter', $this->filter);
        // Aoloe\debug('site', $this->site);
        // Aoloe\debug('page_url', $this->page_url);
        // Aoloe\debug('url_structure', $this->url_structure);
        // TODO: make sure that page_url cannot deliver a path that is outside of pages_path
        $file_name = $this->pages_path.str_replace('/', '_', $this->page_url).'.md';
        // Aoloe\debug('file_name', $file_name);
        if (file_exists($file_name)) {
            $markdown = new Aoloe\Markdown();
            $markdown->set_url_img_prefix($this->site->get_path_relative($this->pages_path));
            $markdown->set_url_a_prefix($this->site->get_path_relative());

            if (isset($this->filter)) {
                if (file_exists($file_name)) {
                    include_once('library/Filter.php');
                    $page_content = file_get_contents($file_name);
                    foreach ($this->filter as $item) {
                        // Aoloe\debug('page_content', $page_content);
                        $filter = new Filter();
                        $filter->set_language($this->language);
                        $filter->set_filter($item);
                        $page_content = $filter->parse($page_content);
                        // Aoloe\debug('page_content', $page_content);
                    }
                    // TODO: it does not seem to be parsing the markdown in html tags
                    // Aoloe\debug('page_content', $page_content);
                    $markdown->set_text($page_content);
                    $result =  $markdown->parse();
                }
            } else {
                $result =  $markdown->parse($file_name);
            }
        }
        return $result;

        /*
        $page_content = "";
        if (isset($this->page_content)) {
            $page_content = $this->page_content;
        } else {
            $markdown->clear();
            $markdown->set_url_img_prefix($this->site->get_path_relative('content/'));
            $markdown->set_url_a_prefix($this->site->get_path_relative());
            // debug('language', $this->language);
            // debug('page_url', $this->page_url);
            // debug('filter', $this->filter);
            $file_name = 'content/'.$this->language.'/'.$this->page_url.'.md';
            if (isset($this->filter)) {
                if (file_exists($file_name)) {
                    include_once('library/Filter.php');
                    $page_content = file_get_contents($file_name);
                    foreach ($this->filter as $item) {
                        $filter = new Filter();
                        $filter->set_language($this->language);
                        $filter->set_filter($item);
                        $page_content = $filter->parse($page_content);
                    }
                    $markdown->set_text($page_content);
                    $page_content =  $markdown->parse();
                }
            } else {
                // debug('file_name', $file_name);
                $page_content =  $markdown->parse($file_name);
                // debug('page_content', $page_content);
            }
        }

        $template = new Aoloe\Template();
        $template->set('content', $page_content);
        $result = $template->fetch('template/index.php');
        return $result;
        */
    }

    private function get_pages_list() {
        $result = array();
        return $result;
    }
}
