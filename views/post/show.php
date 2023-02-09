<?php

use \App\Connexion;
use \App\Model\Post;
use App\Model\Category;
use App\Table\PostTable;
use App\Table\CategoryTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPDO();
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratedPosts([$post]);

if($post->getSlug() !== $slug){
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' .$url);
};



$title = "Un post";
?>



<h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
            <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y')  ?></p>

            <?php foreach ($post->getCategories() as $k => $category): ?>

                <?php if($k > 0): ?>,
                <?php endif ?>
                <a href=" <?= $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]) ?>">
                <?= e($category->getName()) ?>
            </a>

            <?php endforeach ?>
            <p><?= $post->getFormatedContent() ?> </p>
            