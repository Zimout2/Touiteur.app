<?php

namespace touiteur\entite;

class Liker {
    protected int $id_user;
    protected int $id_tuite;

    public function __construct(int $id_user, int $id_tuite) {
        $this->id_user = $id_user;
        $this->id_tuite = $id_tuite;
    }
    public function getIdUser(): int {
        return $this->id_user;
    }
    public function getIdTuite(): int {
        return $this->id_tuite;
    }
}