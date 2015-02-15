<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php foreach ($table as $item) : ?>
**<?= $item[0] ?>**  
[<?= $item[2] ?>](<?= $item[1] ?>)

<?php endforeach; ?>

