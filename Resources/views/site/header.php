<html>

<body>

    <?php if (isset($_SESSION['user'])) : ?>
        <a href="/user/logout">Выход</a>
    <?php else : ?>
        <a href="/user/registration">Регестрация</a>
        <a href="/user/login">Вход</a>
    <?php endif; ?>

</body>

</html>