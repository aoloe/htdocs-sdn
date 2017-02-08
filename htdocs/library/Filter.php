<?php

// use function Aoloe\debug as debug;

class Filter {
    private $filter_name = null;
    public function set_filter($name) {$this->filter_name = $name;}
    private $language = null;
    public function set_language($language) {$this->language = $language;}
    /*
    public function get_placeholder_cleanded($content) {
        return preg_replace('/{{[`]?(+*?)[`]}}/', '{{\1}}', $content);
    }
    */
    private function get_filter_by_name($filter_name) {
        $result = null;
        $file_name = 'filter/'.$this->filter_name.'.php';
        if (file_exists($file_name)) {
            include_once($file_name);
        }
        if (class_exists($this->filter_name)) {
            $result = new $this->filter_name();
        }
        return $result;
    }

    public function parse($content) {
        $filter = null;
        $filter = $this->get_filter_by_name($this->filter_name);
        if (isset($filter)) {
            $filter->set_language($this->language);
            $matches = array();
            preg_match_all('/{{[`]?%'.strtolower($this->filter_name).'%(.*?)[%]?[`]?}}/', $content, $matches);
            // Aoloe\debug('matches', $matches);
            if (!empty($matches)) {
                foreach ($matches[0] as $key => $value) {
                    // debug('key', $key);
                    // debug('value', $value);
                    // debug('matches[1][key]', $matches[1][$key]);
                    if (!empty($matches[1][$key])) {
                        $filter->set_parameter($matches[1][$key]);
                    }
                    $content = str_replace($value, $filter->parse($content), $content);
                    // $content = preg_replace('/'.$value.'/', 'red', $content);
                }
            }
        }
        return $content;
    }
}

class Filter_abstract {
    protected $language = null;
    public function set_language($language) {$this->language = $language;}
    protected $parameter = null;
    public function set_parameter($parameter) {$this->parameter = $parameter;}
    public function parse($content) {
        return '';
    }
}
