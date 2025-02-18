<?php require_once _TEMPLATEPATH_ . '/header.php';
/** @var \App\Entity\Article $articles */
//ce qui arrive de Entity article
?>

<div>
    <ul>
        <?php foreach($articles as $article):?>
        <li>
            <h3><?=$article->getTitle();?></h3>
            <a href='/?controller=article&action=showId&id=<?=$article->getId();?>'>Lire plus...</a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>



<?php require_once _TEMPLATEPATH_ . '/footer.php'; ?>