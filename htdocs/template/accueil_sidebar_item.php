<div class="sidebar">
<?php if (isset($title_link)) : ?>
<h2><a href="<?= $title_link ?>"><?= $title ?></a></h2>
<?php else : ?>
<h2><?= $title ?></h2>
<?php endif; ?>
<div>
<?= $content ?>
</div>

