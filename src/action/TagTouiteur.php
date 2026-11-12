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
            if (!isset($_SESSION['user']['idUser'])) {
                return "<p>Vous devez être connecté pour pouvoir voir les listes des touites associé à ce tag</p>";
            }

            $idTag = $_GET['id'] ?? $_SESSION['tag']['idTag'] ?? null;
            $idUser = $_SESSION['user']['idUser'];
            if (!$idTag) {
                return "<div class='profil-container'><p>Aucun tag n'est associé à ce tag.</p></div>";
            }

            $repo = TouiteurRepository::getInstance();


            $tag = $repo->getTagById($idTag);
            $touites = $repo->getTouitesByTag($idTag);

            if (empty($tag)) {
                return "<div class='profil-container'><p>Tag introuvable.</p></div>";
            }

            $estAbonne = $repo->isFollowingTag($idUser, $idTag);

            $html = "<div class='followtag-action' style='margin: 15px 0;'>";
            if ($estAbonne) {
                $html .= "
                    <form method='POST' action='index.php?action=unfollowtag'>
                        <input type='hidden' name='idTagToUnfollow' value='{$idTag}'>
                        <button type='submit' class='btn-unfollow'>Se désabonner</button>
                    </form>";
            } else {
                $html .= "
                    <form method='POST' action='index.php?action=followtag'>
                        <input type='hidden' name='idTagToFollow' value='{$idTag}'>
                        <button type='submit' class='btn-follow'>S'abonner</button>
                    </form>";
            }
            $html .= "</div>";

            $t = new Tag($tag['libelle'], $tag['idTag']);
            $touites_array = [];
            foreach ($touites as $to) {
                $user = new User(
                    $to['auteur'] ?? 'Inconnu',
                    '',
                    $to['idUser'] ?? 0,
                );
                $new_touite = new Touite(
                    $to['message'] ?? '',
                    $user,
                    $to['dateTouite'] ?? '',
                    (int)($to['likeTouite'] ?? 0),
                );

                $idTouite = $to['idTouite'] ?? 0;
                $tags = ($idTouite > 0) ? $repo->getTagsByTouite($idTouite) : [];

                $touiteRenderer = new TouiteurRenderer($new_touite, $tags);
                $touites_array[] = $touiteRenderer->render();
            }

            $renderer = new TagRenderer($t, $touites_array);
            $html .= $renderer->render();

            return <<<HTML
            <style>
                .profil-container {
                    max-width: 600px;
                    margin: 0 auto;
                    text-align: center;
                    font-family: Arial, sans-serif;
                }
            </style>

            <div class='profil-container'>
                {$html}
            </div>
            HTML;
        }
    }