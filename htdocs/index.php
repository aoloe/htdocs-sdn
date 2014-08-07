<?php
require('vendor/autoload.php');

new Aoloe\Debug();
use function Aoloe\debug as debug;

use \Michelf\MarkdownExtra;

// debug('_SERVER', $_SERVER);
$site_local = (substr($_SERVER['HTTP_HOST'], 0, 3) == 'ww.');

$path = str_repeat('../', substr_count($_SERVER['REQUEST_URI'], '/', 1));
// debug('path', $path);

$site_structure = file_get_contents('content/structure.yaml');
$site_structure = Spyc::YAMLLoadString($site_structure);
// debug('site_structure', $site_structure);

if (array_key_exists('page', $_REQUEST)) {
    $page = $_REQUEST['page'];
}

$request_url = $_SERVER['REQUEST_URI'];
// debug('request_url', $request_url);

if ($request_url == '/') {
    $request_url = '/accueil';
}

function get_current_page($url_segment, $site_structure) {
    $result = null;
    $url = reset($url_segment);
    // debug('url', $url);
    if (array_key_exists($url, $site_structure)) {
        if (count($url_segment) > 1) {
            if (array_key_exists('children', $site_structure[$url])) {
                $result = get_current_page(array_slice($url_segment, 1), $site_structure[$url]['children']);
            }
        } else {
            $result = $site_structure[$url];
        }
    }
    return $result;
}

$url_segment = array_slice(explode('/', $request_url), 1);
// debug('url_segment', $url_segment);
$page = get_current_page($url_segment, $site_structure);
// debug('page', $page);
if (isset($page)) {
    $page_url = $request_url;
} else {
    $page_url = 'page_404';
}

// debug('page_url', $page_url);

$page_css = array();
$page_fonts = array();
$page_js = array();

include('library/Navigation.php');
$navigation = new Navigation();
$navigation->set_site_structure($site_structure);
$navigation->set_url_segment($url_segment);
// debug('navigation', $navigation);

$content_navigation = $navigation->get_rendered();
// debug('content_navigation', $content_navigation);
// define anchors for toc as ## Header 2 ##      {#header2}

$template = new Aoloe\Template();

// debug('page_url', $page_url);
if ($page_url == '/accueil') {

    $page_css[] = 'css/lightSlider.css';
    $page_js[] = '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js';
    $page_js[] = 'js/jquery.lightSlider.min.js';

    include_once('library/Facebook.php');
    $facebook = new Facebook();
    $template->clear();
    $template->set_template('template/accueil_news_item.php');
    $news_facebook = array();
    foreach ($facebook->get_page_feed(161424603891516) as $item) {
        // debug('item', $item);
        $news_facebook[] = array (
            'title' => $item['title'],
            'url' => $item['url'],
            'content' => $item['content'],
        );
    }
    // debug('news', $news);
    
    $template->clear();
    $template->set('facebook', $news_facebook);
    $template->set('news', array());
    $content_news = $template->fetch('template/accueil_news.php');

    $template->clear();
    $file_content = 'content/accueil.md';
    if (file_exists($file_content)) {
        $content = file_get_contents($file_content);
        $content = MarkdownExtra::defaultTransform($content);
    }
    $template->set('content', $content);
    $template->set('facebook', $content_news);
    $template->set('news', $content_news);
    $page_content = $template->fetch('template/accueil.php');
} else {
    $page_content = "<p>Pas encore de contenu.</p>";
}

$page_css[] = $path.'css/simplegrid/simplegrid.css';

// $page_fonts[] = $path.'css/font-awesome.css';
if ($site_local) {
    $page_fonts[] = 'css/font-robotcondensed.css';
} else {
    $page_fonts[] = 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300';
}

$template->clear();
$template->set('language', 'fr');
$template->set('title_site', 'Sortir du Nucléaire');
$template->set('path', $path);
$template->set('fonts', $page_fonts);
$template->set('js', $page_js);
$template->set('css', $page_css);
$template->set('navigation', $content_navigation);
$template->set('content', $page_content);
echo $template->fetch('template/sortirdunucleaire.php');
