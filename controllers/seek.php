<?php

$seekString = $param[1];

$seek = explode(' ', $seekString);

$new_article = new \advor\models\Article($db);
advor\module\Tools::send_json($new_article->list($seek));
