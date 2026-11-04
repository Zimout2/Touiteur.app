<?php



namespace touiteur\render;

use touiteur\entite\Tag;


class TagRenderer implements Renderer {











    private string $libelle;
    private ?string $description = null;
    private ?int $nb_suivis = 0;
    private ?int $nb_touite = 0;












    public function __construct(Tag $tag) {
        $this->libelle = $tag->getLibelle();
        $this->nb_touite = count($tag->getListe_Touites());
        $this->nb_suivis = count($tag->getListeSuivie());
    }





















    public function render(): string {
        $html = "<h2>" . $this->libelle . "</h2>";
        if ($this->description != null) {
            $html .= "<p>" . $this->description . "</p>";
        }
        $html .= "<p>Nombre de suivis : " . $this->nb_suivis . "</p>";
        $html .= "<p>Nombre de touites : " . $this->nb_touite . "</p>";
        $html .= "<h3>Touites</h3>";
        return $html;
    }




}