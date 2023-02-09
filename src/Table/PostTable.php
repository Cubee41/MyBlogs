<?php 

namespace App\Table;

use \PDO;
use App\Model\Post;
use App\Model\Category;
use App\PaginatedQuery;
use App\Table\CategoryTable;

class PostTable extends Table{


    protected $table = "post";
    protected $class = Post::class;

    


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

}

