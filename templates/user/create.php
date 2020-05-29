<?php if (isset($errors) && is_array($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div style="text-align: center;">
    <h1>Создать пользователя</h1>

    <form action="/user/create" method="post">
        <label>Nickname <input type="text" name="nickname"></label>
        <br><br>
        <label>Email <input type="text" name="email"></label>
        <br><br>
        <label>Password <input type="text" name="password"></label>
        <br><br>
        <input type="submit" name="submit" value="Создать">
    </form>

</div>