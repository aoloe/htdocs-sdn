<div id="facebook_news" class="news news_slider">
<!--
<h2><a href="https://www.facebook.com/pages/Sortir-du-Nucléaire-Suisse-Romande/161424603891516">Actuel sur Facebook</a></h2>
-->
<h2 style="padding-bottom:0px; margin-bottom:0px;"><a href="https://www.facebook.com/pages/Sortir-du-Nucléaire-Suisse-Romande/161424603891516"><img src="images/facebook_f.png"></a></h2>
<?php if (!empty($facebook)) : ?>
<div id="slider" style="margin-top:0px;">
<?php foreach ($facebook as $item) : ?>
    <div style="overflow:hidden;  border-top:1px solid black; border-bottom:1px solid black; height:300px; overflow-y:auto;">
        <?php if (!empty($item['title'])) : ?>
        <h2><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></h2>
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
<?php if (!empty($facebook)) : ?>
<script>
$("#slider").AnySlider({
    bullets: true,
    showControls: false
});
</script>
<style>
</style>

<?php endif; ?>
<div class="news">
<?php foreach ($news as $item) : ?>
    <div class="news_item">
        <h2><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></h2>
        <p><?= $item['content'] ?></p>
    </div>
<?php endforeach; ?>
</div>
