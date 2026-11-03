<?php

namespace touiteur\entite;

class User {
    protected string $prenom;
    protected string $nom;
    protected string $email;
    protected int $nb_touile;
    protected array $liste_suivie;
    protected array $liste_touite;
    protected array $liste_touite_liker;
    protected array $liste_touite_disliker;
    protected array $liste_tag;
    protected array $liste_follow;
    protected int $id;

    public function __construct(string $prenom, string $email, int $nb_touite, int $id, array $liste_follow, array $liste_suivie, array $liste_touite, array $liste_tag, array $liste_touite_liker, array $liste_touite_disliker, string $nom) {
        $this->prenom = $prenom;
        $this->email = $email;
        $this->nb_touile = $nb_touite;
        $this->id = $id;
        $this->liste_follow = $liste_follow;
        $this->liste_touite = $liste_touite;
        $this->liste_tag = $liste_tag;
        $this->liste_suivie = $liste_suivie;
        $this->liste_touite_liker = $liste_touite_liker;
        $this->liste_touite_disliker = $liste_touite_disliker;
        $this->nom = $nom;
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
    public function getNbTouite(): int {
        return $this->nb_touile;
    }
    public function setNbTouite(int $nb_touile): void {
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
    public function getListe_touites_liker(): array {
        return $this->liste_touite_liker;
    }
    public function setListe_touites_liker(array $liste_touite_liker): void {
        $this->liste_touite_liker = $liste_touite_liker;
    }
    public function getListe_touites_disliker(): array {
        return $this->liste_touite_liker;
    }
    public function setListe_touites_disliker(array $liste_touite_disliker): void {
        $this->liste_touite_disliker = $liste_touite_disliker;
    }
    public function getNom(): string {
        return $this->nom;
    }
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }
}