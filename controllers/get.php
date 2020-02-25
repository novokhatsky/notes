<?php

$id_article = (int)$param[1];

$new_article = new \advor\models\Article($db);

$article = $new_article->getDetal($id_article);

$text = advor\models\Convert::text2html($article['article']);

require_once 'views/detal.php';
