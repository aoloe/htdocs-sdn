<div class="grid grid-pad">
    <div class="col-8-12">
        <div class="content">
            <?= $content ?>
        </div>
    </div>
    <div class="col-4-12">
        <div class="sidebar news_sidebar">
            <?php if (!empty($sidebar)) : ?>
            <h1>Actualités</h1>
            <?php foreach ($sidebar as $item) : ?>
                <?= $item ?>
            <?php endforeach; ?>
            <?php endif;; ?>
        </div>
    </div>
</div>
