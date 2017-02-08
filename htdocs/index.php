<?php
session_start(); // for facebook api
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('vendor/autoload.php');

new Aoloe\Debug();
// use function Aoloe\debug as debug;

// debug('_SERVER', $_SERVER);
// debug('_REQUEST', $_REQUEST);

// reference for the user fields (list of feed, posts): https://developers.facebook.com/docs/graph-api/reference/user
// reference for the page fields (list of feeds, posts): https://developers.facebook.com/docs/graph-api/reference/page
// reference for the fields in the single post: https://developers.facebook.com/docs/graph-api/reference/v2.1/post

// https://graph.facebook.com/v2.4/me?fields=post
// https://graph.facebook.com/v2.4/sortirdunucleaire?fields=post
// https://graph.facebook.com/v2.4/161424603891516_1024016550965646?fields=message,id,object_id,picture,source,name,link,child_attachments,description

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

// debug('site_structure', $site_structure);
$route->set_structure($site_structure);

$route->read_url_request();
$route->read_current_page();

if ($route->is_not_found()) {
    header("HTTP/1.0 404 Not Found");
    $route->read_current_page('page_404');
}
$page = $route->get_page();
$page_query = $route->get_page_query();
// debug('page', $page);
// debug('page_url', $route->get_page_url());
// debug('url aliased', $route->get_page_aliased_url());
// debug('page_query', $page_query);

$configuration = new Aoloe\Configuration();
$configuration->set_file('sdn.yaml');
$configuration->read();

$module = new Aoloe\Module();
$module->set_page($page);
$module->set_url_query($route->get_page_query());
$module->set_site($site);
$module->set_url_structure($route->get_page_url());
$module->set_url_request($route->is_page_aliased_url() ? $route->get_page_aliased_url() : $route->get_page_url());
$module->set_configuration($configuration);
$module->initialize();
$content_page = $module->get_rendered();

include('library/Navigation.php');
$navigation = new Navigation();
$navigation->set_site_structure($site_structure);
$navigation->set_url_structure($route->is_page_aliased_url() ? $route->get_page_aliased_url() : $route->get_page_url());
// Aoloe\debug('navigation', $navigation);

$content_navigation = $navigation->get_rendered();
// Aoloe\debug('content_navigation', $content_navigation);
// define anchors for toc as ## Header 2 ##      {#header2}

// TODO: i think that the if can be removed...
if (isset($content_page)) {
    $template = new Aoloe\Template();

    $site->add_css('css/sortirdunucleaire.css');

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
    $template->set('favicon', $site->get_path_relative().'images/favicon.png');
    $template->set('path', $site->get_path_relative());
    $template->set('fonts', $site->get_font());
    $template->set('js', $site->get_js());
    $template->set('css', $site->get_css());
    $template->set('header_navigation', $content_navigation_header);
    $template->set('navigation', $content_navigation);
    $template->set('content', $content_page);
    echo $template->fetch('template/sortirdunucleaire.php');
}
