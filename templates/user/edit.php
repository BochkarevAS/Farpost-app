<?php if (isset($errors) && is_array($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (isset($user)) : ?>
    <div style="text-align: center;">
        <h1>Редактировать пользователя</h1>

        <form action="/user/<?= $user->getId() ?>/edit" method="post" enctype="multipart/form-data">
            <label>Nickname <input type="text" name="nickname" value="<?= $user->getNickname() ?>"></label>
            <br><br>
            <label>Password <input type="password" name="password" value="<?= $user->getPassword() ?>"></label>
            <br><br>
            <label>Email <input type="text" name="email" value="<?= $user->getEmail() ?>"></label>
            <br><br>
            <label>Image <input type="file" name="file" value="<?= $user->getAvatar() ?>"></label>
            <br><br>
            <input type="submit" name="submit" value="Обновить">
        </form>

    </div>
<?php endif; ?>