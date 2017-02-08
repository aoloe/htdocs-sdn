<?php
/**
 * - become an administrator of the page by getting yourself added to the settings > page roles
 * - create a developer account in facebook
 * - create an application in your developer profile and retain its app_id and app_secret
 * - you will probably need a test application (with an url to your local server: ww.sdn.ch, localhost) and 
 *   on e for the real application (www.sortirdunucleaire.ch)
 * - go to https://developers.facebook.com/tools/explorer and get the access token for the application
 *   *and* the page. (you will get a user access token... here we are using the app access token with the page)
 *
 * on top of it:
 * 
 * - https://developers.facebook.com/docs/reference/php/5.0.0 for some explainations on the facebook API and
 *   PHP
 */

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\Authentication\AccessToken;
use Facebook\FacebookSDKException;

class Facebook {

    public function get_feed($url) {
        $result = null;

        return $result;
    }

    private function htmlize($text) {
        return str_replace("\n", "<br>\n", preg_replace('/(https:\/\/|http:\/\/|www\.)(\S+)?/', '<a href="\1\2">\1\2</a>', $text));
    }
    private $day_of_week = array('', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    private $month_name = array('', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    private function contextualizeDate($date) {
        $result = "";
        $date = new DateTime($date, new DateTimeZone('Europe/Zurich'));
        $publish_time = $date->getTimestamp();
        if ($publish_time >= strtotime("today")) {
            $result = 'Aujourd\'hui à '.$date->format('H:i');
        } else if ($publish_time >= strtotime("yesterday")) {
            $result = 'Hier à '.$date->format('H:i');
        } else {
            $result = sprintf(
                '%s %d %s à %s',
                $this->day_of_week[$date->format('N')],
                $date->format('d'),
                $this->month_name[$date->format('n')],
                $date->format('H:i')
            );
        }
        return $result;
    }

    public function get_page_posts($app_id, $app_secret, $item_count = 5 ) {
        $result = array();

        $cache = new Aoloe\Cache();
        $cache->set_file('facebook_news.json');
        $cache->set_timeout(36000); // 60*60 = 1 hour
        // $cache->set_timeout(0); // no cache
        $result = $cache->get();
        // Aoloe\debug('result', $result);

        // $result = null; // uncomment this to ignore the cache

        if (false && is_null($result)) {

            $facebook = new Facebook\Facebook(array(
                'app_id' => $app_id,
                'app_secret' => $app_secret,
                'default_graph_version' => 'v2.4',
            ));
            // Aoloe\debug('facebook', $facebook);

            // we're getting the app access token. it should not leave the server.
            $facebook_app = $facebook->getApp();
            $access_token = $facebook_app->getAccessToken();
            // Aoloe\debug('access_token', $access_token);

            $facebook_post = $facebook->get('/sortirdunucleaire?fields=picture,name,link,posts', $access_token);
            // $facebook_post = $facebook->get('/me?fields=name,posts', $access_token);
            // $facebook_post = $facebook->get('/me?fields=name,posts', $app_id.'|'.$app_secret);
            // Aoloe\debug('facebook_post', $facebook_post);

            $body = $facebook_post->getDecodedBody();
            // Aoloe\debug('body', $body);

            $sdn_icon = $body['picture']['data']['url'];
            // Aoloe\debug('sdn_icon', $sdn_icon);

            $sdn_link = $body['link'];
            // Aoloe\debug('sdn_link', $sdn_link);

            $posts = array_slice($body['posts']['data'], 0, $item_count);
            // Aoloe\debug('posts', $posts);


            $batch_request = array();
            // https://developers.facebook.com/docs/graph-api/reference/v2.4/post
            $fields_request = 'fields=type,status_type,created_time,message,id,object_id,picture,source,name,link,child_attachments,description';
            foreach($posts as $item ) {
                $batch_request[$item['id']] = $facebook->request('GET', '/'.$item['id'].'?'.$fields_request);
            }
            // Aoloe\debug('batch_request', $batch_request);

            $batch_response = $facebook->sendBatchRequest($batch_request, $access_token);
            // Aoloe\debug('batch_response', $batch_response);
            foreach ($batch_response as $key => $value) {
                $value = $value->getDecodedBody();
                // Aoloe\debug('value', $value);
                $date = $this->contextualizeDate($value['created_time']);

                $story = null;
                if ($value['status_type'] == 'shared_story') {
                    $story = array (
                        'picture' => array_key_exists('picture', $value) ? $value['picture'] : null,
                        'title' => array_key_exists('name', $value) ? $value['name'] : null,
                        'url' => array_key_exists('link', $value) ? $value['link'] : null,
                        'url_label' => array_key_exists('name', $value) ? $value['name'] : null,
                        'description' =>
                            array_key_exists('description', $value) ?
                            $this->htmlize($value['description']) :
                            null
                        ,
                    );
                }

                $item = array(
                    'icon' => $sdn_icon,
                    'date' => $date,
                    'id' => end((explode('_', $value['id']))), // hack/bug: (( )) suppresses the warning
                    'message' => $this->htmlize($value['message']),
                    'story' => $story,
                );
                // Aoloe\debug('item', $item);
                $result[] = $item;
            }

            $cache->put($result);
        }
        return $result;
    }
}
