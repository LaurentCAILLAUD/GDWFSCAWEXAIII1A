<?php

class AgentSpeciality
{
    private string $agentId;
    private string $specialityId;

    // Fonction qui va me permettre de construire une instance de ma classe Mission:
    public function __construct(string $agentId, string $specialityId)
    {
        $this->setAgentId($agentId);
        $this->setSpecialityId($specialityId);
    }

    // Etant donné que j'ai choisi de mettre en privé les propriétés de ma classe, je dois faire les getters et les setters afin d'accéder et d'enregistrer les données:
    public function getAgentId(): string
    {
        return $this->agentId;
    }

    public function getSpecialityId(): string
    {
        return $this->specialityId;
    }

    public function setAgentId(string $agentId): string
    {
        return $this->agentId = $agentId;
    }

    public function setSpecialityId(string $specialityId): string
    {
        return $this->specialityId = $specialityId;
    }
}
