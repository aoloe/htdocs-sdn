<div class="sidebar sidebar_facebook">
<h2><a href="https://www.facebook.com/pages/Sortir-du-Nucléaire-Suisse-Romande/161424603891516">Facebook<img src="images/facebook_f.png"></a></h2>
<?php if (!empty($feed)) : ?>
<div  id="facebook_feed">
<?php foreach ($feed as $item) : ?>
    <div class="facebook_feed_item">
        <p class="facebook_logo"><a href="https://facebook.com/sortirdunucleaire"><img src="<?= $item['icon'] ?>"></a> <a href="https://facebook.com/sortirdunucleaire/posts/<?= $item['id'] ?>"><?= $item['date'] ?></a></p>
        <?php if (!empty($item['message'])) : ?>
        <p><?= $item['message'] ?></p>
        <?php endif; ?>
        <?php if (isset($item['story'])) : ?>
        <div class="story">
            <?php if (isset($item['story']['title'])) : ?>
            <h4><?= $item['story']['title'] ?></h4>
            <?php endif; ?>
            <?php if (isset($item['story']['description'])) : ?>
            <p><?= $item['story']['description'] ?></p>
            <?php endif; ?>
            <?php if (isset($item['story']['picture'])) : ?>
            <p><img src="<?= $item['story']['picture'] ?>"></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <p><a href="https://www.facebook.com/sortirdunucleaire/posts/<?= $item['id'] ?>">Lire sur Facebook &raquo;</a></p>
    </div>
<?php endforeach; ?>
</div>
<?php else : ?>
<p>No connection to Facebook</p>
<?php endif; ?>
</div>
<?php if (!empty($feed)) : ?>
<script>
$("#facebook_feed").AnySlider({
    bullets: true,
    showControls: false,
    interval: 6000,
});
</script>
<style>
</style>
<?php endif; ?>

