<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use touiteur\dispatch\Routeur;
use touiteur\action\DefaultAction;
use touiteur\action\DisplayTouit;
use touiteur\action\PostTouiteur;
use touiteur\action\TagTouiteur;
use touiteur\action\UserTouiteur;

$app = new Routeur();

$app->addRoute('accueil', DefaultAction::class);
$app->addRoute('publication', PostTouiteur::class);
$app->addRoute('tag', TagTouiteur::class);
$app->addRoute('utilisateur', UserTouiteur::class);

echo $app->run();