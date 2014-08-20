<?php
// use function Aoloe\debug as debug;

class Error_404 extends Module_abstract {
    public function get_content() {
        header("HTTP/1.0 404 Not Found");
        return "<p>La page demandée n'existe pas.</p>";
    }
}
