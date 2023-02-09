<?php

namespace App;

use \PDO;

class Connexion
{

    public static function getPDO(): PDO
    {

        return new PDO('mysql:host=127.0.0.1;dbname=grafikart;charset=utf8', 'root', '', [
    
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            
        ]);
    }
    
}
