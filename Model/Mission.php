<?php

class Mission
{
    private string $id;
    private string $title;
    private string $description;
    private string $codeName;
    private string $country;
    private DateTime $missionStart;
    private Datetime $missionEnd;
    private string $specialityId;
    private string $missionTypeId;
    private string $missionStatusId;

    // Fonction qui va me permettre de construire une instance de ma classe Mission:
    public function __construct(string $id, string $title, string $description, string $codeName, string $country, DateTime $missionStart, DateTime $missionEnd, string $specialityId, string $missionTypeId, string $missionStatusId)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setCodeName($codeName);
        $this->setcountry($country);
        $this->setMissionStart($missionStart);
        $this->setMissionEnd($missionEnd);
        $this->setspecialityId($specialityId);
        $this->setMissionTypeId($missionTypeId);
        $this->setMissionStatusId($missionStatusId);
    }

    // Etant donné que j'ai choisi de mettre en privé les propriétés de ma classe, je dois faire les getters et les setters afin d'accéder et d'enregistrer les données:
    public function getId(): string
    {
        return $this->id;
    }

    public function getTite(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCodeName(): string
    {
        return $this->codeName;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getMissionStart(): Datetime
    {
        return $this->missionStart;
    }

    public function getMissionEnd(): DateTime
    {
        return $this->missionEnd;
    }

    public function getSpecialityId(): string
    {
        return $this->specialityId;
    }

    public function getMissionTypeId(): string
    {
        return $this->missionTypeId;
    }

    public function getMissionStatusId(): string
    {
        return $this->missionStatusId;
    }

    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    public function setTitle(string $title): string
    {
        return $this->title = $title;
    }

    public function setDescription(string $description): string
    {
        return $this->description = $description;
    }

    public function setCodeName(string $codeName): string
    {
        return $this->codeName = $codeName;
    }

    public function setCountry(string $country): string
    {
        return $this->country = $country;
    }

    public function setMissionStart(DateTime $missionStart): Datetime
    {
        return $this->missionStart = $missionStart;
    }

    public function setMissionEnd(DateTime $missionEnd): Datetime
    {
        return $this->missionEnd = $missionEnd;
    }

    public function setSpecialityId(string $specialityId): string
    {
        return $this->specialityId = $specialityId;
    }

    public function setMissionTypeId(string $missionTypeId): string
    {
        return $this->missionTypeId = $missionTypeId;
    }

    public function setMissionStatusId(string $missionStatusid): string
    {
        return $this->missionStatusId = $missionStatusid;
    }
}
