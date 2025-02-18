<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;

class ArticleController extends Controller
{
    public function route(): void
    {
        try
        {
            if (isset ($_GET['action']))
            {
                switch ($_GET['action'])
                {
                    case 'showAll':
                        $this->showAll();
                        break;
                    case 'showId':
                        if (isset($_GET['id'])){
                            $id = (int)$_GET['id'];
                            $this->show($id);
                        break;
                        }
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : " . $_GET['action']);
                        break;
                }
            }
            else
            {
                throw new \Exception("Aucune action détectée");
            }
        }catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function showAll()
    {
        $articleRepo = new ArticleRepository;
        $articles = $articleRepo->findAll();

        $this->render('article/list', [
                'articles' => $articles
            ]);
        
    }

    protected function show($id)
    {
        $articleRepo = new ArticleRepository;
        $article = $articleRepo->findByID($id);

        $commentRepo = new CommentRepository;
        $comments = $commentRepo->findByComment($id);

        $this->render('article/articleId', [
            'article' => $article,
            'comments' => $comments,
        ]);
        
    }
}