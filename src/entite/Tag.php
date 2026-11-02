<?php

namespace Entite;

use \Entity;

class Tag extends Entity {
    protected string $pseudo;
    protected int $id;
    protected array $liste_suivie;
    protected array $liste_follow;
    public function __construct(string $pseudo, int $id, int $liste_suivie, int $liste_follow) {
        parent::__construct($pseudo, $id, $liste_suivie, $liste_follow);
    }

    public function existe(int $id) : bool {
        if ($this->id == $id) {
            return true;
        }
        return false;
    }

}