<?php
declare(strict_types=1);

class Contact
{
    private ?int $id;
    private ?string $name;
    private ?string $email;
    private ?string $phoneNumber;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $phoneNumber = null
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->email       = $email;
        $this->phoneNumber = $phoneNumber;
    }

    // --- Getters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    // --- Setters ---

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Méthode magique __toString :
     * Appelée automatiquement par PHP quand l'objet est utilisé
     * dans un contexte de chaîne (ex: echo $contact).
     * Remplace l'ancienne méthode toString() qu'il fallait appeler manuellement.
     */
    public function __toString(): string
    {
        return sprintf(
            "[id: %d] [name: %s] [email: %s] [phone_number: %s]",
            $this->id          ?? 0,
            $this->name        ?? 'N/A',
            $this->email       ?? 'N/A',
            $this->phoneNumber ?? 'N/A'
        );
    }
}