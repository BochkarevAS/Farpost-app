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

        <form action="/user/<?= $user->getId() ?>/edit" method="post">
            <label>Nickname <input type="text" name="nickname" value="<?= $user->getNickname() ?>"></label>
            <br><br>
            <label>Password <input type="password" name="password" value="<?= $user->getPassword() ?>"></label>
            <br><br>
            <label>Email <input type="text" name="email" value="<?= $user->getEmail() ?>"></label>
            <br><br>
            <input type="submit" name="submit" value="Обновить">
        </form>

    </div>
<?php endif; ?>