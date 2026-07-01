<?php

class Abonnement
{
    private ?int   $id_abonnement;
    private string $type_abonnement;   // Mensuel | Trimestriel | Annuel
    private string $date_debut;
    private string $date_fin;
    private string $statut;
    private int    $id_adherent;

    public function __construct(
        string $type_abonnement,
        string $date_debut,
        string $date_fin,
        string $statut,
        int    $id_adherent,
        ?int   $id_abonnement = null
    ) {
        $this->type_abonnement = $type_abonnement;
        $this->date_debut      = $date_debut;
        $this->date_fin        = $date_fin;
        $this->statut          = $statut;
        $this->id_adherent     = $id_adherent;
        $this->id_abonnement   = $id_abonnement;
    }

    public function getId(): ?int          { return $this->id_abonnement; }
    public function getType(): string      { return $this->type_abonnement; }
    public function getDateDebut(): string { return $this->date_debut; }
    public function getDateFin(): string   { return $this->date_fin; }
    public function getStatut(): string    { return $this->statut; }
    public function getIdAdherent(): int   { return $this->id_adherent; }

    public function setStatut(string $s): void { $this->statut = $s; }

    /** Règle métier : l'abonnement est valide si aujourd'hui est entre date_debut et date_fin */
    public function estValide(): bool
    {
        $today = date('Y-m-d');
        return $today >= $this->date_debut && $today <= $this->date_fin;
    }
}
