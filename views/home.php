<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Financial table</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style2.css">
    <link rel="shortcut icon" href="/public/img/user.png" type="image/png">
</head>

<body>
<header class="header flex_center_hor flex_center_vert">
    <div class="container flex_center_vert flex_center_hor">
        <a class="logo flex_center_hor flex_center_vert" href="?">
            <p>LOGO</p>
        </a>

        <form action="?" method="post" class="header_buttons" id="header_buttons">
            <a href="#" class="header_link_1" id="tenantsButton">Арендаторы</a>
            <a href="#" class="header_link_2" id="financeButton">Финансовая таблица</a>
            <input type="hidden" name="mainTemplate" value="home" id="mainTemplate">
            <input type="hidden" name="contentTemplate" value="default" id="contentTemplate">
        </form>

        <form action="?" class="header_left" id="formTopMenu" method="post">
            <a href="#" class="settings" id="push_settings">
                <img class="settings_img" src="/public/img/Black_Settings.png" alt="settings">
            </a>
            <a href="#" class="pass" id="push_exit">
                <img src="/public/img/Rectangle_288.png" alt="pass">
            </a>
            <input type="hidden" name="action" value="false" id="logout">
        </form>

    </div>
</header>
<article class="wrap wrap__home container">
    <?= $content ?>
</article>
<footer class="footer">
    <div class="footer_content">
        <a href="#" class="footer_content_1">© 2019 Правила использования</a>
        <a href="#" class="footer_content_2">Контакты</a>
    </div>
</footer>
<?= $htmlScripts ?>
</body>
</html>