<?php
namespace App\Table;

use \PDO;
use App\Table\Exception\NotFoundException;


abstract class Table {
    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct(PDO $pdo){

        if($this->table === null){
            throw new \Exception("La classe " . get_class($this) . " n'a pas de propriété \$table");
        }
        if($this->class === null){
            throw new \Exception("La classe " . get_class($this) . " n'a pas de propriété \$class");
        }
        $this->pdo = $pdo;
    }


    public function find(int $id)
    {

        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, $this->class);

$result = $query->fetch();

if($result === false){

    throw new NotFoundException($this->table, $id);
}
        return $result;  //Le fetch All donne un tableau donc on mets le 0 pour récupérer le 1er ou l_unique article ici


    }
}