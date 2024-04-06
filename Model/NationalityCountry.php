<?php

class NationalityCountry
{
    private string $id;
    private string $name;
    private string $country;

    // Fonction qui va me permettre de construire une instance de ma classe Nationality:
    public function __construct(string $id, string $name, string $country)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setCountry($country);
    }

    // Etant donné que j'ai choisi de mettre en privé les propriétés de ma classe, je dois faire les getters et les setters afin d'accéder et d'enregistrer les données:
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    public function setCountry(string $country): string
    {
        return $this->country = $country;
    }
}
