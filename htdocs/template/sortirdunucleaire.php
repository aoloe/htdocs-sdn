<!doctype html>
<html lang="<?= isset($language) ? $language : 'en' ?>">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

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


</style>
<div id="header">
<?= $header_navigation ?>
<p id="header_title"><a href="/">Sortir du Nucléaire</a></p>
<p id="header_line"><a href="/"><img src="<?= $path ?>/images/sortir_du_nucleaire.png"></a></p>
<?php /* remove also the css rules
<div id="banner-sortie-votations">
<a href="https://www.sortie-programmee-nucleaire.ch/"><img src="images/sortie-programmee.png"></a>
</div>
 */ ?>
</div>

<div id ="navigation">
<?= $navigation ?>
</div>

<div id="content">
<?= $content ?>
</div>

</body>
</html>
