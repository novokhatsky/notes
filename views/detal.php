<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="/notes/css/main.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="content">
    <h3><?=$article['header']?></h3>
    <div><?=$article['article']?></div>
</div>

<form>
    <button class="button" formaction="<?=BASE_URL?>">Назад</button>
    <button class="button" formaction="<?=BASE_URL?>edit/<?=$id_article?>">Редактор</button>
</form>


</body>
</html>
