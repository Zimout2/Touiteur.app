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

    public function getPseudo(): string {
        return $this->pseudo;
    }
    public function getId(): int {
        return $this->id;
    }
    public function getListeSuivie(): int {
        return $this->liste_suivie;
    }
    public function getListeFollow(): int {
        return $this->liste_follow;
    }
    public function getDate(): string {
        return $this->date;
    }
    public function setPseudo(string $pseudo): void {
        $this->pseudo = $pseudo;
    }

    public function setListeSuivie(int $liste_suivie): void {
        $this->liste_suivie = $liste_suivie;
    }
    public function setListeFollow(int $liste_follow): void {
        $this->liste_follow = $liste_follow;
    }
}