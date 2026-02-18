<?php

require_once 'dbconnect.php';
require_once 'contact.php';

class ContactManager
{
    private PDO $pdo;

    public function __construct(DBConnect $db)
    {
        $this->pdo = $db->getPDO();
    }

    /**
     * Récupère tous les contacts de la base de données.
     *
     * @return Contact[] Tableau d'objets Contact.
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM contact');
        $rows = $stmt->fetchAll();

        $contacts = [];
        foreach ($rows as $row) {
            $contact = new Contact(
                (int) $row['id'],
                $row['name'],
                $row['email'],
                $row['phone_number']
            );
            $contacts[] = $contact;
        }

        return $contacts;
    }
}