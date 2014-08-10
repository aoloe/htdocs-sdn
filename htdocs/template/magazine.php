<h2>Journal d'information<br>
de Sortir du nucléaire</h2>

<style>
.col-2-12 {
    /* border:1px solid black; */
}
a,
a:visited
{
    color:black;
    text-decoration:none;
}
</style>

<?php foreach ($magazine as $key => $year) : ?>
<h2><?= $key ?></h2>
<div class="grid grid-pad">
    <?php foreach ($year as $issue) : ?>
    <div class="col-2-12">
        <div class="content">
            <p><a href="<?= $path.$issue['link'] ?>"><img title="<?= $issue['alt'] ?>" src="<?= $path.$issue['icon'] ?>" alt="<?= $issue['alt'] ?>" width="100" height="142" /></a></p>

            <p><a href="<?= $path.$issue['link'] ?>"><?= $issue['label'] ?></a></p>
        </div>
    </div>
    <?php endforeach; ?>
    <?php for ($i = count($year); $i < 6; $i++) : ?>
    <div class="col-2-12">
        <div class="content">
        </div>
    </div>
    <?php endfor; ?>
</div>
<?php endforeach; ?>
