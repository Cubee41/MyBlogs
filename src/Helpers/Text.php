<?php
namespace App\Helpers; 

class Text {
    
    public static function excerpt(string $content, int $limit = 60): string
    {
        if (mb_strlen($content) <= $limit){
            return $content;
        }


        $lastspace = mb_strpos($content, ' ', $limit);    //Permet de trouver le premier espace après le mot ayant le 60ème caractère. Cela retourne un entier
        return substr($content, 0, $lastspace) . '...';
    }
}