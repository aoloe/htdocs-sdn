<!doctype html>
<html lang="<?= isset($language) ? $language : 'en' ?>">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<title><?= isset($title) ? $title.' - ' : '' ?><?= isset($title_site) ? $title_site : ''?></title>

<?php if (isset($favicon)) : ?>
<link rel="shortcut icon" href="<?= $favicon ?>" />
<?php endif;
?>
<?php if (isset($fonts)) : foreach ($fonts as $value) : ?>
<link rel="stylesheet" href="<?= $value ?>" type="text/css" />
<?php endforeach;
endif;
?>

<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<?php if (isset($css)) : foreach ($css as $value) : ?>
<link rel="stylesheet" href="<?= is_array($value) ? $value['href'] : $value ?>" type="text/css" media="<?= is_array($value) && array_key_exists('media', $value) ? $value['media'] : 'all' ?>" />
<?php endforeach;
endif;
?>

<?php if (isset($js)) : foreach ($js as $value) : ?>
<script type="text/javascript" src="<?= $value ?>"></script>
<?php endforeach;
endif;
?>


</head>
<body>
<style>

h1,
h1 a,
h1 a:visited
{
    font-weight:normal;
    color:#fbb93d;
    text-decoration:none;
}

h2,
h2 a,
h2 a:visited
{
    font-weight:normal;
    color:#fbb93d;
    text-decoration:none;
}

h3,
h3 a,
h3 a:visited
{
    color:black;
    font-weight:normal;
    text-decoration:none;
}


ul {
    /* TODO: improve the spacing between dash and text */
    list-style: none;
    margin-left: 0;
    padding-left: 1em;
    text-indent: -1em;
}
li:before {
    content: "– \020";
}


#header {
    max-width:930px;
    margin: 0 auto;
    position: relative;
}
#header_title {
    font-size:64pt;
    font-family: 'Roboto Condensed', sans-serif;
    margin-top:0px;
    padding-top:0px;
    margin-bottom:0px;
    padding-bottom:20px;
    text-align:center;
    color:#999;
}
#header a,
#header a:visited
{
    text-decoration:none;
    color:#999;
}
/*
#header_line {font-size:20px;border-top: 1px solid black;
text-align:center;}
#header_line img { position: relative;
top: -30px;
padding: 10px;
background: white;
margin-top:0px;
padding-top:0px;}
*/

#header_navigation {
    margin-top:10px;
    height:20px;
    position:relative;
}
#header_navigation ul {
    padding:0px;
    margin:0px;
    list-style: none;
    text-indent: 0;
}

#header_navigation ul li {
    display:inline;
}

#header_navigation li:before {
    content: "";
}

#header_navigation ul li a {
    text-decoration:none;
}

ul.navigation_header_left {
    position:absolute;
    left:0px;
}

ul.navigation_header_left li {
    padding-right:10px;
}

ul.navigation_header_right {
    position:absolute;
    right:0px;
}
ul.navigation_header_right li {
    padding-left:10px;
}

#header_navigation ul li a,
#header_navigation ul li a:visited
{
    color:black;
}

#header_line {
    font: 1.2em sans-serif;
    text-align: center;
    border-bottom: solid 1px;

    /* pull the border up*/
    height: 25px;

    /* push the paragraph down */
    margin-bottom: 25px;

    /*
    height: .6em;

    margin-bottom: 1.4em;
    */
    padding-top:0px;
    margin-top:0px;
}

/* line cover */
#header_line:first-line{
    background-color: white;
}

/* additional padding */
#header_line:before,
#header_line:after{
    content: '\0000a0 \0000a0';

}

#header_line img {
    background: white;
    padding-left:10px;
    padding-right:10px;
}

#navigation {
    max-width:930px;
    margin: 0 auto;
    position: relative;
}

#navigation {
    overflow:hidden;
    padding-top:30px;
    padding-bottom:50px;
}


#navigation ul {
    padding-left:0px;
    margin-top:0px;
    padding-top:0px;
    margin-bottom:0px;
    padding-bottom:0px;
    border-bottom:1px solid black;
    list-style: none;
    margin-left: 0;
    padding-left: 0;
    text-indent: 0;
}

#navigation ul li {
    display:inline;
}

#navigation li:before {
    content: "";
}

#navigation ul li a {
    text-decoration:none;
    padding-left:5px;
    padding-right:5px;
}

#navigation ul li:hover {
    background-color:gray;
}

#navigation ul li a,
#navigation ul li a:visited
{
    color:black;
}

#navigation ul li.active a,
#navigation ul li.active a:visited
{
    background-color:black;
    color:white;
}

#navigation ul li:hover a,
#navigation ul li:hover a:visited
{
    color:white;
}

#navigation ul li.active
{
    color:white;
}

#content {
    max-width:930px;
    margin: 0 auto;
    position: relative;
}

.content {
    /* background-color:pink;
*/
}

.grid-pad {
    padding-top: 0px;
    padding-left: 0px;
}

.sidebar {
}

.sidebar h2 {
    font-size:1.5em;
    border-bottom:1px solid black;
}

.sidebar_facebook {
    position:relative;
    padding-bottom:20px;
}
.sidebar_facebook h2 {
    margin-bottom:0px;
}

.sidebar_facebook h2 img {
    position:absolute;
    right:0px;
    top:-4px;
}

#facebook_feed {
    margin-top:0px;
}

#facebook_feed h3,
#facebook_feed h3 a,
#facebook_feed h3 a:visited
{
    color:#3b579d;
    font-size:1em;
}

/* anyslider */

#facebook_feed {
    -ms-touch-action: none;
    overflow: auto;
    position: relative;
    touch-action: none;
}

/* The same rules for styling apply here. Style to your liking */
.as-nav {
    bottom: -5px;
    left: 35%;
    /*
    margin: 0 0 0 -7px;
    */
    max-width:100px;
    position: absolute;
    /* width: 100px;
*/
    z-index: 1;
}

.as-nav a {
    background: url(images/anyslider_bullets.png) no-repeat;
    height: 10px;
    display: inline-block;
    margin: 0 3px;
    overflow: hidden;
    text-indent: 100%;
    white-space: nowrap;
    width: 10px;
}

a.as-active, .as-nav a:hover {
    background-position: 0 -10px;
}

/* /anyslider */

div.facebook_feed_item {
    overflow:hidden;
    height:300px;
    overflow-y:auto;
    border-bottom:1px solid black;
}

/* news page */

.news_sidebar h2 {
    font-size:1.2em;
    border-bottom:none;
}

/* calendar page */

div.calendar_item {
    padding-bottom:10px;
}

</style>
<div id="header">
<?= $header_navigation ?>
<p id="header_title"><a href="/">Sortir du Nucléaire</a></p>
<p id="header_line"><a href="/"><img src="<?= $path ?>/images/sortir_du_nucleaire.png"></a></p>
</div>

<div id ="navigation">
<?= $navigation ?>
</div>

<div id="content">
<?= $content ?>
</div>

</body>
</html>

