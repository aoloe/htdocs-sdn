<style>
  .verticalScroll {
    position: relative;
    height: 180px;
    overflow: hidden;
  }

  .verticalScroll > div {
    position:absolute;
  }
</style>
<div class="sidebar sidebar_twitter">
<h2><a href="https://www.twitter.com/sdnch">Twitter<img src="images/twitter_t.png"></a></h2>
<?php if (!empty($feed)) : ?>
<div  id="twitter_feed" class="verticalScroll">
<?php foreach ($feed as $item) : ?>
    <div class="twitter_feed_item">
        <?php if (!empty($item['user_icon'])) : ?>
        <p style="white-space: nowrap; overflow:hidden;padding-bottom:0px; padding-top:0px; margin-top:0px; margin-bottom:0px;"><a href="<?= $item['tweet_url'] ?>" style="text-decoration:none; "><img src="<?= $item['user_icon'] ?>" style="vertical-align:middle"> <?= $item['user_name'] ?> @<?= $item['user_id'] ?></a></p>
        <?php endif; ?>
        <p style="padding-top:0px; margin-top:0px;"><?= $item['content'] ?></p>
    </div>
<?php endforeach; ?>
</div>
<?php else : ?>
<p>No connection to Twitter</p>
<?php endif; ?>
</div>
<?php if (!empty($feed)) : ?>
<?php /*
<script type="text/javascript" src="js/jquery.totemticker.min.js"></script>
<script type="text/javascript" src="js/jquery.slidingticker.js"></script>
<script type="text/javascript" src="js/jquery.simplyscroll.min.js"></script>
*/ ?>
<script>
/*
$("#twitter_feed").AnySlider({
    bullets: false,
    showControls: false
});
*/
/*
$('#twitter_feed').slidingticker({
    // max_items: 2
});
*/
/*
$(document).ready(function() {
    $('#twitter_feed').simplyScroll({
        orientation: 'vertical',
    });
});
*/
$(".verticalScroll").verticalScroll();
</script>
<style>
</style>
<?php endif; ?>

