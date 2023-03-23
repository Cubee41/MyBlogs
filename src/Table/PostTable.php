<?php 

namespace App\Table;

use \PDO;
use \Exception;
use App\Model\Post;
use App\Model\Category;
use App\PaginatedQuery;
use App\Table\CategoryTable;

class PostTable extends Table{


    protected $table = "post";
    protected $class = Post::class;

    public function delete(int $id)
    {

        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $deleted = $query->execute([$id]);

        if($deleted === false){
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }

    }
    


    public function findPaginated() {
        
        $paginatedQuery = new PaginatedQuery(

            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM post",
            $this->pdo
        
        );
        $posts = $paginatedQuery->getItems(Post::class);

        (new CategoryTable($this->pdo))->hydratedPosts($posts);

return [$posts, $paginatedQuery];

    }


    public function findPaginatedForCategory(int $categoryID)
    {

        $paginatedQuery = new PaginatedQuery(
            "SELECT p.* 
             FROM post P
             JOIN post_category pc ON pc.post_id = p.id
             WHERE pc.category_id = {$categoryID}
             ORDER BY created_at DESC",
        
            "SELECT COUNT(category_id) FROM post_category 
             WHERE category_id = {$categoryID}"
        );
        
        $posts = $paginatedQuery->getItems(Post::class);
        
        (new CategoryTable($this->pdo))->hydratedPosts($posts);

        return [$posts, $paginatedQuery];


    }

    public function update(Post $post):void
    {

        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name WHERE id = :id");
        $edited = $query->execute([
            'id' => $post->getID(),
            'name' => $post->getName()
        ]);
        
    }

}

