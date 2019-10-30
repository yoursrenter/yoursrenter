<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>- Your Renter -</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<header class="header container">
    <a href="?">
        <div class="logo">logo</div>
    </a>
    <form action="?" class="right" id="formTopMenu" method="post">
        <a href="#" id="push_settings">
            <div class="pic">
                settings
            </div>
        </a>
        <a href="#" id="push_exit">
            <div class="pic">
                exit
            </div>
        </a>
        <input type="hidden" name="action" value="false" id="logout">
    </form>
</header>
<article class="wrap wrap__home container">
    <?= $content ?>
</article>
<footer class="footer container">
    <a href="#"><p>&copy;&nbsp;2019 Правила использования</p></a>
    <a href="#"><p>Контакты</p></a>
</footer>
<?= $htmlScripts ?>
</body>
</html>