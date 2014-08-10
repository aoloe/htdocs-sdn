<?php

use function Aoloe\debug as debug;

class Magazine extends Module_abstract {
    private $issue_file = 'content/magazine.yaml';
    private $issue = null;
    public function __construct() {
        if (file_exists($this->issue_file)) {
            $this->issue = file_get_contents($this->issue_file);
            $this->issue = Spyc::YAMLLoadString($this->issue);
        }
        // debug('issue', $this->issue);
    }
    private  function get_magazine_item($item) {
       return array ( 
            'icon' => strtr(
                'content/magazine/icons/sdn_journal_%issue.png',
                array(
                    '%issue' => $item['issue'],
                )
            ),
            'label' => strtr(
                '%issue - %month %year',
                array(
                    '%issue' => $item['issue'],
                    '%month' => $item['month'],
                    '%year' => $item['year'],
                    )
            ),
            'alt' => strtr(
                'Journal Sortir du Nucléaire %issue - %month %year',
                array(
                    '%issue' => $item['issue'],
                    '%month' => $item['month'],
                    '%year' => $item['year'],
                    )
            ),
            'link' => strtr(
                'content/magazine/pdf/sdn_journal_%issue.pdf',
                array(
                    '%issue' => $item['issue'],
                )
            ),
            'month' => strtolower($item['month']),
        );
    }
    public function get_content() {
        $magazine = array();
        foreach ($this->issue as $item) {
            if (!array_key_exists($item['year'], $magazine)) {
                $magazine[$item['year']] = array();
            }
            $magazine[$item['year']][$item['issue']] = $this->get_magazine_item($item);
        }
        // debug('magazine', $magazine);

        $template = new Aoloe\Template();
        $template->clear();
        $template->set('path', $this->site->get_path_relative());
        $template->set('magazine', $magazine);
        $result = $template->fetch('template/magazine.php');
        return $result;
    }
    public function get_teaser() {
        $issue = reset($this->issue);
        $issue = $this->get_magazine_item($issue);
        // debug('issue', $issue);
        return $issue;
    }
}

