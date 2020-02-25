<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Справочник</title>
    <link href="/notes/css/main.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<form action="<?=BASE_URL . 'edit/' . $id_article?>" method="post" class="content algn-cnt">
    <input type="hidden" name="id_article" value="<?=$id_article?>">
    <div>Заголовок</div>
    <div><input type="text" name="header" class="input" value="<?=$article_header?>" required></div>
    <div>Ключевые слова (через запятую)</div>
    <div><input type="text" name="keywords" class="input" value="<?=$article_keywords?>" required></div>
    <?php
        if ($id_current_user->getValue()) { ?>
            <div><input type="checkbox" name="personal"> Личное</div>
    <?php
        }
    ?>
    <div>Статья</div>
    <div>
        <input type="button" value="B" onclick="b()" class="button b-small">
        <input type="button" value="I"  onclick="i()" class="button b-small">
        <input type="button" value="code" onclick="code()" class="button b-small">
    </div>
    <textarea id="article" name="article" class="input input-ta" required><?=$article_text?></textarea>
    <br>
    <a href="<?=BASE_URL?>"><button class="button">Отмена</button></a>
    <input type="submit" name="save" value="Сохранить" class="button">
</form>

<script>
    function replace(start, end) {
        const el = document.getElementById("article");
        const text = el.value;
        const st = el.selectionStart;
        const en = el.selectionEnd;

        let res = "";
        if (st == en) {
            const p1 = text.substring(0, st);
            const p2 = text.substring(st);
            res = p1 + start + end + p2;
        } else {
            res = text.substring(0, st) + start + text.substring(st, en) +
                end + text.substring(en);
        }

        el.value = res;
    }

    function b() {
        replace("<b>", "</b>");
    }

    function i() {
        replace("<i>", "</i>");
    }

    function code() {
        replace("<code>", "</code>");
    }
</script>
</body>
</html>
