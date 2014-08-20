<?php
// use function Aoloe\debug as debug;

class Error_301 extends Module_abstract {
    public function get_content() {
        header("Location: /foo.php",TRUE,301);
        return null;
    }
}
