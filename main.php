<?php
declare(strict_types=1);

require_once 'dbconnect.php';
require_once 'contactmanager.php';
require_once 'command.php';

$db      = new DBConnect();
$manager = new ContactManager($db);
$command = new Command($manager);

while (true) {
    $line = readline("Entrez votre commande : ");

    if ($line === "list") {
        $command->list();
        // Capture l'id après detail
    } elseif (preg_match('/^detail\s+(\d+)$/', $line, $matches)) {
        $command->detail((int) $matches[1]);
        // isole les trois champs séparés par des virgules
    } elseif (preg_match('/^create\s+(.+),\s*(.+),\s*(.+)$/', $line, $matches)) {
        $command->create(
            trim($matches[1]),
            trim($matches[2]),
            trim($matches[3])
        );

    } elseif (preg_match('/^delete\s+(\d+)$/', $line, $matches)) {
        $command->delete((int) $matches[1]);

    } elseif ($line === "quit") {
        echo "Au revoir !\n";
        break;

    } else {
        echo "Commande inconnue : $line\n";
    }
}

    /**
        * Commandes disponibles :
        * - list : affiche tous les contacts
        * - detail <id> : affiche un contact par son id
        * - create <nom>, <email>, <téléphone> : crée un nouveau contact
        * - delete <id> : supprime un contact par son id
        * - quit : quitte le programme
    **/