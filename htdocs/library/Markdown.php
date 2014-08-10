<?php
/**
 * wrapper around Michelf's markdown class.
 *
 * - it checks if a file exists before parsing it
 * - allow injecting prefixes for local links
 *
 * if set_text() has been used, the string will be used:
 * - if no file name is defined
 * - if the file has not been found
 * otherwise, parse() will return null
 */

namespace Aoloe;

use \Michelf\MarkdownExtra;

class Markdown {
    private $text = null;
    public function set_text($text) {$this->text = $text;}

    /**
     * string / array: if string it's prefixed, if array it's replaced at the beginning (key => value).
     * they're used on all local urls.
     * if url_prefix is set, img and a are ignored.
     *
     * limitations:
     * - do not put ")" in the images optional titles.
     */
    private $url_prefix = null;
    private $url_img_prefix = null;
    private $url_a_prefix = null;
    public function set_url_prefix($prefix) {$this->url_prefix = $prefix;}
    public function set_url_img_prefix($prefix) {$this->url_img_prefix = $prefix;}
    public function set_url_a_prefix($prefix) {$this->url_a_prefix = $prefix;}

    public function clear() {
        $this->text = null;
        $this->url_prefix = null;
        $this->url_img_prefix = null;
        $this->url_a_prefix = null;
    }

    /**
     * adding a prefix to img and a is for now done in a very naive form.
     * a real implementation that covers all cases should be added to Michelf's Markdown library
     */
    private function get_prefixed_local_url($string) {
        $result = $string;
        $img_prefix = isset($this->url_prefix) ? $this->url_prefix : $this->url_img_prefix;
        if (is_string($img_prefix)) {
            $img_prefix = array ("" => $img_prefix);
        }
        $a_prefix = isset($this->url_prefix) ? $this->url_prefix : $this->url_a_prefix;
        if (is_string($a_prefix)) {
            $a_prefix = array ("" => $a_prefix);
        }
        if (isset($img_prefix)) {
            // ![Alt text](/path/to/img.jpg "Optional title")
            foreach ($img_prefix as $key => $value) {
                $result = preg_replace('/!\[(.*?)\]\(((?!http[s]?:\/\/)'.$key.'.*?)\)/', '![\1]('.$value.'\2)', $result);
            }
        }
        if (isset($a_prefix)) {
            // debug('a_prefix', $a_prefix);
            // debug('result', $result);
            // [This link](http://example.net/ "title") 
            // <http://example.com/>
            foreach ($a_prefix as $key => $value) {
                $result = preg_replace('/[^!]\[(.*?)\]\(((?!http[s]?:\/\/|mailto:)'.$key.'.*?)\)/', '[\1]('.$value.'\2)', $result);
                // [![alt](local_img.png)](local_url)
                $result = preg_replace(
                    '/\['.
                        '(!\[.*?\]\(.*?\))'.
                    '\]'.
                    '\(((?!http[s]?:\/\/|mailto:)'.$key.'.*?)\)/', '[\1]('.$value.'\2)',
                    $result
                );
                // $result = preg_replace('/<((?!http[s]?:\/\/)'.$key.'\S*?)>/', '<'.$value.'\1>', $result); // <locallink> is not recognized as a link
            }
        }
        // debug('result', $result);
        return $result;
    }

    /**
     * return the file parsed from markdown to html or default_text (null) if the file has not been found
     */
    public function parse($filename = null) {
        $result = $this->text;
        if (is_null($filename) || file_exists($filename)) {
            if (isset($filename)) {
                $result = file_get_contents($filename);
            }
            $result = $this->get_prefixed_local_url($result);
            $result = MarkdownExtra::defaultTransform($result);
        }
        return $result;
    }
}