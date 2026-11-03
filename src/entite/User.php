<?php

namespace touiteur\entite;

class User {
    protected int $id_user;
    protected string $prenom;
    protected string $nom;
    protected string $email;
    protected int $id_suivie;
    protected int $id_touite;
    protected int $id_follow;

    public function __construct(int $id_user, string $nom, string $prenom, string $email, int $id_suivie, int $id_touite, int $id_follow) {
        $this->id_user = $id_user;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->id_suivie = $id_suivie;
        $this->id_touite = $id_touite;
        $this->id_follow = $id_follow;
    }
    public function getIdUser(): int {
        return $this->id_user;
    }
    public function getIdTuite(): int {
        return $this->id_touite;
    }
    public function getPrenom(): string {
        return $this->prenom;
    }
    public function getNom(): string {
        return $this->nom;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getIdSuivie(): int {
        return $this->id_suivie;
    }
    public function getIdFollow(): int {
        return $this->id_follow;
    }
    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    public function setIdSuivie(int $id_suivie): void {
        $this->id_suivie = $id_suivie;
    }
    public function setIdFollow(int $id_follow): void {
        $this->id_follow = $id_follow;
    }
}