<h2>Text</h2>
<form action="<?= $form_action ?>" method="post">
<input type="submit" name="text_new"name="add"  value="add">
</form>
<ul>
<?php foreach($text_list as $item) : ?>
<li><a href="<?= $url_base ?><?= $item ?>"><?= $item ?></a></li>
<?php endforeach; ?>
</ul>
<h2>Picture</h2>

<form action="<?= $form_action ?>" method="post" enctype="multipart/form-data">
<input type="file" name="file" accept="image/jpeg">
<input type="submit" name="image_new" name="add"  value="add">
</form>
<ul>
<?php foreach($image_list as $item) : ?>
<li><img src="<?= $path_images ?><?= $item ?>"></li>
<?php endforeach; ?>
</ul>
