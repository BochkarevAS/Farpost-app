<?php require_once(ROOT . '/Resources/views/layout/header.php'); ?>

<form name="upload">
    <input type="file" name="img">
    <input type="submit" name="submit" value="Загрузить">
</form>

<div id="log">Прогресс загрузки</div>

<ul id="image">
    <?php foreach ($images as $image) : ?>
        <li>
            <a href="show/<?= $image['id']?>" target="_blank"><?= $image['img'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>

<?php require_once(ROOT . '/Resources/views/layout/footer.php'); ?>