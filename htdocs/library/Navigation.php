<?php
// use function Aoloe\debug as debug;
class Navigation {
    private $site_structure = null;
    private $url_structure = null;
    private $url_aliased = null;
    public function set_site_structure($structure) {$this->site_structure = $structure; }
    public function set_url_structure($url) {$this->url_structure = $url; }
    public function set_url_aliased($url) {$this->url_aliased = $url; }

    private function get($structure = null, $url_segment = null, $url_base = array()) {
        $navigation = array();
        if (is_null($structure)) {
            $structure = $this->site_structure;
        }
        if (is_null($url_segment)) {
            $url_segment = explode('/', $this->url_structure);
            /*
            if (is_array($value) && array_key_exists('navigation', $value) && (is_string($value['navigation']) || array_key_exists('show_alias', $value['navigation']) && $value['navigation']['show_alias'])) {
                if (isset($this->url_aliased)) {
                    $url_segment = explode('/', $this->url_aliased);
                } else {
                    // TODO: show an error? or url_structure?
                }
            } else {
                $url_segment = explode('/', $this->url_structure);
            }
            */
        }
        foreach ($structure as $key => $value) {
            // debug('key', $key);
            // debug('value', $value);
            if (is_array($value) && array_key_exists('navigation', $value) && (is_string($value['navigation']) || array_key_exists('label', $value['navigation']))) {
                $label = is_array($value['navigation']) ? $value['navigation']['label'] : $value['navigation'];
                $url = is_array($value['navigation']) && array_key_exists('url', $value['navigation']) ? $value['navigation']['url'] : $key;
                $item = array (
                    'url' => implode("/", array_merge($url_base, array($url))),
                    'label' => $label,
                    'active' => false,
                    'children' => array(),
                );
                // debug('key', $key);
                // debug('url_segment', $url_segment);
                if (reset($url_segment) == $key) {
                    $item['active'] = true;
                    if (array_key_exists('children', $value)) {
                        $item['children'] = $this->get($value['children'], array_slice($url_segment, 1), array_merge($url_base, array($url)));
                    }
                    // debug('active', $item['active']);
                }
                $navigation[] = $item;
            }
        }
        return $navigation;
    }

    public function get_rendered($navigation = null) {
        $result = "";
        if (is_null($navigation)) {
            $navigation = $this->get();
        }
        $result .= "<ul>\n";
        $children = array();
        foreach ($navigation as $item) {
            $result .= '<li'.($item['active'] ? ' class="active"' : '').'>';
            $result .= '<a href="/'.$item['url'].'">'.$item['label'].'</a>';
            $result .= "</li>\n";
            if (!empty($item['children'])) {
                $children = $item['children'];
            }
        }
        $result .= "</ul>\n";
        if (!empty($children)) {
            $result .= $this->get_rendered($children);
        }
        return $result;
    }
    /*
    function get_navigation_rendered($navigation) {
        $result = "";
        $result .= "<ul>\n";
        foreach ($navigation as $item) {
            $result .= "<li>";
            $result .= '<a href="/'.$item['url'].'">'.$item['label'].'</a>';
            if (!empty($item['children'])) {
                $result .= get_navigation_rendered($item['children']);
            }
            $result .= "</li>\n";
        }
        $result .= "</ul>\n";
        return $result;
    }
    */

}
