<?php require_once _TEMPLATEPATH_ . '/header.php';
/** @var \App\Entity\Article $article */
/** @var \App\Entity\Comment $comments */

//ce qui arrive de Entity article
?>

<div>
    <h3><?=$article->getTitle()?></h3>
    <p><?=$article->getDescription()?></p>
    <div>
    <h4>Commentaires :</h4>
    <ul>
        <?php foreach($comments as $comment):?>
        <li>
            <p><?=$comment->getComment();?></p>
        <?php endforeach; ?>
    </ul>
    </div>
    <button type="button"><a href="/?controller=article&action=showAll">< retour</a></button>
</div>



<?php require_once _TEMPLATEPATH_ . '/footer.php'; ?>