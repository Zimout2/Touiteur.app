<?php

namespace touiteur\action ;

//use...


class TagTouiteur extends Action {

    public function execute(): string {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <style>
                /* Conteneur de la liste */
                .user-list {
                    width: 50%;
                    margin: 20px auto;
                }
        
                /* Chaque ligne d'utilisateur : met le texte à gauche et le bouton à droite sur la même ligne */
                .user-item {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px 0;
                    border-bottom: 1px solid #ddd;
                }
        
                .user-name {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
        
        <div class="main-container">
        
                <div class="user-list">
                    <div class="user-item">
                        <span class="user-name">Tag 1</span>
                    </div>
                    
                    <div class="user-item">
                        <span class="user-name">Tag 2</span>
                    </div>
                    
                    <div class="user-item">
                        <span class="user-name">Tag 3</span>
                    </div>
                    
                </div>

            </main>
        </div>
        
        </body>
        </html>
        HTML;
    }




}