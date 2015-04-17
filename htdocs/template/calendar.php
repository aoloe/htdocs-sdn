<h1>Agenda</h1>
<style>
.calendar_item {
    padding:10px;
}
.calendar_date {
    border-bottom: 1px solid black;
    padding-left:5px;
    padding-right:5px;
    /* background-color:#fbb93d; */
}
</style>

<h2>Prochains événements</h2>
<?php if (!empty($calendar_future)): ?>
<?php $open = false; $i = 0; foreach ($calendar_future as $item) : ?>
    <?php if (($i++ % 3) == 0) : $open = true;?>
    <div class="calendar grid grid-pad">
    <?php endif; ?>
    <?= $item ?>
    <?php if (($i % 3) == 0) : $open = false; ?></div><?php endif; ?>
<?php endforeach; ?>
<?php if ($open) : ?></div><?php endif; ?>
</div>
<?php else : ?>
    <p>Pas d'événements prévus.</p>
<?php endif ?>


<h2>Événements passés</h2>

<?php if (!empty($calendar_past)): ?>
<?php $open = false; $i = 0; foreach ($calendar_past as $item) : ?>
    <?php if (($i++ % 3) == 0) : $open = true;?>
    <div class="calendar grid grid-pad">
    <?php endif; ?>
    <?= $item ?>
    <?php if (($i % 3) == 0) : $open = false; ?></div><?php endif; ?>
<?php endforeach; ?>
<?php if ($open) : ?></div><?php endif; ?>
</div>
<?php else : ?>
    <p>Il n'y a plus rien dans nos archives.</p>
<?php endif ?>
