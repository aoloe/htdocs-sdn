<!doctype html>
<html lang="<?= isset($language) ? $language : 'en' ?>">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<title><?= isset($title) ? $title.' - ' : '' ?><?= isset($title_site) ? $title_site : ''?></title>

<link rel="shortcut icon" href="<?= $favicon ?>" />
<?php if (isset($fonts)) : foreach ($fonts as $value) : ?>
<link rel="stylesheet" href="<?= $value ?>" type="text/css" />
<?php endforeach; endif; ?>

<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<?php if (isset($css)) : foreach ($css as $value) : ?>
<link rel="stylesheet" href="<?= is_array($value) ? $value['href'] : $value ?>" type="text/css" media="<?= is_array($value) && array_key_exists('media', $value) ? $value['media'] : 'all' ?>" />
<?php endforeach; endif; ?>

<?php if (isset($js)) : foreach ($js as $value) : ?>
<script type="text/javascript" src="<?= $value ?>"></script>
<?php endforeach; endif; ?>


</head>
<body>
<style>
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
}
/*
#header_line {font-size:20px;border-top: 1px solid black; text-align:center;}
#header_line img { position: relative; top: -30px; padding: 10px; background: white; margin-top:0px; padding-top:0px;}
*/

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
    padding-top:20px;
    padding-bottom:50px;
}

#navigation ul {
    padding-left:0px;
    margin-top:0px;
    padding-top:0px;
    margin-bottom:0px;
    padding-bottom:0px;
    border-bottom:1px solid black;
}

#navigation ul li {
    display:inline;
    padding-left:5px;
    padding-right:5px;
}

#navigation ul li a {
    text-decoration:none;
}

#navigation ul li.active {
    background-color:black;
}

#navigation ul li:hover {
    background-color:gray;
}

#navigation ul li a,
#navigation ul li a:visited
{
    color:black;
}

#navigation ul li.active
{
    color:white;
}

#navigation ul li:hover a,
#navigation ul li:hover a:visited
{
    color:white;
}

#content {
    max-width:930px;
    margin: 0 auto;
    position: relative;
}

.content {
    /* background-color:pink; */
}

.grid-pad {
    padding-top: 0px;
    padding-left: 0px;
}

.news h2 {
    font-size:1em;
}

h2 {
    color:#fbb93d;
}

.news h2 a,
.news h2 a:visited
{
    text-decoration:none;
    color:black;
}

</style>
<div id="header">
<p id="header_title">Sortir du Nucléaire</p>
<p id="header_line"><img src="<?= $path ?>/images/sortir_du_nucleaire.png"></p>
</div>

<div id ="navigation">
<?= $navigation ?>
</div>

<div id="content">
<?= $content ?>
</div>

</body>
</html>

