<?php 

use \App\Connexion;
use App\PaginatedQuery;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\Model\{Category, Post};


$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPDO();

$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);


if($category->getSlug() !== $slug){
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' .$url);
};

$title = "Categorie {$category->getName()}";


[$posts, $paginatedQuery] = (new PostTable($pdo))->FindPaginatedForCategory($category->getID());

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

<div>
    <?= $paginatedQuery->previousLink($link) ?>
</div>
<div>
    <?= $paginatedQuery->nextLink($link) ?>
</div>
 





