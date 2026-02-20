<?php
declare(strict_types=1);

require_once 'dbconnect.php';
require_once 'contactmanager.php';
require_once 'command.php';

$db      = new DBConnect();
$manager = new ContactManager($db);
$command = new Command($manager);

echo "Bienvenue dans le gestionnaire de contacts ! Tapez 'help' pour voir les commandes.\n";

while (true) {
    $line = readline("Entrez votre commande : ");

    if ($line === "list") {
        $command->list();

    } elseif ($line === "help") {
        $command->help();

    // preg_match teste si la saisie correspond au pattern regex.
    // Les parenthèses () capturent les valeurs dans le tableau $matches.
    // \d+ = un ou plusieurs chiffres, .+ = un ou plusieurs caractères quelconques.
    } elseif (preg_match('/^detail\s+(\d+)$/', $line, $matches)) {
        $command->detail((int) $matches[1]);

    // Regex : capture 3 groupes séparés par des virgules (nom, email, téléphone)
    } elseif (preg_match('/^create\s+(.+),\s*(.+),\s*(.+)$/', $line, $matches)) {
        $command->create(
            trim($matches[1]),
            trim($matches[2]),
            trim($matches[3])
        );

    // Regex : capture l'id (chiffres) + 3 groupes séparés par des virgules
    } elseif (preg_match('/^modify\s+(\d+),\s*(.+),\s*(.+),\s*(.+)$/', $line, $matches)) {
        $command->modify(
            (int) $matches[1],
            trim($matches[2]),
            trim($matches[3]),
            trim($matches[4])
        );

    } elseif (preg_match('/^delete\s+(\d+)$/', $line, $matches)) {
        $command->delete((int) $matches[1]);

    } elseif ($line === "quit") {
        echo "Au revoir !\n";
        break;

    } else {
        echo "Commande inconnue. Tapez 'help' pour voir les commandes disponibles.\n";
    }
}

    /**
        * Commandes disponibles :
        * - help : affiche l'aide avec la liste des commandes
        * - list : affiche tous les contacts
        * - detail <id> : affiche un contact par son id
        * - create <nom>, <email>, <téléphone> : crée un nouveau contact
        * - delete <id> : supprime un contact par son id
        * - quit : quitte le programme
    **/