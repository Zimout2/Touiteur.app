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
use touiteur\action\ConnexionTouiteur;
use touiteur\action\DeconnexionTouiteur;
use touiteur\action\DisplayTouit;
use touiteur\action\DisplayUtilisateur;

TouiteurRepository::setConfig(__DIR__ . '/src/config/sae.db.ini');

$app = new Routeur();

$app->addRoute('accueil', DefaultAction::class);
$app->addRoute('publication', PostTouiteur::class);
$app->addRoute('displayTag', DisplayTag::class);
$app->addRoute('inscription', InscriptionTouiteur::class);
$app->addRoute('default', DefaultAction::class);
$app->addRoute('connexion', ConnexionTouiteur::class);
$app->addRoute('deconnexion', DeconnexionTouiteur::class);
$app->addRoute('display-touite', DisplayTouit::class);
$app->addRoute('utilisateur', DisplayUtilisateur::class);
echo $app->run();