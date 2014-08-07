<div id="facebook_news">
<?php if (!empty($facebook)) : ?>
<ul>
<?php foreach ($facebook as $item) : ?>
    <li class="news">
        <h2><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></h2>
        <p><?= $item['content'] ?></p>
    </li>
<?php endforeach; ?>
</ul>
<?php else : ?>
<p>No connection to Facebook</p>
<?php endif; ?>
</div>
<?php if (!empty($facebook)) : ?>
<script type="text/javascript">
  $(document).ready(function() {
    $("#facebook_news > ul").lightSlider({
        pager:true,
        controls:true,
        auto:true,
        speed:2000,
    }); 
  });
</script>
<?php endif; ?>
<div class="news">
<?php foreach ($news as $item) : ?>
    <div class="news_item">
        <h2><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></h2>
        <p><?= $item['content'] ?></p>
    </div>
<?php endforeach; ?>
</div>
