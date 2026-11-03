<?php

namespace touiteur\entite;

class SuivieUser {
    protected int $id_user;
    protected int $id_suivie;

    public function __construct(int $id_user, int $id_suivie) {
        $this->id_user = $id_user;
        $this->id_suivie = $id_suivie;
    }
    public function getIdUser(): int {
        return $this->id_user;
    }
    public function getIdSuivie(): int {
        return $this->id_suivie;
    }
}