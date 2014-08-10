<div class="calendar_item">
<?php if (empty($item['date'])) : ?>
<p><em><?= $item['start'].(!empty($item['end']) ? ' &ndash; '.$item['end'] : '') ?></em></p>
<?php else : ?>
<p><em><?= $item['date'] ?></em></p>
<?php endif; ?>
<?php if (isset($item['url'])) : ?>
<p><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></p>
<?php else : ?>
<p><?= $item['title'] ?></p>
<?php endif; ?>
<?php if (!empty($item['content'])) : ?>
<?= $item['content'] ?>
<?php endif; ?>
</div>
