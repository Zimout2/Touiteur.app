<?php

namespace Entite;

use \Entity;

class Tag extends Entity {
    protected $id;
    protected $nom;
    public function __construct(int $id, string $nom) {
        parent::__construct($id, $nom);
    }

    public function existe(int $id) : bool {
        if ($this->id == $id) {
            return true;
        }
        return false;
    }

}