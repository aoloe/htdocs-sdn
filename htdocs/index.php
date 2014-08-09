<?php
require('vendor/autoload.php');

new Aoloe\Debug();
use function Aoloe\debug as debug;

use \Michelf\MarkdownExtra;

// debug('_SERVER', $_SERVER);

/**
 * if a resources are passed as paremeters return the matching one, otherwise return true if the
 * web resources are available
 * TODO: put this in a library
 */
function get_web_ressource($web = null, $local = null) {
    // debug('host', );
    if (isset($web)) {
        return  gethostbyname('ideale.ch') === 'ideale.ch' ? $local : $web;
    } else {
        return  gethostbyname('ideale.ch') !== 'ideale.ch';
    }
}

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


// debug('page', $page);
// debug('page_url', $page_url);
if (array_key_exists('module', $page)) {
    $module_file = 'module/'.$page['module'].'.php';
    if (file_exists($module_file)) {
        include_once($module_file);
        if (class_exists($page['module'])) {
            $module = new $page['module']();
            $page_css += $module->get_css();
            $page_js += $module->get_js();
            $page_fonts += $module->get_fonts();
            $page_content = $module->get_content();
        }
    }
} else {
    $page_content = "<p>Pas encore de contenu.</p>";
}

$template = new Aoloe\Template();

$page_css[] = $path.'css/simplegrid/simplegrid.css';

// $page_fonts[] = $path.'css/font-awesome.css';
$page_fonts[] = get_web_ressource('http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300', 'css/font-robotcondensed.css');

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
