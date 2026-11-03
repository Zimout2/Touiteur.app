<?php

namespace touiteur\entite;

class SuivieTag {
    protected int $id_user;
    protected int $id_tab;

    public function __construct(int $id_user, int $id_tab) {
        $this->id_user = $id_user;
        $this->id_tab = $id_tab;
    }
    public function getIdUser(): int {
        return $this->id_user;
    }
    public function getIdTab(): int {
        return $this->id_tab;
    }
}