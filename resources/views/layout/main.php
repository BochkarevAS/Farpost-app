<html>

<head></head>

<body>

<?php if (isset($_SESSION['user'])) : ?>
    <a href="/user/logout">Выход</a>
<?php else : ?>
    <a href="/user/registration">Регестрация</a>
    <a href="/user/login">Вход</a>
<?php endif; ?>

<?php if (isset($content)) : ?>
    <?= $content ?>
<?php endif; ?>

<script src="/resources/js/main.js"></script>

</body>
</html>