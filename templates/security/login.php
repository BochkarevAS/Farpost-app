<?php if (isset($errors) && is_array($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div style="text-align: center;">
    <h1>Вход</h1>

    <form method="post" action="/security/login">
        <label>Email <input type="text" name="email"></label>
        <br><br>
        <label>Password <input type="password" name="password"></label>
        <input type="submit" name="submit" value="Вход">
    </form>
</div>