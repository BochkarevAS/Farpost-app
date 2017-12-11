<?php require_once(ROOT . '/Resources/views/layout/header.php'); ?>

<h1>Подтвердите email</h1>

<?php if ($error != false) : ?>
    <div>
        <?= $error ?>
    </div>
<?php endif; ?>

<form action="" method="POST">
    <table>
        <tbody>
        <tr>
            <td>Код:</td>
            <td><input type="text" name="code"></td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="submit" value="Войти">
            </td>
        </tr>
        </tbody>
    </table>
</form>

<?php require_once(ROOT . '/Resources/views/layout/footer.php'); ?>
