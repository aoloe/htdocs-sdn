<div class="calendar_item col-1-3">
<?php if (empty($item['date'])) : ?>
<p class="calendar_date"><em><?= $item['start'].(!empty($item['end']) ? ' &ndash; '.$item['end'] : '') ?></em></p>
<?php else : ?>
<p class="calendar_date"><em><?= $item['date'] ?></em></p>
<?php endif; ?>
<?php if (isset($item['url'])) : ?>
<p><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></p>
<?php else : ?>
<p><?= $item['title'] ?></p>
<?php endif; ?>
<?php if (!empty($item['place'])) : ?>
<?= $item['place'] ?>
<?php endif; ?>
<?php if (!empty($item['content'])) : ?>
<?= $item['content'] ?>
<?php endif; ?>
<?php if (isset($item['url'])) : ?>
<p><a href="<?= $item['url'] ?>">Plus de détails</a></p>
<?php endif; ?>
</div>
