<?php

    namespace touiteur\action ;

    use touiteur\repository\TouiteurRepository;
    use touiteur\entite\Tag;
    use touiteur\render\TagRenderer;
    use touiteur\entite\User;
    use touiteur\entite\Touite;
    use touiteur\render\TouiteurRenderer;

    class TagTouiteur extends Action {

        public function execute(): string {
            $idTag = $_GET['id'] ?? $_SESSION['tag']['idTag'] ?? null;

            if (!$idTag) {
                return "<div class='profil-container'><p>Aucun tag n'est associé à ce tag.</p></div>";
            }

            $repo = TouiteurRepository::getInstance();


            $tag = $repo->getTagById($idTag);
            $touites = $repo->getTouitesByTag($idTag);

            if (empty($tag)) {
                return "<div class='profil-container'><p>Tag introuvable.</p></div>";
            }

            $t = new Tag($tag['libelle'], $tag['idTag']);
            $touites_array = [];
            foreach ($touites as $to) {
                $user = new User(
                    $to['auteur'] ?? 'Inconnu',
                    $to['idUser'] ?? 0,
                );
                $new_touite = new Touite(
                    $to['message'] ?? '',
                    $user, // <-- On passe l'objet User ici
                    $to['dateTouite'] ?? '',
                    (int)($to['likeTouite'] ?? 0)
                );

                $touiteRenderer = new TouiteurRenderer($new_touite);
                $touites_array[] = $touiteRenderer->render();
            }

            $renderer = new TagRenderer($t, $touites_array);
            $html = $renderer->render();

            return <<<HTML
            <style>
                .profil-container {
                    max-width: 600px;
                    margin: 0 auto;
                    text-align: center;
                    font-family: Arial, sans-serif;
                }
                .touites-list {
                    margin-top: 20px;
                }
            </style>

            <div class='profil-container'>
                {$html}
            </div>
            HTML;
        }
    }