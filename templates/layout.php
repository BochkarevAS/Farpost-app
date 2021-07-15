<html>

<head></head>

<body>
    <?php if (isset($_SESSION['username'])) : ?>
        <?= $_SESSION['username'] ?>

        <a href="/security/logout">Выход</a>
    <?php else : ?>
        <div>
            <a href="/registration/register">Регестрация</a>
            <a href="/security/login">Вход</a>
        </div>
    <?php endif; ?>

    <br>

    <div>
        <a href="/user/list">Список пользователей</a>
    </div>

    <br>

    <div>
        <a href="/user/create">Создать</a>
    </div>

    <br>

    <hr>

    <?php if (isset($content)) : ?>
        <?= $content ?>
    <?php endif; ?>

<!--<script src="/public/js/main.js"></script>-->

</body>
</html>