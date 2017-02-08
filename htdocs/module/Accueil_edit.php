<?php

/**
 * TODO:
 * - find a way to set a login (.htaccess for the edit/ path?)
 * - choose the active image and text (or none for image)
 * - rename the files and make sure that they current image and text are shown on the main page
 */

class Accueil_edit  extends Aoloe\Module_abstract {
    private $content_opening_path = 'content/opening/';
    private $content_alert = array();

    public function do_action() {
        if (array_key_exists('content', $_POST)) {
            // Aoloe\debug('_POST', $_POST);
            if (array_key_exists('filename', $_POST)) {
                if ($this->is_file_in_directory($this->content_opening_path.$_POST['filename'], $this->content_opening_path)) {
                    $this->save_text($_POST['filename'], $_POST['content']);
                }
            } elseif (array_key_exists('title', $_POST)) {
                $markdown_filename = $this->get_unique_filename($this->content_opening_path, 'md', $_POST['title']);
                $this->save_text($markdown_filename, $_POST['content']);
            }
        } elseif (array_key_exists('image_new', $_POST) && array_key_exists('file', $_FILES)) {
            $this->add_image();
        }

        if (!empty($this->content_alert)) {
            Aoloe\debug('content_alert', $this->content_alert);
        }
    }

    public function get_content() {
        $result = "";
        // Aoloe\debug('url_query', $this->url_query);

        if (array_key_exists('text_new', $_POST)) {
            $result = $this->get_content_edit();
        } elseif (!empty($this->url_query) ) {
            $result = $this->get_content_edit($this->url_query);
        } else {
            $result = $this->get_content_list();
        }
        return $result;
    }

    private function get_content_list() {
        $result = "";
        $dh  = opendir($this->content_opening_path);
        $text_list = array();
        while ($filename = readdir($dh)) {
            if (pathinfo($filename, PATHINFO_EXTENSION) == 'md') {
                $text_list[] = $filename;
            }
        }
        $dh  = opendir($this->content_opening_path.'images/');
        $image_list = array();
        while ($filename = readdir($dh)) {
            if ((pathinfo($filename,PATHINFO_EXTENSION) == 'jpg') && (substr($filename, 0, 3) == 'tn-')) {
                $image_list[] = $filename;
            }
        }
        // Aoloe\debug('image_list', $image_list);
        $template = new Aoloe\Template();
        $template->set('form_action', $_SERVER['REQUEST_URI']);
        $template->set('url_base', rtrim($_SERVER['REQUEST_URI'], '/').'/');
        $template->set('text_list', $text_list);
        $template->set('path_images', '/'.$this->content_opening_path.'images/');
        $template->set('image_list', $image_list);
        $result = $template->fetch('template/accueil_edit_list.php');

        // Aoloe\debug('result', $result);
        return $result;
    }

    private function get_content_edit($filename = null) {
        $result = "";

        // Aoloe\debug('filename', $filename);

        $markdown_content = null;
        if (is_null($filename)) {
            $markdown_content = '';
            $markdown_filename = '';
        } else {
            $markdown_filename = $filename;
            if ($this->is_file_in_directory($this->content_opening_path.$markdown_filename, $this->content_opening_path)) {
                $markdown_content = file_get_contents($this->content_opening_path.$markdown_filename);
            }
        }

        // Aoloe\debug('markdown_filename', $markdown_filename);
        if (isset($markdown_content)) {
            $template = new Aoloe\Template();
            $template->set('form_action', empty($markdown_filename) ? $_SERVER['REQUEST_URI'] : dirname($_SERVER['REQUEST_URI']));
            $template->set('filename', $markdown_filename);
            $template->set('content', $markdown_content);
            $result = $template->fetch('template/accueil_edit.php');
        } else {
            $result = "<p>File not found</p>";
        }
        return $result;
    }

    private function save_text($filename, $content) {
        file_put_contents($this->content_opening_path.$filename, $content);
    }

    private function add_image() {
        // Aoloe\debug('_FILES', $_FILES);
        // name the image uniqeid().'.jpg'
        $image_size = getimagesize($_FILES['file']['tmp_name']);
        // Aoloe\debug('image_size', $image_size);
        if ($image_size !== false) {
            // TODO: eventually resize the image to be of a sane size
            $filename = $this->get_unique_filename($this->content_opening_path.'images/', 'jpg');
            if (move_uploaded_file($_FILES['file']['tmp_name'], $this->content_opening_path.'images/'.$filename)) {
                $image = imagecreatefromjpeg($this->content_opening_path.'images/'.$filename);
                $thumbnail_width = 150;
                $thumbnail_height = floor( $image_size[1] * ( $thumbnail_width / $image_size[0]) );
                $thumbnail = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
                imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $image_size[0], $image_size[1]);
                imagejpeg($thumbnail, $this->content_opening_path.'images/'.'tn-'.$filename);
            } else {
                $this->content_alert[] = "Failed to create the image";
            }
        } else {
            $this->content_alert[] = "Upload is not a valid image";
        }
    }

    private function get_unique_filename($path, $ext, $title = '') {
        $result = null;
        $title = preg_replace("/[^a-z0-9]+/", "", strtolower($title));
        $result = date('Ymd').(empty($title) ? '' : '-'.$title);
        $result_length = strlen($result);
        $result .= '.'.$ext;
        $i = 0;
        while (file_exists($path.$result)) {
            $result = substr($filename, 0, $result_length).'-'.str_pad($i++, 2, '0', STR_PAD_LEFT).'.'.$ext;
        }
        // Aoloe\debug('result', $result);
        return $result;
    }

    private function is_file_in_directory($file_path, $directory_path) {
        return (realpath($directory_path) == dirname(realpath($file_path)) && file_exists($file_path));
    }
}
