<?php



namespace touiteur\render;

use touiteur\entite\User;


class UserRenderer implements Renderer {











    private string $prenom;
    private ?int $nb_touite = 0;
    private ?int $nb_suivis = 0;
    private ?int $nb_follow = 0;












    public function __construct(User $user) {
        $this->prenom = $user->getPrenom();
        $this->nb_touite = $user->getNbTouite();
        $this->nb_suivis = count($user->getListeSuivie());
        $this->nb_follow = count($user->getListeFollow());
    }





















    public function render(): string {
        $html = "<h2>" . $this->name . "</h2>";
        $html .= "<p><span>Nombre de followers : " . $this->nb_follow . "</span><span>Nombre de suivis : " . $this->nb_suivis . "</span></p>";
        $html .= "<p>Nombre de touites : " . $this->nb_touite . "</p>";
        $html .= "<h3>Touites</h3>";
        return $html;
    }




}