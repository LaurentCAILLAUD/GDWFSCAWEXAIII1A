<?php

class Stash
{
    private int $code;
    private string $address;
    private string $type;
    private string $missionId;
    private string $nationalityCountryId;

    // Fonction qui va me permettre de construire une instance de ma classe Stash:
    public function __construct(int $code, string $address, string $type, string $missionId, string $nationalityCountryId)
    {
        $this->setCode($code);
        $this->setAddress($address);
        $this->setType($type);
        $this->setMissionId($missionId);
        $this->setNationalityCountryId($nationalityCountryId);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMissionId(): string
    {
        return $this->missionId;
    }

    public function getNationalityCountryId(): string
    {
        return $this->nationalityCountryId;
    }

    public function setCode(int $code): int
    {
        return $this->code = $code;
    }

    public function setAddress(string $address): string
    {
        return $this->address = $address;
    }

    public function setType(string $type): string
    {
        return $this->type = $type;
    }

    public function setMissionId(string $missionId): string
    {
        return $this->missionId = $missionId;
    }

    public function setNationalityCountryId(string $nationalityCountryId): string
    {
        return $this->nationalityCountryId = $nationalityCountryId;
    }
}
