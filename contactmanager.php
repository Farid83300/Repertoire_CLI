<?php
declare(strict_types=1);

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
     * Récupère tous les contacts.
     *
     * @return Contact[]
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

    // Récupère un contact par son id
    public function findById(int $id): ?Contact
    {
        $stmt = $this->pdo->prepare('SELECT * FROM contact WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        return new Contact(
            (int) $row['id'],
            $row['name'],
            $row['email'],
            $row['phone_number']
        );
    }

    // Crée un nouveau contact en base
    public function create(Contact $contact): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)'
        );
        $stmt->execute([
            'name'         => $contact->getName(),
            'email'        => $contact->getEmail(),
            'phone_number' => $contact->getPhoneNumber(),
        ]);

        $contact->setId((int) $this->pdo->lastInsertId());
    }

    // Supprime un contact par son id
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM contact WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}