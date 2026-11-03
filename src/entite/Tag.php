<?php

namespace touiteur\entite;

class Tag {
    protected int $id;
    protected string $libelle;
    protected string $description;
    protected int $id_user;
    protected int $id_tuites;

    public function __construct(int $id, string $libelle, string $description, int $id_user, int $id_tuites) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->id_user = $id_user;
        $this->id_tuites = $id_tuites;
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
    public function getIdUser(): int {
        return $this->id_user;
    }
    public function getIdTuites(): int {
        return $this->id_tuites;
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