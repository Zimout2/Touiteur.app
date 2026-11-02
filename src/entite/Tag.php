<?php

namespace Entite;

class Tag {
    protected string $name;
    protected string $prenom;
    protected int $nb_tuile;
    protected array $liste_suivie;
    protected array $liste_tuite;
    protected array $liste_tag;
    public function __construct(string $name, string $prenom, int $nb_tuile, array $liste_suivie, array $liste_tuite, array $liste_tag) {
        $this->name = $name;
        $this->prenom = $prenom;
        $this->nb_tuile = $nb_tuile;
        $this->liste_suivie = $liste_suivie;
        $this->liste_tuite = $liste_tuite;
        $this->liste_tag = $liste_tag;
    }

    public function getName(): string {
        return $this->name;
    }
    public function getPrenom(): string {
        return $this->prenom;
    }
    public function getNbTuile(): int {
        return $this->nb_tuile;
    }
    public function getListeSuivie(): array {
        return $this->liste_suivie;
    }
    public function getListeTuite(): array {
        return $this->liste_tuite;
    }
    public function getListeTag(): array {
        return $this->liste_tag;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }
    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }
    public function setNbTuile(int $nb_tuile): void {
        $this->nb_tuile = $nb_tuile;
    }
    public function setListeSuivie(array $liste_suivie): void {
        $this->liste_suivie = $liste_suivie;
    }
    public function setListeTuite(array $liste_tuite): void {
        $this->liste_tuite = $liste_tuite;
    }
    public function setListeTag(array $liste_tag): void {
        $this->liste_tag = $liste_tag;
    }
    public function existe(int $id) : bool {
        if ($this->id == $id) {
            return true;
        }
        return false;
    }

}