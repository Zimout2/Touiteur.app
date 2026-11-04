<?php

namespace touiteur\action;

use touiteur\entite\User;

class DisplayUser extends Action{

    public function execute(): string{
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Touiteur - User 1</title>
        </head>
        <body>
        <div class="main-container">
                <div class="user-profile">
                    <div class="user-infos">
                        <span class="user-name">User 1</span>
                        <span class="user-nb-followers">Nb followers</span>
                        <span class="user-nb-suivis">Nb suivis</span>
                        <span class="user-nb-touites">Nb touites</span>
                    </div>
                </div>


                <div class="touites-user">


                </div>
            </main>
        </div>
        </body>
        </html>
        HTML;
    }
}