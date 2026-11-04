<?php

namespace touiteur\entite;

class Tag {
    private int $id;
    private string $libelle;
    private string $description;
    private array $liste_suivie;
    private array $liste_touites;

    public function __construct(int $id, string $libelle, string $description) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->liste_suivie = [];
        $this->liste_touites = [];
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
        return $this->liste_touites;
    }
    public function getListe_Touites(): array {
        return $this->liste_touites;
    }
    public function setListeSuivie(array $liste_suivi): void {
        $this->liste_suivie = $liste_suivi;
    }
    public function setListeTouites(array $liste_touites): void {
        $this->liste_touites = $liste_touites;
    }
    public function setDescription(string $description): void {
        $this->description = $description;
    }
    public function setLibelle(string $libelle): void {
        $this->libelle = $libelle;
    }





    public function existe(int $id) : bool {
        if ($this->id == $id) {
            return true;
        }
        return false;
    }


    public function addListeSuivi (int $idUser): void {
        if (!in_array($idUser, $this->liste_suivie)) {
            $this->liste_suivie[] = $idUser;
        }
    }

    public function addListeTouite (int $idTouite): void {
        if (!in_array($idTouite, $this->liste_touites)) {
            $this->liste_touitse[] = $idTouite;
        }
    }

    public function removeListeSuivi (int $idUser): void {
        if (in_array($idUser, $this->liste_suivie)) {
            unset($liste_suivie[array_search($idUser, $this->liste_suivie)]);
        }
    }

    public function removeListeTouite (int $idTouite): void {
        if (in_array($idTouite, $this->liste_touites)) {
            unset($liste_touites[array_search($idTouite, $this->liste_touites)]);
        }
    }

    public function isListeSuivi (int $idUser): bool {
        return (in_array($idUser, $this->liste_suivie));
    }

    public function isListeTouite (int $idTouite): bool {
        return (in_array($idTouite, $this->liste_touites));
    }



}