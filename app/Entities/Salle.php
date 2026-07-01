<?php

class Salle
{
    private ?int   $id_salle;
    private string $nom_salle;
    private string $adresse;
    private string $telephone;

    public function __construct(
        string $nom_salle,
        string $adresse,
        string $telephone,
        ?int   $id_salle = null
    ) {
        $this->nom_salle  = $nom_salle;
        $this->adresse    = $adresse;
        $this->telephone  = $telephone;
        $this->id_salle   = $id_salle;
    }

    public function getId(): ?int        { return $this->id_salle; }
    public function getNomSalle(): string { return $this->nom_salle; }
    public function getAdresse(): string  { return $this->adresse; }
    public function getTelephone(): string { return $this->telephone; }
}
