<?php

class Adherent
{
    private ?int    $id_adherent;
    private string  $nom;
    private string  $prenom;
    private string  $email;
    private string  $telephone;
    private string  $date_inscription;
    private int     $id_salle;

    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        string $telephone,
        string $date_inscription,
        int    $id_salle,
        ?int   $id_adherent = null
    ) {
        $this->nom              = $nom;
        $this->prenom           = $prenom;
        $this->email            = $email;
        $this->telephone        = $telephone;
        $this->date_inscription = $date_inscription;
        $this->id_salle         = $id_salle;
        $this->id_adherent      = $id_adherent;
    }

    public function getId(): ?int    { return $this->id_adherent; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string  { return $this->email; }
    public function getTelephone(): string { return $this->telephone; }
    public function getDateInscription(): string { return $this->date_inscription; }
    public function getIdSalle(): int { return $this->id_salle; }

    public function setNom(string $nom): void           { $this->nom = $nom; }
    public function setPrenom(string $prenom): void     { $this->prenom = $prenom; }
    public function setEmail(string $email): void       { $this->email = $email; }
    public function setTelephone(string $t): void       { $this->telephone = $t; }
    public function setIdSalle(int $id): void           { $this->id_salle = $id; }
}
