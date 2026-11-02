<?php
declare(strict_types=1);

abstract class Entite {
    protected string $pseudo;
    protected int $id;
    protected array $liste_suivie;
    protected array $liste_follow;

    public function __construct(string $pseudo, int $id, int $liste_suivie) {
        $this->pseudo = $pseudo;
        $this->id = $id;
        $this->liste_suivie = [];
        $this->liste_follow = [];
    }

    public function getPseudo(): string {
        return $this->pseudo;
    }
    public function setPseudo(string $pseudo): void {
        $this->pseudo = $pseudo;
    }

    public function setID(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }
    public function getListeSuivie(): array {
        return $this->liste_suivie;
    }

    public function setListeSuivie(array $liste_suivie): void {
        $this->liste_suivie = $liste_suivie;
    }

    public function getListeFollow(): array {
        return $this->liste_follow;
    }
    public function setListeFollow(array $liste_follow): void {
        $this->liste_follow = $liste_follow;
    }
}