<?php

namespace entite;

class User {
    protected string $pseudo;
    protected int $id;
    protected array $liste_suivie;
    protected array $liste_follow;
    protected string $date;
    public function __construct(string $pseudo, int $id, int $liste_suivie, int $liste_follow, string $date) {
        parent::__construct($pseudo, $id, $liste_suivie, $liste_follow);
        $this->date = $date;
    }
}