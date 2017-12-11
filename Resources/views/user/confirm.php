<?php require_once(ROOT . '/Resources/views/layout/header.php'); ?>

<h1>Подтвердить email</h1>

<form action="" method="POST">
    <table>
        <tbody>
        <tr>
            <td>Код:</td>
            <td><input type="email" name="email"></td>
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
