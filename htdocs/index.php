<?php
require('vendor/autoload.php');

new Aoloe\Debug();
use function Aoloe\debug as debug;

// debug('_SERVER', $_SERVER);

$site_structure = file_get_contents('content/structure.yaml');
$site_structure = Spyc::YAMLLoadString($site_structure);
// debug('site_structure', $site_structure);

include_once('library/Site.php');
$site = new Site();

/*
// for now, we are ignoring the work done by .htaccess
if (array_key_exists('page', $_REQUEST)) {
    $page = $_REQUEST['page'];
}
*/

$request_url = $_SERVER['REQUEST_URI'];
// debug('request_url', $request_url);

if ($request_url == '/') {
    $request_url = '/accueil';
}

// TODO: eventually move to Site
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

function get_current_module($page) {
    $result = null;
    if (array_key_exists('module', $page)) {
        $result = is_array($page['module']) ? $page['module'] : array('name' => $page['module']);
        if (!array_key_exists('parameter', $result)) {
            $result['parameter'] = array();
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
if (array_key_exists('alias', $page)) {
    $page_module = get_current_module($page = get_current_page(explode('/', $page['alias']), $site_structure));
} else {
    $page_module = get_current_module($page);
}
if (isset($page_module)) {
    include_once('library/Module_abstract.php');
    $page_content = "<p>Module ".$page_module['name']." is not valid</p>\n";
    $module_file = 'module/'.$page_module['name'].'.php';
    if (file_exists($module_file)) {
        include_once($module_file);
        if (class_exists($page_module['name'])) {
            $module = new $page_module['name']();
            $module->set_site($site);
            foreach ($page_module['parameter'] as $key => $value) {
                if (method_exists(get_class($module), 'set_'.$key)) {
                    // debug('key', $key);
                    // debug('value', $value);
                    $module->{'set_'.$key}($value);
                }
            }
            $page_content = $module->get_content();
        }
    }
} else {
    $page_content = "<p>Pas encore de contenu.</p>";
}

$template = new Aoloe\Template();

$site->add_css('css/simplegrid/simplegrid.css');

$site->add_font('css/font-robotcondensed.css', 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300');

$template->clear();
$template->set('language', 'fr');
$template->set('title_site', 'Sortir du Nucléaire');
$template->set('favicon', 'images/favicon.png');
$template->set('path', $site->get_path_relative());
$template->set('fonts', $site->get_font());
$template->set('js', $site->get_js());
$template->set('css', $site->get_css());
$template->set('navigation', $content_navigation);
$template->set('content', $page_content);
echo $template->fetch('template/sortirdunucleaire.php');
