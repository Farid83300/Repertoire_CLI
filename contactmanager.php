<?php
declare(strict_types=1);

require_once 'dbconnect.php';
require_once 'contact.php';

class ContactManager
{
    private PDO $pdo;

    /**
     * Injection de dépendance : on reçoit DBConnect plutôt que
     * de créer la connexion ici, ce qui facilite les tests et
     * le découplage entre les classes.
     */
    public function __construct(DBConnect $db)
    {
        $this->pdo = $db->getPDO();
    }

    /**
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

    /**
     * Retourne un seul Contact ou null si l'id n'existe pas.
     * Utilise une requête préparée pour se protéger des injections SQL.
     */
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

        // Récupère l'id auto-incrémenté généré par MySQL et l'assigne à l'objet
        $contact->setId((int) $this->pdo->lastInsertId());
    }

    public function update(Contact $contact): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id'
        );
        $stmt->execute([
            'id'           => $contact->getId(),
            'name'         => $contact->getName(),
            'email'        => $contact->getEmail(),
            'phone_number' => $contact->getPhoneNumber(),
        ]);

        // rowCount() retourne le nombre de lignes affectées (0 si aucune modification)
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM contact WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}