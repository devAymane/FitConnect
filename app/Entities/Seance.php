<?php

class Seance
{
    private ?int    $id_seance;
    private string  $date_seance;
    private string  $type_activite;
    private ?string $equipement;
    private string  $duree;          // format HH:MM:SS
    private int     $id_salle;
    private int     $id_adherent;

    public function __construct(
        string  $date_seance,
        string  $type_activite,
        string  $duree,
        int     $id_salle,
        int     $id_adherent,
        ?string $equipement = null,
        ?int    $id_seance  = null
    ) {
        $this->date_seance   = $date_seance;
        $this->type_activite = $type_activite;
        $this->duree         = $duree;
        $this->id_salle      = $id_salle;
        $this->id_adherent   = $id_adherent;
        $this->equipement    = $equipement;
        $this->id_seance     = $id_seance;
    }

    public function getId(): ?int           { return $this->id_seance; }
    public function getDateSeance(): string { return $this->date_seance; }
    public function getTypeActivite(): string { return $this->type_activite; }
    public function getEquipement(): ?string  { return $this->equipement; }
    public function getDuree(): string        { return $this->duree; }
    public function getIdSalle(): int         { return $this->id_salle; }
    public function getIdAdherent(): int      { return $this->id_adherent; }
}
