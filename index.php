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

$app->addRoute('default', DefaultAction::class);
$app->addRoute('Poste_tuite', PostTouiteur::class);
$app->addRoute('tag_tuite', TagTouiteur::class);
$app->addRoute('Utilisateur', UserTouiteur::class);

echo $app->run();