<?php

class MissionStatus
{
    private string $id;
    private string $name;

    // Fonction qui va me permettre de construire une instance de ma classe MissionStatus:
    public function __construct(string $id, string $name)
    {
        $this->setId($id);
        $this->setName($name);
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

    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    public function setName(string $name): string
    {
        return $this->name = $name;
    }
}
