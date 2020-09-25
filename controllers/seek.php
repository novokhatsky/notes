<?php

$seekString = htmlspecialchars($param[1]);

$saveSeekStr = new \advor\module\SessionVar(UID . 'seek_str', $seekString);

$id_default_user = 1;
$id_author = $id_current_user->getValue() ? $id_current_user->getValue() : $id_default_user;

$seek = explode(' ', $seekString);

$new_article = new \advor\models\Article($db);

advor\module\Tools::send_json($new_article->list($seek, $id_author));

