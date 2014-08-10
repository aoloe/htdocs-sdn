<div class="grid grid-pad">
    <div class="col-8-12">
        <div class="content">
            <?= $content ?>
        </div>
    </div>
    <div class="col-4-12">
        <?php foreach ($sidebar as $item) : ?>
        <div class="content">
            <p><?= $item ?></p>
        </div>
        <?php endforeach ?>
    </div>
</div>
