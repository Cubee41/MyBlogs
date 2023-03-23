<?php

use App\Connexion;
use App\Table\PostTable;

$success = false;

$pdo = Connexion::getPDO();

$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);


if(!empty($_POST)){

        $post->setName($_POST['name']);

        $postTable->update($post);
        $success = true;
}
?>

<?php if($success): ?>

    <h2>Article modifié avec succès </h2>

<?php endif ?>

<h1>Editer l'aricle <?= e($post->getName()) ?></h1>


<form action="" method="POST">

<div>
    <label for="name">Titre</label>
    <input type="text" name="name" value="<?= e($post->getName()) ?>" required>
</div>

<button type="submit">Modifier</button>
</form>



