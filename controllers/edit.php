<?php

define('DEFAULT_USER', 1);

$new_article = new \advor\models\Article($db);

$key = new \advor\module\SessionVar(UID . 'key');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {

        if (!empty($_POST['header']) && !empty($_POST['keywords']) && !empty($_POST['article'])) {
            $article['header'] = htmlspecialchars($_POST['header']);
            $article['keywords'] = htmlspecialchars($_POST['keywords']);
            $article['article'] = advor\models\Convert::html2text(nl2br($_POST['article'], false));

            $article['id_author'] = (isset($_POST['private'])) ? $id_current_user->getValue() : DEFAULT_USER;

            $id_article = isset($_POST['id_article']) ? (int)$_POST['id_article'] : 0;

            if ($id_article) {
                if ($new_article->update($id_article, $article, $key->getValue())) {
                    header('Location: ' . BASE_URL);
                    exit();
                }
            } else {
                if ($new_article->add($article, $key->getValue())) {
                    header('Location: ' . BASE_URL);
                    exit();
                }
            }
        }
    } else {
        // нажата кнопка отмены
        header('Location: ' . BASE_URL);
        exit();
    }
}

$id_article = isset($param[1]) ? (int)$param[1] : false;

if ($id_article) {
    // редактируем
    $article_detail = $new_article->getDetal($id_article, $key->getValue());
    $status_private = $article_detail['id_author'] != 1? 'checked' : '';
    $article_header = $article_detail['header'];
    $article_text = str_replace('<br>', '', \advor\models\Convert::text2html($article_detail['article']));

    $article_keywords_array = $new_article->getKeywordsArticle($id_article);
    $article_keywords = [];

    foreach ($article_keywords_array as $str) {
        $article_keywords[] = $str['keyword'];
    }

    $article_keywords = implode(', ', $article_keywords);

} else {
    // создаем
    $article_keywords = '';
    $article_detail = ['header' => '', 'article' => ''];
}

require_once 'views/create.php';

