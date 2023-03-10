<?php
$categories = array_map(function($category) use ($router) {

    $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
    return <<<HTML
<a href="{$url}" > {$category->getName()} </a>
HTML;

}, $post->getCategories());

// foreach ($post->getCategories() as $k => $category) {
//     $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
//     $categories[] = <<<HTML
// <a href="{$url}" > {$category->getName()} </a>
// HTML;
    
    // "
    // <a href=\"" . $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]) . "\"> "
    //  . e($category->getName()) . "</a>";  
// }


?>


<div class="card">
            <div class="card-body">
            <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
            <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y')  ?> ::

                <?php if(!empty($post->getCategories())): ?>
                ::
                <?= implode(', ', $categories) ?>

                <?php endif ?>
        
            </p>
            <p><?= $post->getExcerpt() ?> </p>
            <p>
                <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug() ]) ?>
                
                " class="btn btn-primary">Voir Plus</a>
            </p>
            </div>
        </div>