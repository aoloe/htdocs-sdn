<?php

/**
 * show calendar entries from defined in a yaml file. first the future events, then the past ones.
 * events get unpublished after two years
 *
 * content/calendar.yaml format (* optional fields):
 *  - start : 20140810
 *    end* : 20140811
 *    date* : Samedi 11 octobre
 *    title : test of the website
 *    url* : actualite/nouvelles/20140811_test
 *    content* : |
 *      this is the content of the page
 *      [with a link](test/blah)
 *
 *      and an ![image](url.png)
 */

use function Aoloe\debug as debug;

class Calendar extends Module_abstract {
    private $calendar_file = 'content/calendar.yaml';
    private $calendar = null;
    private $unpublish_age = 63072000; // 60*60*24*365*2 = 2 years
    public function __construct() {
        if (file_exists($this->calendar_file)) {
            $this->calendar = file_get_contents($this->calendar_file);
            $this->calendar = Spyc::YAMLLoadString($this->calendar);
        }
        // debug('calendar', $this->calendar);
    }
    public function get_content() {
        include_once('library/Markdown.php');
        $markdown = new Aoloe\Markdown();

        $template = new Aoloe\Template();

        $calendar_future = array();
        $calendar_past = array();
        $now = date('Ymd');
        // debug('now', $now);
        foreach ($this->calendar as $item) {
            $calendar_content = null;
            if (array_key_exists('content', $item)) {
                $markdown->clear();
                $markdown->set_text($item['content']);
                $calendar_content = $markdown->parse();
            }
            $calendar_item = array (
                'start' => date("d.m.Y", strtotime($item['start'])),
                'end' => array_key_exists('end', $item) ? date("d.m.Y", strtotime($item['end'])) : '',
                'date' => array_key_exists('date', $item) ? $item['date'] : '',
                'title' => $item['title'],
                'url' => array_key_exists('url', $item) ? $this->site->get_path_relative($item['url']) : null,
                'content' => $calendar_content,
            );
            $unpublish = time() - strtotime(array_key_exists('end', $item) ? $item['end'] : $item['start']);
            // debug('strtotime', date("Y M d", strtotime(array_key_exists('end', $item) ? $item['end'] : $item['start'])));
            // debug('unpublish', $unpublish);
            if (($item['start'] >= $now) || (array_key_exists('end', $item) && ($item['end'] > $now))) {
                $calendar_future[] = $calendar_item;
            } elseif ($unpublish < $this->unpublish_age) {
                $calendar_past[] = $calendar_item;
            }
        }
        usort($calendar_future, function($a, $b) {$a['start'] >= $b['start'];});
        usort($calendar_past, function($a, $b) {$a['start'] >= $b['start'];});
        // debug('calendar_future', $calendar_future);
        // debug('calendar_past', $calendar_past);
        
        $template->clear();
        $template->set('path', $this->site->get_path_relative());
        $template->set_template('template/calendar_item.php');
        $content_future = array();
        foreach ($calendar_future as $item) {
            $template->set('item', $item);
            $content_future[] = $template->fetch();
        }
        $content_past = array();
        foreach ($calendar_past as $item) {
            $template->set('item', $item);
            $content_past[] = $template->fetch();
        }

        $template->clear();
        $template->set('path', $this->site->get_path_relative());
        $template->set('calendar_future', $content_future);
        $template->set('calendar_past', $content_past);
        $result = $template->fetch('template/calendar.php');
        return $result;
    }
    public function get_teaser() {
        $result =  array();
        return $result;
    }
}

