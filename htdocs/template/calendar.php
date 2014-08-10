<h1>Agenda</h1>

<h2>Prochains événements</h2>
<?php if (!empty($calendar_future)) : foreach ($calendar_future as $item) : ?>
    <p><?= $item['start'].(!empty($item['end']) ? ' &ndash; '.$item['end'] : '') ?> <?= $item['title'] ?></p>
    <?php if (!empty($item['content'])) : ?>
    <?= $item['content'] ?>
    <?php endif; ?>
<?php endforeach; ?><?php else : ?>
    <p>Pas d'événements prévus.</p>
<?php endif ?>

<h2>Événements passés</h2>

<?php if (!empty($calendar_past)) : foreach ($calendar_past as $item) : ?>
    <p><?= $item['start'].(!empty($item['end']) ? ' &ndash; '.$item['end'] : '') ?> <?= $item['title'] ?></p>
<?php endforeach; ?><?php else : ?>
    <p>Il n'y a plus rien dans nos archives.</p>
<?php endif ?>
