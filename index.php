<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use touiteur\action\DisplayTag;
use touiteur\dispatch\Routeur;
use touiteur\action\DefaultAction;
use touiteur\action\PostTouiteur;
use touiteur\action\UserTouiteur;
use touiteur\repository\TouiteurRepository;
use touiteur\action\InscriptionTouiteur;

TouiteurRepository::setConfig(__DIR__ . '/src/config/sae.db.ini');

$app = new Routeur();

$app->addRoute('accueil', DefaultAction::class);
$app->addRoute('publication', PostTouiteur::class);
$app->addRoute('utilisateur', UserTouiteur::class);
$app->addRoute('displayTag', DisplayTag::class);
$app->addRoute('inscription', InscriptionTouiteur::class);

echo $app->run();