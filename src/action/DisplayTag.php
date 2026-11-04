<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class DisplayTag extends Action {

    public function execute(): string
    {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            return "<p>Erreur : Identifiant de tag invalide ou manquant.</p>";
        }

        $repo = TouiteurRepository::getInstance();
        $tag = $repo->getTagById($id);

        if (!$tag) {
            return "<p>Erreur : Tag introuvable.</p>";
        }

        // On extrait la valeur proprement dans une variable avant de l'afficher
        $libelleTag = filter_var($tag['libellle'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        return <<<HTML
        <style>
            /* Conteneur de la liste */
            .tag-list {
                width: 50%;
                margin: 20px auto;
            }
            .tag-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #ddd;
            }
        </style>

        <div class="tag-list">
            <h2>Détails du Tag</h2>
            <div class="tag-item">
                <span>Message :</span>
                <span class="tag-name">#{$libelleTag}</span>
            </div>                    
        </div>
        <br>
        <a href="?action=tag">← Retour</a>
        HTML;
    }
}