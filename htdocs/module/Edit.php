<?php
class Edit extends Aoloe\Module_abstract {
    private $module = null;
    public function set_module($module) {$this->module = $module;}

    public function get_content() {
        $result = "";
        Aoloe\debug('module', $this->module);
        Aoloe\debug('url_query', $this->url_query);
        if (!empty($this->module)) {
            if (isset($this->url_query)) {
                $url_segement = explode('/', $this->url_query);
                $module_name = reset($url_segement);
                if (in_array($module_name, $this->module)) {
                    $module_file = 'module/'.$module_name.'_edit.php';
                    if (file_exists($module_file)) {
                        include_once($module_file);
                        $class = $module_name."_edit";
                        $module_edit = new $class();
                        $module_edit->set_url_query(implode("/", array_slice($url_segement, 1)));
                        $result = $module_edit->do_action();
                        $result = $module_edit->get_content();
                    } else {
                        $result = "<p>".$this->url_query." does not implement edit.</p>";
                    }
                }
            } else {
                $result = $this->get_content_list();
            }
        } else {
            $result = "<p>Editing</p>";
        }
        return $result;
    }

    private function get_content_list() {
        $result = "";
        $module = array();
        $result = '<ul>'.implode("\n", array_map(function($item) {return '<li><a href="/edit/'.$item.'">'.$item.'</a></li>';}, $this->module)).'</ul>';
        return $result;
    }
}

