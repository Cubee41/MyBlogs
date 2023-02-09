<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Mon Site' ?></title>
</head>
<body>

<nav>

           <a href="">Mon site</a>

</nav>

<div>

              <?= $content ?>

</div>

<footer>

<?php 

if(defined('DEBUG_TIME')):

?>
Page généré en <?= round(1000 * ( microtime(true) - DEBUG_TIME)) ?> ms

<?php endif ?>

</footer>
    
</body>
</html>

