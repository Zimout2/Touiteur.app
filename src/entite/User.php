<?php

namespace touiteur\entite;

class User {

    private int $id;
    private string $prenom;
    private string $email;
    private int $nb_touite;
    private array $liste_suivie;
    private array $liste_follow;
    private array $liste_touite;
    private array $liste_touite_liker;
    private array $liste_tag;

    public function __construct(string $prenom, string $email, int $id) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->nb_touite = count($this->liste_touite);
        $this->liste_follow = [];
        $this->liste_touite = [];
        $this->liste_tag = [];
        $this->liste_suivie = [];
        $this->liste_touite_liker = [];
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
        return $this->nb_touite;
    }
    public function setNbTouite(int $nb_touite): void {
        if ($nb_touite+1 == count($this->liste_touite)) {
            $this->nb_touite = $nb_touite;
        }
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


    //! Ajouter les méthodes d'ajout

    public function addListeFollow (int $idUser): void {
        if (!in_array($idUser, $this->liste_follow)) {
            $this->liste_follow[] = $idUser;
        }
    }

    public function addListeTouite (int $idTouite): void {
        if (!in_array($idTouite, $this->liste_touite)) {
            $this->liste_touite[] = $idTouite;
        }
    }

    public function addListeTag (int $idTag): void {
        if (!in_array($idTag, $this->liste_tag)) {
            $this->liste_tag[] = $idTag;
        }
    }

    public function addListeSuivi (int $idUser): void {
        if (!in_array($idUser, $this->liste_suivie)) {
            $this->liste_suivie[] = $idUser;
        }
    }

    public function addListeTouiteLike (int $idTouite): void {
        if (!in_array($idTouite, $this->liste_touite_liker)) {
            $this->liste_touite_liker[] = $idTouite;
        }
    }






    public function removeListeFollow (int $idUser): void {
        if (in_array($idUser, $this->liste_follow)) {
            unset($liste_follow[array_search($idUser, $this->liste_follow)]);
        }
    }

    public function removeListeTouite (int $idTouite): void {
        if (in_array($idTouite, $this->liste_touite)) {
            unset($liste_touite[array_search($idTouite, $this->liste_touite)]);
        }
    }

    public function removeListeTag (int $idTag): void {
        if (in_array($idTag, $this->liste_tag)) {
            unset($liste_tag[array_search($idTag, $this->liste_tag)]);
        }
    }

    public function removeListeSuivi (int $idUser): void {
        if (in_array($idUser, $this->liste_suivie)) {
            unset($liste_suivie[array_search($idUser, $this->liste_suivie)]);
        }
    }

    public function removeListeTouiteLike (int $idTouite): void {
        if (in_array($idTouite, $this->liste_touite_liker)) {
            unset($liste_touite_liker[array_search($idTouite, $this->liste_touite_liker)]);
        }
    }




    public function isListeFollow (int $idUser): bool {
        return (in_array($idUser, $this->liste_follow));
    }

    public function isListeTouite (int $idTouite): bool {
        return (in_array($idTouite, $this->liste_touite));
    }

    public function isListeTag (int $idTag): bool {
        return (in_array($idTag, $this->liste_tag));
    }

    public function isListeSuivi (int $idUser): bool {
        return (in_array($idUser, $this->liste_suivie));
    }

    public function isListeTouiteLike (int $idTouite): bool {
        return (in_array($idTouite, $this->liste_touite_liker));
    }

}