<?php

namespace touiteur\entite;

class Tag {
    protected int $id;
    protected string $libelle;
    protected string $description;
    protected array $liste_suivie;
    protected array $liste_tuites;

    public function __construct(int $id, string $libelle, string $description, array $liste_suivie, array $liste_tuites) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->liste_suivie = $liste_suivie;
        $this->liste_tuites = $liste_tuites;
    }
    public function getId(): int {
        return $this->id;
    }
    public function getLibelle(): string {
        return $this->libelle;
    }
    public function getDescription(): string {
        return $this->description;
    }
    public function getListeSuivie(): array {
        return $this->liste_tuites;
    }
    public function getListeTuites(): array {
        return $this->liste_tuites;
    }
    public function setListeSuivie(array $liste_tuites): void {
        $this->liste_tuites = $liste_tuites;
    }
    public function setListeTuites(array $liste_tuites): void {
        $this->liste_tuites = $liste_tuites;
    }
    public function setDescription(string $description): void {
        $this->description = $description;
    }
    public function existe(int $id) : bool {
        if ($this->id == $id) {
            return true;
        }
        return false;
    }

}