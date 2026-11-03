<?php

namespace touiteur\entite;

class User {
    protected string $name;
    protected string $prenom;
    protected string $email;
    protected int $nb_touile;
    protected array $liste_suivie;
    protected array $liste_touite;
    protected array $liste_tag;
    protected array $liste_follow;
    protected int $id;

    public function __construct(string $name, string $prenom, string $email, int $nb_touile, int $id, array $liste_follow, array $liste_suivie, array $liste_touite, array $liste_tag) {
        $this->name = $name;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->nb_touile = $nb_touile;
        $this->id = $id;
        $this->liste_follow = $liste_follow;
        $this->liste_touite = $liste_touite;
        $this->liste_tag = $liste_tag;
        $this->liste_suivie = $liste_suivie;
    }
    public function getName(): string {
        return $this->name;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }
    public function getPrenom(): string {
        return $this->prenom;
    }
    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    public function getNbTouile(): int {
        return $this->nb_touile;
    }
    public function setNbTouile(int $nb_touile): void {
        $this->nb_touile = $nb_touile;
    }
    public function getListeSuivie(): array {
        return $this->liste_suivie;
    }
    public function setListeSuivie(array $liste_suivie): void {
        $this->liste_suivie = $liste_suivie;
    }
    public function getListeTouite(): array {
        return $this->liste_touite;
    }
    public function setListeTouite(array $liste_touite): void {
        $this->liste_touite = $liste_touite;
    }
    public function getListeTag(): array {
        return $this->liste_tag;
    }
    public function setListeTag(array $liste_tag): void {
        $this->liste_tag = $liste_tag;
    }
    public function getId(): int {
        return $this->id;
    }
    public function getListeFollow(): array {
        return $this->liste_follow;
    }
    public function setListeFollow(array $liste_follow): void {
        $this->liste_follow = $liste_follow;
    }
}