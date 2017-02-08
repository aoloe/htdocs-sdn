<form action="<?= $form_action ?>" method="post">
<?php if(empty($filename)) : ?>
<p>Title:<br>
<input type="test" name="title"></p>
<?php else : ?>
<input type="hidden" name="filename" value="<?= $filename ?>">
<?php endif; ?>
<p>
    <input type="submit" name="save" value="save">
    <a href="<?= $form_action ?>">cancel</a>
</p>
<p>
    <textarea name="content" style="width:100%; height:300px;"><?= htmlentities($content) ?></textarea>
</p>
<p>
    <input type="submit" name="save" value="save">
    <a href="<?= $form_action ?>">cancel</a>
</p>
</form>
