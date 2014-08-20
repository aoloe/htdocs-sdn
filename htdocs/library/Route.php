<?php

new Aoloe\Debug();
use function Aoloe\debug as debug;

class Route {
    private $url_request = null;
    private $url_segment = null;
    public function set_url_request($url) {
        $this->url_request = $url;
        $this->url_segment = array_slice(explode('/', $url), 1);
    }
    public function get_url_segment() {return $this->url_segment;}
    public function read_url_request() {
        $this->set_url_request(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }
    public function is_url_request($url = null) {
        return is_null($url) ? isset($this->url_request) : ($this->url_request == $url);
    }

    private $structure = null;
    public function set_structure($structure) {$this->structure = $structure;}

    private $module_default = 'Page';
    public function set_module_default($module) {$this->module_default = $module_404;}
    private $module_404 = 'Error_404';
    public function set_module_404($module) {$this->module_404 = $module_404;}
    private $module_301 = 'Error_301';
    public function set_module_301($module) {$this->module_301 = $module_301;}
    private $redirect_301 = null; // array of urls to be redirected if not found and target
    public function set_redirect_301($redirect) {$this->redirect_301 = $redirect_301;}

    private $page = null;
    private $page_query = null;
    public function read_current_page() {
        list($this->page, $this->page_query) = $this->get_current_page($this->url_segment, $this->structure);
        // debug('page', $this->page);
        // debug('page_query', $this->page_query);
    }
    private function get_current_page($url_segment, $structure) {
        $page = null;
        $page_query = null;
        $url = reset($url_segment);
        // debug('url', $url);
        if (array_key_exists($url, $structure)) {
            $page = array();
            // debug('url_segment', $url_segment);
            if (count($url_segment) > 1) {
                if (array_key_exists('query', $structure[$url]) && ($structure[$url]['query'] == 'url')) {
                    $page = $structure[$url];
                    $page_query = implode('/', array_slice($url_segment, 1));
                } elseif (array_key_exists('children', $structure[$url])) {
                    list($page, $page_query) = $this->get_current_page(array_slice($url_segment, 1), $structure[$url]['children']);
                }
            } else {
                $page = $structure[$url];
            }
        }
        return array($page, $page_query);
    }

    function get_current_module($page = null) {
        $result = null;
        if (is_null($page)) {
            $page = $this->page;
        }
        // debug('page', $page);
        if (isset($page)) {
            if (array_key_exists('alias', $page)) {
                // should it set $this->page instead of $page?
                list($page, $page_query) = $this->get_current_page(explode('/', $page['alias']), $this->structure);
                // debug('page', $page);
                $result = $this->get_current_module($page);
            } elseif (array_key_exists('module', $page)) {
                $result = is_array($page['module']) ? $page['module'] : array('name' => $page['module']);
            } else {
                $result = array('name' => $this->module_default);
            }
        }
        if (is_null($result)) {
            $result = $this->get_error_module();
        }
        if (!array_key_exists('parameter', $result)) {
            $result['parameter'] = array();
        }
        return $result;
    }

    function get_error_module() {
        $result = null;
        if (isset($this->url_redirect)) {
            if (array_key_exists($url_request, $this->url_redirect)) {
                $result = array('name' => $this->module_301, 'parameter' => $this->url_redirect[$url_request]);
            }
        }
        if (is_null($result)) {
            $result = array('name' => $this->module_404);
        }
        return $result;
    }
}
