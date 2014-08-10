<h1>Agenda</h1>

<h2>Prochains événements</h2>
<?php if (!empty($calendar_future)) : foreach ($calendar_future as $item) : ?>
    <?= $item ?>
<?php endforeach; ?><?php else : ?>
    <p>Pas d'événements prévus.</p>
<?php endif ?>

<h2>Événements passés</h2>

<?php if (!empty($calendar_past)) : foreach ($calendar_past as $item) : ?>
    <?= $item ?>
<?php endforeach; ?><?php else : ?>
    <p>Il n'y a plus rien dans nos archives.</p>
<?php endif ?>
