<?php 

use App\URL;
use \App\Connexion;
use App\Model\{Category, Post};


$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPDO();
$query = $pdo->prepare('SELECT * FROM category WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);

/** @var Category|false */
$category = $query->fetch();  //Le fetch All donne un tableau donc on mets le 0 pour récupérer le 1er ou l_unique article ici


if($category === false){
    throw new Exception("Aucune catégorie ne correspond à cet ID");
    
}

if($category->getSlug() !== $slug){
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' .$url);
};

$title = "Categorie {$category->getName()}";


$paginatedQuery = new PaginatedQuery(
    "SELECT p.* 
     FROM post P
     JOIN post_category pc ON pc.post_id = p.id
     WHERE pc.category_id = {$category->getId()}
     ORDER BY created_at DESC",

    "SELECT COUNT(category_id) FROM post_category 
     WHERE category_id = {$category->getId()}",

    Post::class
);

$currentPage = URL::getPositiveInt('page', 1);

$count = (int)$pdo->query('SELECT COUNT(category_id) FROM post_category WHERE category_id = ' . $category->getId())
->fetch(PDO::FETCH_NUM)[0]; //Le PDO::FETCH_NUM permettra de récupérer la valeur 50

$perPage = 12;
$pages = ceil($count / $perPage);

if($currentPage > $pages){
    throw new Exception("Cette Page n'existe pas");
    
}

$offset = $perPage * ($currentPage - 1);
$query = $pdo->query("
SELECT p.* 
FROM post P
JOIN post_category pc ON pc.post_id = p.id
WHERE pc.category_id = {$category->getId()}
ORDER BY created_at DESC 
LIMIT $perPage OFFSET $offset
");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);

$link = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);

?>




<h1><?= e($title) ?></h1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require dirname(__DIR__) . '/Post/card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<?php if($currentPage > 1): ?>

    <?php
    $l = $link;
    if ($currentPage > 2) $l = $link . '?page=' . ($currentPage - 1);
    ?>
    <a href="<?= $l ?>">Page Précédente</a>
<?php endif ?>
<?php if($currentPage < $pages): ?>
    <a href="<?= $link ?>?page=<?=$currentPage + 1?>">Page Suivante</a>
<?php endif ?>





