<table class="table_comite">
<?php /*
<colgroup>
    <col width="200" />
    <col width="400" />
</colgroup>
*/ ?>
<tbody>
<?php //Aoloe\debug('table', $table); ?>
<?php
// pad the table to four columns
for ($i = 0; $i < (count($table) % 4); $i++) {
    $table[] = array();
}
?>
<?php $i=0; foreach ($table as $item) : ?>
<?php if (!empty($item)) :?>
<?php if ($i == 0) : ?>
<tr>
<?php endif; ?>
<td>
![<?= $item[0] ?>](images/comite/<?= $item[1] ?>)  
[<?= $item[0] ?>](mailto:<?= $item[2] ?>)  
<?= $item[3] ?>
</td>
<?php if ($i == 3) : ?>
</tr>
<?php endif; ?>
<?php endif; ?>
<?php $i = (++$i % 4); endforeach; ?>
</tbody>
</table>

