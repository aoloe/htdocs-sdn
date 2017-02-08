<?php

/**
 * Counts the days until a give date
 *
 * Usage: {{%counter%2016-11-27}}
 */

// use function Aoloe\debug as debug;

class Counter extends Filter_abstract {

    private function days_until($date){
            return (isset($date)) ? floor((strtotime($date) - time())/60/60/24) : false;
    }

    public function parse($content) {
        $result = '';
        // Aoloe\debug('content', $content);
        if (isset($this->parameter)) {
            $result =  $this->days_until($this->parameter);
        }
        return $result;
    }
}

