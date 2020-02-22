<?php


namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class LanguageDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
