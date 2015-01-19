<?php // Aoloe\debug('table', $table); ?>

<?php foreach ($table as $item) : ?>
- <strong><?= $item[0] ?></strong><br /><a href="<?= $item[1] ?>"><?= $item[2] ?></a> (<?= $item[3] ?>)</li>
<?php endforeach; ?>
