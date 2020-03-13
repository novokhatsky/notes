<?php

$id_article = (int)$param[1];

$article = new \advor\models\Article($db);

$key = new \advor\module\SessionVar(UID . 'key');

$article = $article->getDetal($id_article, $key->getValue());

require_once 'views/detal.php';

