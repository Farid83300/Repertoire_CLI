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
    } elseif ($line === "quit") {
        echo "Au revoir !\n";
        break;
    } else {
        echo "Commande inconnue : $line\n";
    }
}