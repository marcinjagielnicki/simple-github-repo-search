<?php


namespace App\DTO;

class RepositoryDTO
{
    /**
     * Short name of repository.
     *
     * @var string
     */
    protected string $name;

    /**
     * Full name of repository.
     *
     * @var string
     */
    protected string $fullName;

    /**
     * URL to repository.
     *
     * @var string
     */
    protected string $url;

    /**
     * Parent repository.
     *
     * @var RepositoryDTO|null
     */
    protected ?RepositoryDTO $forkOf = null;

    /**
     * @var LanguageDTO[]
     */
    protected array $languages = [];

    /**
     * @var RepositoryDTO[]
     */
    protected array $forks = [];

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

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return RepositoryDTO|null
     */
    public function getForkOf(): ?RepositoryDTO
    {
        return $this->forkOf;
    }

    /**
     * @param RepositoryDTO|null $forkOf
     */
    public function setForkOf(?RepositoryDTO $forkOf): void
    {
        $this->forkOf = $forkOf;
    }

    /**
     * @return LanguageDTO[]
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * @param LanguageDTO[] $languages
     */
    public function setLanguages(array $languages): void
    {
        $this->languages = $languages;
    }

    public function addLanguage(LanguageDTO $language): void
    {
        $this->languages[] = $language;
    }

    /**
     * @return RepositoryDTO[]
     */
    public function getForks(): array
    {
        return $this->forks;
    }

    /**
     * @param RepositoryDTO[] $forks
     */
    public function setForks(array $forks): void
    {
        $this->forks = $forks;
    }

    public function addFork(RepositoryDTO $fork): void
    {
        $this->forks[] = $fork;
    }
}
