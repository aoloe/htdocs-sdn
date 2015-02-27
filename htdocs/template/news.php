<div class="grid grid-pad">
    <div class="col-8-12">
        <div class="content">
            <h1>Actualités</h1>
            <?php if (!empty($content)) : foreach ($content as $item) : ?>
                <?= $item ?>
            <?php endforeach; ?><?php else : ?>
                <p>Pas encore de nouvelles.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-4-12">
        <div class="sidebar news_sidebar">
            <?= $sidebar ?>
        </div>
    </div>
</div>
