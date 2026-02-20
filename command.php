<?php
declare(strict_types=1);

require_once 'contactmanager.php';

class Command
{
    private ContactManager $manager;

    public function __construct(ContactManager $manager)
    {
        $this->manager = $manager;
    }

    public function help(): void
    {
        echo "=== Commandes disponibles ===\n";
        echo "list                                          - Afficher tous les contacts\n";
        echo "detail <id>                                   - Afficher un contact par son id\n";
        echo "create <nom>, <email>, <téléphone>            - Créer un nouveau contact\n";
        echo "modify <id>, <nom>, <email>, <téléphone>      - Modifier un contact existant\n";
        echo "delete <id>                                   - Supprimer un contact\n";
        echo "help                                          - Afficher cette aide\n";
        echo "quit                                          - Quitter le programme\n";
    }

    public function list(): void
    {
        $contacts = $this->manager->findAll();

        if (empty($contacts)) {
            echo "Aucun contact trouvé.\n";
        } else {
            foreach ($contacts as $contact) {
                // Grâce à __toString(), echo appelle automatiquement la méthode magique
                echo $contact . "\n";
            }
        }
    }

    public function detail(int $id): void
    {
        $contact = $this->manager->findById($id);

        if ($contact === null) {
            echo "Aucun contact trouvé avec l'id $id.\n";
        } else {
            echo $contact . "\n";
        }
    }

    public function create(string $name, string $email, string $phoneNumber): void
    {
        $contact = new Contact(null, $name, $email, $phoneNumber);
        $this->manager->create($contact);

        echo "Contact créé avec succès !\n";
        echo $contact . "\n";
    }

    /**
     * Modifie un contact : on vérifie d'abord qu'il existe,
     * puis on met à jour ses propriétés via les setters
     * avant de persister les changements en BDD.
     */
    public function modify(int $id, string $name, string $email, string $phoneNumber): void
    {
        $contact = $this->manager->findById($id);

        if ($contact === null) {
            echo "Aucun contact trouvé avec l'id $id.\n";
            return;
        }

        $contact->setName($name);
        $contact->setEmail($email);
        $contact->setPhoneNumber($phoneNumber);

        $this->manager->update($contact);

        echo "Contact modifié avec succès !\n";
        echo $contact . "\n";
    }

    public function delete(int $id): void
    {
        $deleted = $this->manager->delete($id);

        if ($deleted) {
            echo "Contact #$id supprimé avec succès.\n";
        } else {
            echo "Aucun contact trouvé avec l'id $id.\n";
        }
    }
}