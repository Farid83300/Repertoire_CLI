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

    // Affiche tous les contacts
    public function list(): void
    {
        $contacts = $this->manager->findAll();

        if (empty($contacts)) {
            echo "Aucun contact trouvé.\n";
        } else {
            foreach ($contacts as $contact) {
                echo $contact->toString() . "\n";
            }
        }
    }

    // Affiche un contact par son id
    public function detail(int $id): void
    {
        $contact = $this->manager->findById($id);

        if ($contact === null) {
            echo "Aucun contact trouvé avec l'id $id.\n";
        } else {
            echo $contact->toString() . "\n";
        }
    }

    // Crée un nouveau contact
    public function create(string $name, string $email, string $phoneNumber): void
    {
        $contact = new Contact(null, $name, $email, $phoneNumber);
        $this->manager->create($contact);

        echo "Contact créé avec succès !\n";
        echo $contact->toString() . "\n";
    }

    // Supprime un contact par son id
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