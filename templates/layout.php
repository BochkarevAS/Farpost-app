<html>

<head></head>

<body>

    <?php if (isset($_SESSION['user'])) : ?>

        <?= $_SESSION['user'] ?>

        <a href="/security/logout">Выход</a>
    <?php else : ?>
        <a href="/security/registration">Регестрация</a>
        <a href="/security/login">Вход</a>
    <?php endif; ?>

    <?php if (isset($content)) : ?>
        <?= $content ?>
    <?php endif; ?>

<!--<script src="/public/js/main.js"></script>-->

</body>
</html>