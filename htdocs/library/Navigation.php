<?php
class Navigation {
    private $site_structure = null;
    private $url_segment = null;
    public function set_site_structure($structure) {$this->site_structure = $structure; }
    public function set_url_segment($url) {$this->url_segment = $url; }

    private function get($structure = null, $url_segment = null, $url_base = array()) {
        $navigation = array();
        if (is_null($structure)) {
            $structure = $this->site_structure;
        }
        if (is_null($url_segment)) {
            $url_segment = $this->url_segment;
        }
        foreach ($structure as $key => $value) {
            // debug('key', $key);
            // debug('value', $value);
            if (is_array($value) && array_key_exists('navigation', $value)) {
                $label = is_array($value['navigation']) ? $value['navigation']['label'] : $value['navigation'];
                $url = is_array($value['navigation']) && array_key_exists('url', $value['navigation']) ? $value['navigation']['url'] : $key;
                $item = array (
                    'url' => implode("/", array_merge($url_base, array($url))),
                    'label' => $label,
                    'active' => false,
                    'children' => array(),
                );
                if (in_array($key, $url_segment)) {
                    $item['active'] = true;
                    if (array_key_exists('children', $value)) {
                        $item['children'] = $this->get($value['children'], $url_segment, array_merge($url_base, array($url)));
                    }
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
            if ($item['active']) {
                $result .= "<li class=\"active\">".$item['label']."</li>\n";
            } else {
                $result .= "<li>";
                $result .= '<a href="/'.$item['url'].'">'.$item['label'].'</a>';
                $result .= "</li>\n";
            }
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
