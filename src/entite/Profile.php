<?php

namespace touiteur\entite;

use touiteur\repository\TouiteurRepository;

class Profile {
    protected ?int $nb_follower;
    protected ?int $nb_following;
    protected ?int $nb_suivis;
    protected Touite $tuite;

    public function __construct(Touite $tuite, ?int $nb_follower, ?int $nb_following, ?int $nb_suivis){
        $this->tuite = $tuite;
        $this->nb_follower = $nb_follower;
        $this->nb_following = $nb_following;
        $this->nb_suivis = $nb_suivis;
    }

    /**
     * Cette méthode permet de retourner le nombre de followers de l'utilisateur
     * @return int|null le nombre de follower peut-être null (personne ne suit cette utilisateur)
     */
    public function getNbFollower(): ?int {
        return $this->nb_follower;
    }

    /**
     * Cette méthode permet de retourner le nombre de personne que suit l'utilisateur
     * @return int|null le nombre de personne peut-être null (l'utilisateur ne suit personne)
     */
    public function getNbFollowing(): ?int {
        return $this->nb_following;
    }
    public function getNbSuivis(): ?int {
        return $this->nb_suivis;
    }

    /**
     * Cette méthode permet de renvoie tout le touites d'un utilisateurs
     * @return Touite qui est l'objet touites
     */
    public function getTuite(): Touite {
        return $this->tuite;
    }

    /**
     * Cette méthode permet de renvoyer le message contenue dans le touites
     * @return string qui coorespond au type du message du touites
     */
    public function afficherMessage_touite() : string {
        return $this->getTuite()->getMessage();
    }

    /**
     * Cette méthode permet de renvoyer le ou les tags contenue dans le touites
     * @return string qui coorespond au type du tag du touites
     */
    public function afficherTag_touite() : string {
        return "".$this->getTuite()->getTags();
    }

    /**
     * Cette méthode permet de renvoyer le nombre de touites de l'utilisateur
     * @return string qui est le message renvoyer
     */
    public function getNombre_tuites(): string {
        $cpt_tuite = count($this->getTuite());
        return "<p>Votre nombre de tuite est actuellement de : ".$cpt_tuite."</p>";
    }

    /**
     * Cette méthode permet de renvoyer le nombre de personnes qui suit l'utilisateur
     * @return string qui est le message renvoyer
     */
    public function getNombre_suivis(): string {
        return "<p>Vous avec actuellement : ".$this->nb_suivis." personnes qui vous suivent</p>";
    }
}