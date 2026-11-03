<?php
declare(strict_types=1);
session_start();


use src\dispatch\Routeur;

use touiter\action\DefaultAction;
use touiter\action\DisplayTouit;
use touiter\action\RateTouiteur;
use touiteur\action\PostTouiteur;
use touiteur\action\TagTouiteur;
use touiteur\action\UserTouiteur;

$app = new Routeur();

$app->addRoute('Acceuil', DefaultAction::class);
$app->addRoute('Poste_tuite', PostTouiteur::class);
$app->addRoute('tag_tuite', TagTouiteur::class);
$app->addRoute('Utilisateur', UserTouiteur::class);

$app->run();