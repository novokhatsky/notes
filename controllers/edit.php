<?php

define('DEFAULT_USER', 1);

$new_article = new \advor\models\Article($db);

$key = new \advor\module\SessionVar(UID . 'key');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {

        if (!empty($_POST['header']) && !empty($_POST['keywords']) && !empty($_POST['article'])) {
            $article['header'] = htmlspecialchars($_POST['header']);
            $article['keywords'] = htmlspecialchars($_POST['keywords']);
            $article['article'] = $_POST['article'];
            $id_article = isset($_POST['id_article']) ? (int)$_POST['id_article'] : 0;

            if ($id_article) {
                // узнаем автора статьи, тем самым проверим права на изменение статьи
                $id_author = $new_article->getIdAuthor($id_article);

                if ($id_author['id_author'] != $id_current_user->getValue() && $id_author['id_author'] != DEFAULT_USER) {
                    // нет прав на редактирование
                    header('Location: ' . BASE_URL);
                    exit();
                }

                // если это автор статьи, то указываем пароль, разрешая шифрование
                $pass = ($id_author['id_author'] != DEFAULT_USER) ? $key->getValue() : '';

                if ($new_article->update($id_article, $article, $pass)) {
                    header('Location: ' . BASE_URL . 'get/' . $id_article);
                    exit();
                }
            } else {
                // если сообщение приватное, то сохраняем автора и разрешим шифрование указав ключ
                if (isset($_POST['private'])) {
                    $article['id_author'] = $id_current_user->getValue();
                    $pass = $key->getValue();
                } else {
                    $article['id_author'] = DEFAULT_USER;
                    $pass = '';
                }

                // если статья добавится, то получаем id и переходим на страницу вывода статьи
                $id_article = $new_article->add($article, $pass);
                if ($id_article) {
                    header('Location: ' . BASE_URL . 'get/' . $id_article);
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
    $article_header = $article_detail['header'];
    $article_text = str_replace('<br>', '', $article_detail['article']);

    $article_keywords_array = $new_article->getKeywordsArticle($id_article);
    $article_keywords = [];

    foreach ($article_keywords_array as $str) {
        $article_keywords[] = $str['keyword'];
    }

    $article_keywords = implode(', ', $article_keywords);

} else {
    // создаем
    $article_keywords = '';
    $article_header = '';
    $article_text = '';
}

require_once 'views/create.php';

