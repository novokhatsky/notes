<?php

$seekString = $param[1];

$id_default_user = 1;
$id_author = $id_current_user->getValue() ? $id_current_user->getValue() : $id_default_user;

$seek = explode(' ', $seekString);

$new_article = new \advor\models\Article($db);

advor\module\Tools::send_json($new_article->list($seek, $id_author));

