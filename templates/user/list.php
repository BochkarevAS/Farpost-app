<div>
    <?php

    if (isset($users)) : ?>
        <?php foreach ($users as $user): ?>
            <div>
                <img src="<?= '/public/images/'.$user->getAvatar() ?>" width="50" height="50">
                <a href="/user/<?= $user->getId() ?>/show"><?= $user->getEmail() ?></a>
                <a href="/user/<?= $user->getId() ?>/edit">Редактировать</a>
                <a href="/user/<?= $user->getId() ?>/delete">Удалить</a>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
