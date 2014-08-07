<?php
/**
 * https://gist.github.com/banago/3864515
 */
class Facebook {
    private function get_cleaned_description($description) {
        $result = $description;
        $result = preg_replace('/ onclick="[^"]*"/', '', $result);
        $result = preg_replace('/ onmouseover="[^"]*"/', '', $result);
        // $result = preg_replace('/"l.php?u=([^"]+)"/', '\1', $result);
        $result = preg_replace('/"\/l.php\?u=(.*?)"/', '"\1"', $result);
        return $result;
    }
    public function get_page_feed( $page_id, $no = 5 ) {
        $result = array();
        // URL to the Facebook page's RSS feed.
        $rss_url = 'http://www.facebook.com/feeds/page.php?id=' . $page_id . '&format=rss20';
        
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
     
        curl_setopt($curl, CURLOPT_URL, $rss_url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, '');
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
     
        $raw_xml = curl_exec($curl); // execute the curl command
        curl_close($curl); // close the connection
        
        $xml = simplexml_load_string( $raw_xml );
      
        $i = 1;
        foreach( $xml->channel->item as $item ){
            $result[] = array(
                'title' => $item->title->__toString(),
                'url' => $item->link->__toString(),
                'date' => $item->pubDate->__toString(),
                'author' => $item->author->__toString(),
                'content' => $this->get_cleaned_description($item->description->__toString()),
            );
            /*
            $out .= '<div class="entry">';
            $out .= '<h3 class="title"><a href="' . $item->link . '">' . $item->title . '</a></h3>';
            $out .= '<div class="meta">' . $item->pubDate . ' by '. $item->author .'</div>';
            $out .= '<div class="content">' . $item->description . '</div></div>';
            */
            
            if( $i == $no ) break;
            $i++;
        }
        // echo($out);
        return $result;
    }
}
