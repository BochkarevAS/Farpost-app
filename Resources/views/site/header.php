<html>

<body>

    <?php if (User::isAuth()) : ?>
        <a href="/user/logout">Выход</a>
    <?php else : ?>
        <a href="/user/registration">Регестрация</a>
        <a href="/user/login">Вход</a>
    <?php endif; ?>

</body>

</html>