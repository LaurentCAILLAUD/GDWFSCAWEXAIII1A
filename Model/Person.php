<?php

class Person
{
    private string $id;
    private string $firstname;
    private string $lastname;
    private DateTime $dateOfBirth;
    private string $identityCode;
    private string $nationalityCodeId;
    private string $missionId;

    // Fonction qui va me permettre de construire une instance de ma classe Person:
    public function __construct(string $id, string $firstname, string $lastname, DateTime $dateOfBirth, string $identityCode, string $nationalityCodeId, string $missionId)
    {
        $this->setId($id);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setDateOfBirth($dateOfBirth);
        $this->setIdentityCode($identityCode);
        $this->setNationalityCodeId($nationalityCodeId);
        $this->setMissionId($missionId);
    }

    // Etant donné que j'ai choisi de mettre en privé les propriétés de ma classe, je dois faire les getters et les setters afin d'accéder et d'enregistrer les données:
    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getDateOfBirth(): DateTime
    {
        return $this->dateOfBirth;
    }

    public function getIdentityCode(): string
    {
        return $this->identityCode;
    }

    public function getNationalityCodeId(): string
    {
        return $this->nationalityCodeId;
    }

    public function getMissionId(): string
    {
        return $this->missionId;
    }

    public function setId(string $id): string
    {
        return $this->id = ($id);
    }

    public function setFirstname(string $firstname): string
    {
        return $this->firstname = ($firstname);
    }

    public function setLastname(string $lastname): string
    {
        return $this->lastname = ($lastname);
    }

    public function setDateOfBirth(DateTime $dateOfBirth): DateTime
    {
        return $this->dateOfBirth = ($dateOfBirth);
    }

    public function setIdentityCode(string $identityCode): string
    {
        return $this->identityCode = ($identityCode);
    }

    public function setNationalityCodeId(string $nationalityCodeId): string
    {
        return $this->nationalityCodeId = ($nationalityCodeId);
    }

    public function setMissionId(string $missionId): string
    {
        return $this->missionId = ($missionId);
    }
}