<?php

namespace advor\models;

Class Article
{
    use \advor\module\CryptoLib;
    use \advor\module\Convert;

    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function list($seek, $id_author)
    {
        foreach ($seek as &$key) {
            if (strlen($key) != 0) {
                $key = '%' . $key . '%';
            }
        }
        unset($key);

        for ($i = 0; $i < 6; $i++) {
            if (!isset($seek[$i])) {
                $seek[$i] = '';
            }
        }

        $query = '
            select
                id_article, header
            from
                articles
                join (
                    select
                        id_article, count(id_article) as cnt
                    from
                        interaction join keywords using (id_keyword)
                    where
                        keyword like :key1
                        or keyword like :key2
                        or keyword like :key3
                        or keyword like :key4
                        or keyword like :key5
                        or keyword like :key6
                    group by
                        id_article
                ) as seeked using (id_article)
            where
                id_author in (1, :id_author)
            order by
                cnt desc';

        return $this
                    ->db
                    ->getList($query, [
                                        'key1'      => $seek[0],
                                        'key2'      => $seek[1],
                                        'key3'      => $seek[2],
                                        'key4'      => $seek[3],
                                        'key5'      => $seek[4],
                                        'key6'      => $seek[5],
                                        'id_author' => $id_author,
                                      ]);
    }


    function keywords($seek)
    {
        for ($i = 0; $i < 6; $i++) {
            if (!isset($seek[$i])) {
                $seek[$i] = '';
            } else {
                $seek[$i] = '%' . $seek[$i] . '%';
            }
        }

        $query = '
            select
                id_keyword, keyword 
            from
                keywords
            where
                keyword like :key1
                or keyword like :key2
                or keyword like :key3
                or keyword like :key4
                or keyword like :key5
                or keyword like :key6';

        return $this
                    ->db
                    ->getList($query, [
                                        'key1' => $seek[0],
                                        'key2' => $seek[1],
                                        'key3' => $seek[2],
                                        'key4' => $seek[3],
                                        'key5' => $seek[4],
                                        'key6' => $seek[5],
                                      ]);
    }


    function getDetal($id_article, $key)
    {
        $query = 'select header, article, id_author from articles where id_article = :id_article';

        $article = $this
                        ->db
                        ->getRow($query, ['id_article' => $id_article]);

        if (strlen($key) && $article['id_author'] != 1) {
            $article['article'] = $this->decrypt($key, $article['article']);
        }

        $article['article'] = $this->text2html($article['article']);

        return $article;
    }


    function getIdAuthor($id_article)
    {
        $query = 'select id_author from articles where id_article = :id_article';

        return $this
                    ->db
                    ->getRow($query, ['id_article' => $id_article]);
    }


    function getKeywordsArticle($id_article)
    {
        $query = 'select keyword from interaction join keywords using(id_keyword) where id_article = :id_article';

        return $this
                    ->db
                    ->getList($query, ['id_article' => $id_article]);
    }


    function getIdKeyword($keyword)
    {
        $query = 'select id_keyword from keywords where keyword = :keyword';

        return $this
                    ->db
                    ->getRow($query, ['keyword' => $keyword]);
    }


    function addInteraction($id_article, $id_keyword)
    {
        $query = 'insert into interaction (id_article, id_keyword) values (:id_article, :id_keyword)';

        return $this
                    ->db
                    ->insertData($query, ['id_article' => $id_article, 'id_keyword' => $id_keyword]);
    }


    function addKeyword($keyword)
    {
        $query = 'insert into keywords (keyword) values (:keyword)';

        return $this
                    ->db
                    ->insertData($query, ['keyword' => $keyword]);
    }


    function addKey($id_article, $keywords)
    {
        $keywords = explode(',', $keywords);

        foreach ($keywords as $word) {
            $word = trim($word);
            $id_keyword = $this->addKeyword($word);

            if ($id_keyword == -1) {
                $result = $this->getIdKeyword($word);
                $id_keyword = $result['id_keyword'];
            }

            if ($this->addInteraction($id_article, $id_keyword) == -1) {
                if ($this->db->errInfo[1] != '1062') {
                    return false;
                }
            }
        }

        return true;
    }


    function add($article, $key)
    {
        $this->db->beginTransaction();

        $article['article'] = htmlspecialchars($this->html2text(nl2br($article['article'], false)));

        if (strlen($key)) {
            $text_article = $this->encrypt($key, $article['article']);
        } else {
            $text_article = $article['article'];
        }

        # вставляем статью, получаем id, вставляем ключевые поля
        $query = 'insert into articles (header, article, id_author) values (:header, :article, :id_author)';
        $id_article = $this
                            ->db
                            ->insertData($query, [
                                                    'header'    => $article['header'],
                                                    'article'   => $text_article,
                                                    'id_author' => $article['id_author'],
                                                 ]);

        if ($id_article != -1) {
            $error = false;
            if (!$this->addKey($id_article, $article['keywords'])) {
                $error = true;
            }
        } else {
            $error = true;
        }

        if ($error) {
            $this->db->rollBack();
            return false;
        } else {
            $this->db->commit();
            return true;
        }
    }


    function update($id_article, $article, $key)
    {
        $this->db->beginTransaction();

        $article['article'] = htmlspecialchars($this->html2text(nl2br($article['article'], false)));

        if (strlen($key)) {
            $text_article = $this->encrypt($key, $article['article']);
        } else {
            $text_article = $article['article'];
        }

        $query = 'update articles set header = :header, article = :article where id_article = :id_article';

        $result = $this
                        ->db
                        ->updateData($query, [
                                                'header'     => $article['header'],
                                                'article'    => $text_article,
                                                'id_article' => $id_article,
                                             ]);
        if ($result != -1) {
            $error = false;
            if (!$this->addKey($id_article, $article['keywords'])) {
                $error = true;
            }
        } else {
            $error = true;
        }

        if ($error) {
            $this->db->rollBack();
            return false;
        } else {
            $this->db->commit();
            return true;
        }
    }
}
