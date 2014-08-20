<div id="header_navigation">
<?php if (!empty($navigation_left)) : ?>
<ul class="navigation_header_left">
<?php foreach ($navigation_left as $item) : ?>
<li><?= $item ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php if (!empty($navigation_right)) : ?>
<ul class="navigation_header_right">
<?php foreach ($navigation_right as $item) : ?>
<li><?= $item ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
