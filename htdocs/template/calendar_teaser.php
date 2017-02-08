<?php if (!empty($calendar)): ?>
<?php foreach ($calendar as $item) : ?>
<p><?= $item['date'] ?><br>
<strong><?= $item['title'] ?></strong><br>
<?= $item['place'] ?><br>
<a href="<?= $item['url'] ?>">Pour en savoir plus »</a></p>
<?php endforeach; ?>
<?php else : ?>
    <p>Pas d'événements prévus.</p>
<?php endif ?>
