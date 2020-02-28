<?php

$id_article = (int)$param[1];

$new_article = new \advor\models\Article($db);

$key = new \advor\module\SessionVar(UID . 'key');

$article = $new_article->getDetal($id_article, $key->getValue());

$text = advor\models\Convert::text2html($article['article']);

require_once 'views/detal.php';
