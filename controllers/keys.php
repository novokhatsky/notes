<?php

$keywords = $param[1];

$keywords = trim($keywords);

while (strpos($keywords, '  ') !== false) {
    $keywords = str_replace('  ', ' ', $keywords);
}

$seek = explode(' ', $keywords);

$new_article = new \advor\models\Article($db);

advor\module\Tools::send_json($new_article->keywords($seek));

