<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="<?=BASE_URL?>css/main.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<form class="content algn-cnt" method="post">
    <div>Логин</div>
    <div><input type="text" name="login" class="input inp-small" required></div>
    <div>Пароль</div>
    <div><input type="password" name="password" class="input inp-small" required></div>
    <div>Повторите пароль</div>
    <div><input type="password" name="password2" class="input inp-small" required></div>
    <div>
        <a href="<?=BASE_URL?>"><button class="button">Отмена</button></a>
        <input type="submit" name="register" value="Регистрация" class="button">
    </div>
</form>

<div class="content algn-cnt err"><?=$msg->popValue()?></div>

<div>
</div>

</body>
</html>
