<?php
/**
 * get the feed from a twitter page
 * - cache the result for one hour
 * - cleanup the links
 * - cleanup the title and remove it from the content
 * - move the image to the beginning of the post
 *
 */

// use function Aoloe\debug as debug;

class Twitter {
    public function get_feed($url) {
        $result = null;

        // TODO: remove the access tokens!
        $settings = array(
            'oauth_access_token' => "21286225-2I1SK0rIMaL4hHTSobInfjXHQWctMoWpxgoCYq4ey",
            'oauth_access_token_secret' => "vmErGSLvwKlhN2zLRapvuv5mPlTryzMArvNr7Qd6w1vyt",
            'consumer_key' => "L91xVtGwCSMEv1cwy9HRTva2o",
            'consumer_secret' => "nY3kinaOP8qRKYq33LrxXwXE4iT25xP2raJm9JXh1xXe1556Go"
        );

        // $url = 'https://api.twitter.com/1.1/followers/ids.json';
        // get about 20 tweets
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name=sdnch';
        $requestMethod = 'GET';

        try {

            $api = new TwitterAPIExchange($settings);

            $feed = $api->setGetfield($getfield)
                         ->buildOauth($url, $requestMethod)
                         ->performRequest();
            $feed = json_decode($feed, true);
            $result = array();
            foreach (array_slice($feed, 0, 10) as $item)  {
                // Aoloe\debug('item', $item);
                $tweet_user = array_key_exists('retweeted_status', $item) ? $item['retweeted_status']['user'] : $item['user'];
                $feed_item = array (
                    'date' => $item['created_at'],
                    'id' => $item['id'], // url = https://twitter.com/$screen_name/status/$id
                    'content' => $item['text'],
                    'user_name' => $tweet_user['name'],
                    'user_id' => $tweet_user['screen_name'],
                    'user_description' => $tweet_user['description'],
                    'user_icon' => $tweet_user['profile_image_url'],
                );
                foreach ($item['entities']['hashtags'] as $hash_item) {
                    // Aoloe\debug('content', $feed_item['content']);
                    // Aoloe\debug('hash_item', $hash_item);
                    $feed_item['content'] = str_replace('#'.$hash_item['text'], '<a href="https://twitter.com/hashtag/'.$hash_item['text'].'?src=hash">#'.$hash_item['text'].'</a>', $feed_item['content']);
                }
                foreach ($item['entities']['urls'] as $url_item) {
                    // Aoloe\debug('content', $feed_item['content']);
                    // Aoloe\debug('url_item', $url_item);
                    $feed_item['content'] = str_replace($url_item['url'], '<a href="'.$url_item['expanded_url'].'">'.$url_item['display_url'].'</a>', $feed_item['content']);
                }
                $result[] = $feed_item;
            }
        } catch (Exception $e) {
            // Aoloe\debug('e', $e);
        }
        // Aoloe\debug('result', $result);
        return $result;
    }

    public function get_page_feed($page_id, $no = 5) {
        $result = array();

        $url = $page_id;

        $feed = $this->get_feed($url);
        // Aoloe\debug('result', $result);

        foreach ($feed as $item) {
            $result[] = array (
                'tweet_url' => 'https://twitter.com/'.$item['user_id'].'/status/'.$item['id'],
                'user_icon' => $item['user_icon'],
                'user_name' => $item['user_name'],
                'user_id' => $item['user_id'],
                'user_url' => 'https://twitter.com/'.$item['user_id'],
                'content' => $item['content'],
            );
        }

        /*
        $result = array(
            array('content' => 'test'),
            array('content' => 'tast'),
        );
        */

        return $result;
    }
}
