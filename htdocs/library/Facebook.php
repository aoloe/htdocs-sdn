<?php
/**
 * get the feed from a facebook page
 * - cache the result for one hour
 * - cleanup the links
 * - cleanup the title and remove it from the content
 * - move the image to the beginning of the post
 *
 * inspired by https://gist.github.com/banago/3864515
 */

use function Aoloe\debug as debug;

class Facebook {
    private function get_cleaned_description($description) {
        $result = $description;
        $result = preg_replace('/ onclick="[^"]*"/', '', $result);
        $result = preg_replace('/ onmouseover="[^"]*"/', '', $result);
        // $result = preg_replace('/"l.php?u=([^"]+)"/', '\1', $result);
        $result = preg_replace('/"\/l.php\?u=(.*?)"/', '"\1"', $result);
        // $result = preg_replace('/\&amp;h=(.*)\&amp;s=1/', '', $result);
        $result = preg_replace('/\&amp;h=[^&]+&amp;s=\d/', '', $result);
        $result = preg_replace_callback(
            "/http%3A%2F%2F.+\"/",
            function($matches) {
                return urldecode($matches[0]);
            },
            $result
        );
        return $result;
    }

    private function get_cleaned_entities($string) {
        return str_replace('%andamp;', '&amp;', html_entity_decode(str_replace('&amp;', '%andamp;', $string)));
    }

    // TODO: or call this extract_image?
    private function get_formatted_description($description) {
        $result = $description;
        // TODO: put the image at the beginning
        return $result;
    }

    private function is_valid_html($string) {
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        $xml = simplexml_load_string($string);
        // debug('libxml_get_errors', libxml_get_errors());
        return count(libxml_get_errors())==0;
    }

    public function get_feed($url) {
        $result = null;
        $curl = curl_init();
     
        // You need to query the feed as a browser.
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: "; // browsers keep this blank.
     
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, '');
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
     
        $raw_xml = curl_exec($curl); // execute the curl command
        curl_close($curl); // close the connection
        // debug('raw_xml', $raw_xml);
        
        $result = simplexml_load_string( $raw_xml );
        return $result;
    }

    public function get_page_feed( $page_id, $no = 5 ) {
        $result = array();

        $cache = new Aoloe\Cache();
        $cache->set_file('facebook_news.json');
        $cache->set_timeout(36000); // 60*60 = 1 hour
        $result = $cache->get();

        // debug('news_facebook', $news_facebook);
        if (is_null($result)) {
            // URL to the Facebook page's RSS feed.
            // debug('page_id', $page_id);
            $xml = $this->get_feed('http://www.facebook.com/feeds/page.php?id=' . $page_id . '&format=rss20');
            // debug('xml', $xml);

            $i = 1;
            if (isset($xml)) {
                foreach( $xml->channel->item as $item ) {
                    $item = array(
                        'title' => trim(str_replace("\n", '<br /> ', $this->get_cleaned_entities($item->title->__toString()))),
                        'url' => $item->link->__toString(),
                        'date' => $item->pubDate->__toString(),
                        'author' => $this->get_cleaned_entities($item->author->__toString()),
                        'content' => trim($this->get_cleaned_entities($this->get_cleaned_description($item->description->__toString()))),
                    );
                    if (($break = strpos($item['title'], '<br /> <br />')) !== false) {
                        // debug('break', $break);
                        $item['title'] = substr($item['title'], 0, $break);
                        $item['content'] = substr($item['content'], $break + 14);
                    } elseif (substr($item['title'], -3) == '...') {
                        $item['title'] = '';
                    } else {
                        $item['content'] = substr($item['content'], strlen($item['title']) + 11);
                    }

                    $item['content'] = preg_replace('/(.+?)(<a [^>]+?'.'><img[^>]+?'.'><\/a>)/', '\2<br />\1', $item['content']);
                    // debug('item', $item);

                    // if ($this->is_valid_html('<?xml version="1.0" encoding="utf-8"?'.'><div>'.$item['content'].'</div>')) {
                        $result[] = $item;
                        if( $i == $no ) break;
                        $i++;
                    // }
                    
                    $cache->put($result);
                }
            }
        }
        return $result;
    }
}