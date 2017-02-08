<div class="sidebar sidebar_facebook">
<h2><a href="https://www.facebook.com/pages/Sortir-du-Nucléaire-Suisse-Romande/161424603891516">Facebook<img src="images/facebook_f.png"></a></h2>
<?php if (!empty($feed)) : ?>
<div  id="facebook_feed">
<?php foreach ($feed as $item) : ?>
    <div class="facebook_feed_item">
        <?php if (!empty($item['title'])) : ?>
        <h3><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></h3>
        <?php endif; ?>
        <p><?= $item['content'] ?></p>
        <p><a href="<?= $item['url'] ?>">Lire sur Facebook &raquo;</a></p>
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
    showControls: false
});
</script>
<style>
</style>
<?php endif; ?>

