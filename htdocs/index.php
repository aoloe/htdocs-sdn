<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('vendor/autoload.php');

new Aoloe\Debug();
// use function Aoloe\debug as debug;

// debug('_SERVER', $_SERVER);
// debug('_REQUEST', $_REQUEST);

$structure_test = true;
$cookie = new Aoloe\Cookie();
/*
// TODO: should we have this as a module that is always run?
if (array_key_exists('nav', $_REQUEST)) {
    if ($_REQUEST['nav'] == 'test') {
        $structure_test = true;
        $cookie->set('navigation', 'test');
    } else {
        $cookie->delete('navigation');
        $structure_test = false;
    }
} else {
    $structure_test = $cookie->is('navigation');
}
*/

// debug('structure_test', $structure_test);
// $site_structure = ($structure_test ?  file_get_contents('content/re-structure.yaml') : file_get_contents('content/structure.yaml'));
$site_structure = file_get_contents('content/structure.yaml');
$site_structure = Spyc::YAMLLoadString($site_structure);
// debug('site_structure', $site_structure);

$site = new Aoloe\Site();

/*
// for now, we are ignoring the work done by .htaccess
if (array_key_exists('page', $_REQUEST)) {
    $page = $_REQUEST['page'];
}
*/

$route = new Aoloe\Route();

$route->set_structure($site_structure);

$route->read_url_request();

// Aoloe\debug('get_url_structure()', $route->get_url_structure(''));
if ($route->get_url_structure() == '') {
    $page = $route->get_page_from_structure('accueil');
} else {
    $page = $route->get_page_from_structure();
}
$page_query = $route->get_query();

// Aoloe\debug('get_url_structure()', $route->get_url_structure(''));
// Aoloe\debug('page', $page);

$module = new Aoloe\Module();
$module->set_page($page);
$module->set_parameter($page_query);
$module->set_site($site);
$module->set_url_structure($route->get_url_structure());
$content_page = $module->get_rendered();

include('library/Navigation.php');
$navigation = new Navigation();
$navigation->set_site_structure($site_structure);
$navigation->set_url_structure($route->get_url_structure());
// Aoloe\debug('navigation', $navigation);

$content_navigation = $navigation->get_rendered();
// Aoloe\debug('content_navigation', $content_navigation);
// define anchors for toc as ## Header 2 ##      {#header2}

// TODO: i think that the if can be removed...
if (isset($content_page)) {
    $template = new Aoloe\Template();

    $site->add_css('css/simplegrid/simplegrid.css');

    $site->add_font('css/font-robotocondensed.css', 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300');

    $header_navigation = '';

    $content_navigation_header = '';
    if ($structure_test) {
        include_once('library/Navigation_header.php');
        $navigation_header = new Navigation_header();
        $navigation_header->set_site($site);
        $content_navigation_header = $navigation_header->get_rendered();
    }

    $template->clear();
    $template->set('language', 'fr');
    $template->set('title_site', 'Sortir du Nucléaire');
    $template->set('favicon', 'images/favicon.png');
    $template->set('path', $site->get_path_relative());
    $template->set('fonts', $site->get_font());
    $template->set('js', $site->get_js());
    $template->set('css', $site->get_css());
    $template->set('header_navigation', $content_navigation_header);
    $template->set('navigation', $content_navigation);
    $template->set('content', $content_page);
    echo $template->fetch('template/sortirdunucleaire.php');
}
