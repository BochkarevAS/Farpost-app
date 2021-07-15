<?php if (isset($errors) && is_array($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div style="text-align: center;">
    <h1>Регестрация</h1>

    <form method="post" action="/registration/register">
        <label>Nickname <input type="text" name="nickname"></label>
        <br><br>
        <label>Email <input type="text" name="email"></label>
        <br><br>
        <label>Password <input type="password" name="password"></label>
        <br><br>
        <label>Password repeat<input type="password" name="repeat"></label>
        <input type="submit" name="submit" value="Регестрация">
    </form>
</div>