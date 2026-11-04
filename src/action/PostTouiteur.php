<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;

class PostTouiteur extends Action {

    public function execute(): string {
        if($this ->http_method === 'GET'){
            return <<<HTML
                <h2> Poster le touite </h2>
                <form method = "post" action ="?action=post-touit" enctype="multipart/form-data">
                    <label>vous pouvez ecrire un totale de 235 caractères max </label>
                    <textarea id="texte" name="texte" rows="4" cols="50" maxlength="235" required></textarea>
                    <button type="submit">Publier</button>
                </form>
                HTML;
        }
        $texteNomFiltre = $_POST['Texte'] ?? '';
        if ($texteNomFiltre === '' || strlen($texteNomFiltre) > 235) {
            return "<p>Erreur : Le texte du touite est vide ou dépasse 235 caractères.</p>";
        }
        $texte = filter_var($texteNomFiltre,FILTER_SANITIZE_SPECIAL_CHARS);

        //pour recup le tag
        preg_match_all('/#(\w+)/u',$texte ,$matches);
        $tags = array_unique($matches[1]);

        //enregistre dans la base de donée le tag
        $repo = TouiteurRepository::getInstance();
        $idUser = $_SESSION['user']['id'];
        $idTouit = $repo->addTouit($texte, $idUser);
        foreach($tags as $tagNom){
            $repo->addTagToTouit($idTouit,$tagNom);
        }

        return "<p>Votre touite a été publié avec succès ! <a href=\"?action=default\">Retour à l'accueil</a></p>";
    }




}