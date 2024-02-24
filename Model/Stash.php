<?php

class Stash
{
    private int $code;
    private string $address;
    private string $country;
    private string $type;
    private string $missionId;

     // Fonction qui va me permettre de construire une instance de ma classe Stash:
    public function __construct(int $code, string $address, string $country, string $type, string $missionId)
    {
        $this->setCode($code);
        $this->setAddress($address);
        $this->setCountry($country);
        $this->setType($type);
        $this->setMissionId($missionId);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMissionId(): string
    {
        return $this->missionId;
    }

    public function setCode(int $code): int
    {
        return $this->code = $code;
    }

    public function setAddress(string $address): string
    {
        return $this->address = $address;
    }

    public function setCountry(string $country): string
    {
        return $this->country = $country;
    }

    public function setType(string $type): string
    {
        return $this->type = $type;
    }

    public function setMissionId(string $missionId): string
    {
        return $this->missionId = $missionId;
    }
}
