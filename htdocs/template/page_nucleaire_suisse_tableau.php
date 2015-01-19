<?php
// make the first, fifth and sixth columns strong
function get_strong_tag($i, $is_open) {
    if ($i == 0 || $i == 5 || $i == 6) {
        return "<".($is_open ? "" : "/")."strong>";
    } else {
        return "";
    }
}
?>
<table class="sdn_table">
<?php /*
<colgroup>
    <col width="200" />
    <col width="400" />
</colgroup>
*/ ?>
<tbody>
<?php //Aoloe\debug('table', $table); ?>
<?php foreach (reset($table) as $item) : ?>
<th><?= $item ?></th>
<?php endforeach; ?>
<?php foreach (array_slice($table, 1, sizeof($table) - 2) as $item) : ?>
<tr>
<?php $i = 0; foreach ($item as $iitem) : ?>
<td><?= get_strong_tag($i, true) ?><?= $iitem ?><?= get_strong_tag($i++, true) ?></td>
<?php endforeach; ?>
</tr>
<?php endforeach; ?>
<?php $total = $table[sizeof($table) - 1]; ?>
<tr>
<td colspan="3"><small><?= $total[0] ?></small></td>
<td colspan="2"><strong><?= $total[1] ?></strong></td>
<td><strong><?= $total[2] ?></strong></td>
<td><strong><?= $total[3] ?></strong></td>
</tr>
</tbody>
</table>
