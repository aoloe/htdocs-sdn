<?php if (isset($facebook)) : ?>
<?= $facebook ?>
<?php endif; ?>
<div class="news">
<?php foreach ($news as $item) : ?>
    <div class="news_item">
        <h2><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></h2>
        <p><?= $item['content'] ?></p>
    </div>
<?php endforeach; ?>
</div>
