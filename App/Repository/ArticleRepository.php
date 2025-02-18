<?php

namespace App\Repository;

use App\Entity\Article;

class ArticleRepository extends Repository {


    public function findAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM article");
        $query->execute();
        $articles = $query->fetchAll($this->pdo::FETCH_ASSOC);
        $articlesObjects = [];
        foreach($articles as $article) {
            $articlesObjects[] = Article::createAndHydrate($article);
        }
        return $articlesObjects;
    }

    public function findById($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM article WHERE id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
        $article = $query->fetch($this->pdo::FETCH_ASSOC);
        return Article::createAndHydrate($article);
    }

}