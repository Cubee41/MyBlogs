<?php
namespace App\Table;

use \PDO;
use App\Model\Category;

final class CategoryTable extends Table{

    protected $table = "category";
    protected $class = Category::class;
    
    /**
     * hydratePosts
     *
     * @param  App\Model\Post[] $posts
     * @return void
     */
    public function hydratedPosts(array $posts): void
    {

        $postsById = [];
foreach ($posts as $post) {
    $postsById[$post->getID()] = $post;
}



$categories = $this->pdo

    ->query('SELECT c.*, pc.post_id
             FROM post_category pc
             JOIN category c ON c.id = pc.category_id
             WHERE pc.post_id IN (' . implode(',', array_keys($postsById)) . ')')
    ->fetchAll(PDO::FETCH_CLASS, $this->class);  


foreach ($categories as $category) {

    $postsById[$category->getPostId()]->addCategory($category);
    
}
        
    }
}