<?php

namespace Domain\Model\Entity\Project;

class Project
{
    private ?int $id = null;
    private string $uuid;
    private string $title;

    public function __construct(string $uuid, string $title)
    {
        $this->uuid = $uuid;
        $this->title = $title;
    }

    public function update(string $title): void
    {
        $this->title = $title;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
