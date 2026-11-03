<?php

namespace touiteur\entite;

class Follow {
    protected int $id_user;

    public function __construct(int $id_user) {
        $this->id_user = $id_user;
    }
    public function getIdUser(): int {
        return $this->id_user;
    }
}