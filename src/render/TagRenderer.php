<?php



namespace touiteur\render;

use touiteur\entite\Tag;


class TagRenderer implements Renderer {











    private string $libelle;
    private ?string $description = null;
    private ?int $nb_suivis = 0;
    private ?int $nb_touite = 0;
    private array $touites = [];












    public function __construct(Tag $tag, array $touites = []) {
        $this->libelle = $tag->getLibelle();
        $this->nb_touite = count($touites);
        $this->nb_suivis = count($tag->getListeSuivie());
        $this->touites = $touites;
    }







    public function setNbSuivis(int $nb) {
        $this->nb_suivis = $nb;
    }













    public function render(): string {
        $libelleTag = filter_var($this->libelle, FILTER_SANITIZE_SPECIAL_CHARS);

        $html = "";
        $html .= "<h2>#$libelleTag</h2>";
        $html .= "<p>Nombre de suivis : " . $this->nb_suivis . "</p>";
        $html .= "<p>Nombre de touites : " . $this->nb_touite . "</p>";
        $html .= "<h3>Touites :</h3>";

        if (empty($this->touites)) {
            $html .= "<p>Aucun touite pour le moment n'est associé à ce tag.</p>";
        } else {
            $html .= "<div class='touites-list'>";
            foreach ($this->touites as $touite) {
                $html .= "<div class='touite-item'>" . $touite->render() . "</div>";;
            }
            $html .= "</div>";
        }
        $html .= "</div>";

        return $html;
    }




}