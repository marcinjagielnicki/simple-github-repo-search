<?php


namespace App\DataProvider;

interface RepositoriesDataProviderInterface extends DataProviderInterface
{
    public function getProviderName(): string;
}
