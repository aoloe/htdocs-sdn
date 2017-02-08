<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php foreach ($table as $item) : ?>
**<?= $item[0] ?>**  
[<?= $item[2] ?>](<?= $item[1] ?>) (<?= $item[3] ?>)
<?php if (count($item) > 4): ?>

<?php for ($i = 4; $i < count($item); $i++) : ?>
- <?= $item[$i] ?>

<?php endfor; ?>

<?php endif; ?>

<?php endforeach; ?>

