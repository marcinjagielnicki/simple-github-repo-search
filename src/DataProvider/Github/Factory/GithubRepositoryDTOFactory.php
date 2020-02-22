<?php


namespace App\DataProvider\Github\Factory;

use App\DTO\LanguageDTO;
use App\DTO\RepositoryDTO;

class GithubRepositoryDTOFactory
{
    public function fromArray(array $array): RepositoryDTO
    {
        $dto = new RepositoryDTO();
        $dto->setName($array['name']);
        $dto->setFullName($array['full_name']);
        $dto->setUrl($array['html_url']);

        if (isset($array['parent'])) {
            $dto->setForkOf($this->fromArray($array['parent']));
        }

        if (isset($array['languages'])) {
            foreach ($array['languages'] as $language) {
                $dto->addLanguage(new LanguageDTO($language));
            }
        }

        if (isset($array['forks_list'])) {
            foreach ($array['forks_list'] as $fork) {
                $dto->addFork($this->fromArray($fork));
            }
        }

        return $dto;
    }
}
