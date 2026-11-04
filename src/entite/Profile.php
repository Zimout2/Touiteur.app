<?php

namespace touiteur\entite;

use touiteur\repository\TouiteurRepository;

class Profile {
    protected int $nb_follower;
    protected int $nb_following;
    protected int $nb_suivis;
    protected Touite $tuite;

    public function __construct(Touite $tuite, int $nb_follower, int $nb_following, int $nb_suivis){
        $this->tuite = $tuite;
        $this->nb_follower = $nb_follower;
        $this->nb_following = $nb_following;
        $this->nb_suivis = $nb_suivis;
    }
    public function getNbFollower(): int {
        return $this->nb_follower;
    }
    public function getNbFollowing(): int {
        return $this->nb_following;
    }
    public function getNbSuivis(): int {
        return $this->nb_suivis;
    }
    public function getTuite(): Touite {
        return $this->tuite;
    }

    public function afficherMessage_touite() : string {
        return $this->getTuite()->getMessage();
    }

    public function afficherTag_touite() : string {
        return "".$this->getTuite()->getTags();
    }

    public function getNombre_tuites(): int {
        $cpt_tuite = count($this->getTuite());
        return "<p>Votre nombre de tuite est actuellement de : ".$cpt_tuite."</p>";
    }

    public function getNombre_suivis(): int {
        return "<p>Vous avec actuellement : ".$this->nb_suivis." personnes qui vous suivent</p>";
    }
}