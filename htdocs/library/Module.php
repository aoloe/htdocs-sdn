<?php
class Module {
    private $module = null;
    private $parameter = null;
    public function set($module, $parameter) {
        $this->module = $current;
        $this->parameter = $parameter;
    }
    public function set_module($module) {$this->module = $module;}
    public function set_parameter($parameter) {$this->parameter = $parameter;}

    private $site = null;
    public function set_site($site) {$this->site = $site;}


    /**
     * @return if null no further rendering necessary, otherwise integrage
     * the returned value in the main template's content
     */
    public function get_rendered() {
        $result = null;
        include_once('library/Module_abstract.php');
        $result = "<p>Module ".$this->module." is not valid.</p>\n";
        $module_file = 'module/'.$this->module.'.php';
        if (file_exists($module_file)) {
            include_once($module_file);
            if (class_exists($this->module)) {
                $module = new $this->module();
                $module->set_site($this->site);
                foreach ($this->parameter as $key => $value) {
                    if (method_exists(get_class($module), 'set_'.$key)) {
                        // debug('key', $key);
                        // debug('value', $value);
                        $module->{'set_'.$key}($value);
                    }
                }
                $result = $module->get_content();
            }
        }
        return $result;
    }
}
