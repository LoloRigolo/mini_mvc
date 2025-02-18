<?php

namespace App\Repository;

use App\Entity\Comment;

class CommentRepository extends Repository
{
    public function findByComment($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM comment WHERE article_id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
        $comments = $query->fetchAll($this->pdo::FETCH_ASSOC);
        $commentsObjects = [];
        foreach($comments as $comment) {
            $commentsObjects[] = Comment ::createAndHydrate($comment);
        }
        return $commentsObjects;
    }
}