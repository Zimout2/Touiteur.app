<?php

namespace touiteur\entite;

class User {
    protected string $name;
    protected string $prenom;
    protected string $email;
    protected int $nb_tuile;
    protected array $liste_suivie;
    protected array $liste_tuite;
    protected array $liste_tag;
    protected int $id;

    public function __construct(string $name, string $prenom, string $email, int $nb_tuile, int $id) {
        $this->name = $name;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->nb_tuile = $nb_tuile;
        $this->liste_suivie = [];
        $this->liste_tuite = [];
        $this->liste_tag = [];
        $this->id = $id;
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
    public function getNbTuile(): int {
        return $this->nb_tuile;
    }
    public function setNbTuile(int $nb_tuile): void {
        $this->nb_tuile = $nb_tuile;
    }
    public function getListeSuivie(): array {
        return $this->liste_suivie;
    }
    public function setListeSuivie(array $liste_suivie): void {
        $this->liste_suivie = $liste_suivie;
    }
    public function getListeTuite(): array {
        return $this->liste_tuite;
    }
    public function setListeTuite(array $liste_tuite): void {
        $this->liste_tuite = $liste_tuite;
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
}