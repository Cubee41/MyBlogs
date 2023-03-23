<?php 

use App\Auth;
use \App\Connexion;
use App\Table\PostTable;


Auth::check();

$title = "Administration";
$pdo = Connexion::getPDO();

$table = new PostTable($pdo);
list($posts, $pagination) = $table->findPaginated();  
//La fonction list va permettre de décomposer le tableau (table) en sauvegardant la 1ere valeure dans $posts et la seconde dans $pagination


$link = $router->url('admin_posts');

?>

<?php if (isset($_GET['delete'])): ?>

    <div>
        <h4>Enregistrement réussi</h4>
    </div>

<?php endif ?>



<h1>Espace Administrateur</h1>

<div class="row">
    
    <div>
        <table>
            <thead>
                <th>id</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Date</th>
                <th>Actions</th>
                
            </thead>
            <tbody>
                <?php foreach($posts as $post): ?>
                    <tr>

                    <td>
                        #<?= $post->getId() ?>
                    </td>
                    <td>
                        
                    <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug() ]) ?>
                
                " class="btn btn-primary"><?= htmlentities($post->getName()) ?></a>
            
                    </td>

                    <td>
                    <?= $post->getExcerpt() ?>
                    </td>

                    <td>
                    <?= $post->getCreatedAt()->format('d F Y')  ?>
                    </td>
                    <td>
                    <td>
                        
                        <a href="<?= $router->url('admin_post', ['id' => $post->getID() ]) ?>">
                                   Editer
                        </a>
                        <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID() ]) ?>" method="POST" 
                        onsubmit="return confirm('Voulez-vous vraimer supprimer cet article ?')" style="display:inline">
                                   <button type="submit">Supprimer</button>
                        </form>
                
                        </td>
                    </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    
</div>

<div>
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>