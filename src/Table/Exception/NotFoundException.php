<?php 

namespace App\Table\Exception;

class NotFoundException extends \Exception {

    public function __construct(string $table, int $id)
    {

        $this->message = "Aucun Enregistrement ne correspond à l'id #$id dans la table '$table'";
    }
}

