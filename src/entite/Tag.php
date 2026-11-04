<?php

namespace touiteur\entite;

class Tag {
    protected int $id;
    protected string $libelle;
    protected string $description;
    protected array $liste_suivie;
    protected array $liste_touites;

    public function __construct(int $id, string $libelle, string $description, array $liste_suivie, array $liste_touites) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->liste_suivie = $liste_suivie;
        $this->liste_touites = $liste_touites;
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
    public function getListe_Touites(): array {
        return $this->liste_touites;
    }
    public function setListeSuivie(array $liste_tuites): void {
        $this->liste_tuites = $liste_tuites;
    }
    public function setListeTouites(array $liste_touites): void {
        $this->liste_touites = $liste_touites;
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