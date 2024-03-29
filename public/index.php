<?php 

require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));


if(isset($_GET['page']) && $_GET['page'] === '1'){

       $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
       $get = $_GET;
       unset($get['page']);

       $query = http_build_query($get);
       if (!empty($query)) {
              $uri . '?' . $query;
       }
       header('Location: ' . $uri );
       http_response_code(301);
       exit();

}


$router = new App\Router(dirname(__DIR__) . '/views');

$router->get('/', 'post/index', 'home')
       ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
       ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')           //On aura un /slug qui peut etre de tout type et un tiret id qui sera un entier 28:52 chap 48 grafikart
       ->get('/admin', 'admin/post/index', 'admin_posts')
       ->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post')
       ->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete')
       ->get('/admin/post/new', 'admin/post/create', 'admin_post_create')
       ->run();


