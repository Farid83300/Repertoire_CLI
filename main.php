<?php

declare(strict_types=1);

require_once 'dbconnect.php';
require_once 'contact.php';
require_once 'contactmanager.php';


$db      = new DBConnect();
$manager = new ContactManager($db);

while (true) {
    $line = readline("Entrez votre commande : ");

    if ($line === "list") {
        $contacts = $manager->findAll();

        // --- Vérification : s'assurer que le tableau n'est pas vide ---
        if (empty($contacts)) {
            echo "Aucun contact trouvé.\n";
        } else {
            foreach ($contacts as $contact) {
                echo $contact->toString() . "\n";
            }
        }

    } elseif ($line === "quit") {
        echo "Au revoir !\n";
        break;
    } else {
        echo "Commande inconnue : $line\n";
    }
}