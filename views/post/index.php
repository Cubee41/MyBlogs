<?php 

use \App\Connexion;
use App\Table\PostTable;

$title = "Mon Blog";
$pdo = Connexion::getPDO();

$table = new PostTable($pdo);
list($posts, $pagination) = $table->findPaginated();  
//La fonction list va ^permettre de décomposer le tableau (table) en sauvegardant la 1ere valeure dans $posts et la seconde dans $pagination


$link = $router->url('home');

?>

<?php





?>



<h1>Mon blog</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div>
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>