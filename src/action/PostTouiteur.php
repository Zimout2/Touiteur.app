<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;

class PostTouiteur extends Action {

    public function execute(): string {

        if (!isset($_SESSION['user'])) {
            return "<p>Vous devez être connecté pour publier un touite.</p>";
        }

        if($this ->http_method === 'GET'){
            return <<<HTML
                <h2> Poster le touite </h2>
                <form method = "post" action ="?action=publication">
                    <label>Le texte est limiter à 235 caractères max </label>
                    <textarea id="texte" name="texte" rows="4" cols="50" maxlength="235" required></textarea>
                    <button type="submit">Publier</button>
                </form>
                HTML;
        }
        $texteNonFiltre = $_POST['texte'] ?? '';
        if ($texteNonFiltre === '' || strlen($texteNonFiltre) > 235) {
            return "<p>Erreur : Le texte du touite est vide ou dépasse 235 caractères.</p>";
        }
        $texte = filter_var($texteNonFiltre,FILTER_SANITIZE_SPECIAL_CHARS);

        //pour recup le tag
        $mots = explode(' ', $texteNonFiltre);
        $tags = [];
        foreach ($mots as $mot) {
        if ($mot !== '' && $mot[0] === '#') {
            $tag = substr($mot, 1);              
            if ($tag !== '') {
            $tags[$tag] = $tag;   
            }
        }
    }

        //enregistre dans la base de donée le tag
        $repo = TouiteurRepository::getInstance();
        $idUser = $_SESSION['user']['idUser'];
        $idTouit = $repo->addTouit($texte, $idUser);
        foreach($tags as $tagNom){
            $repo->addTagToTouit($idTouit,$tagNom);
        }

        return "<p>Votre touite a été publié avec succès ! <a href=\"?action=accueil\">Retour à l'accueil</a></p>";
    }




}