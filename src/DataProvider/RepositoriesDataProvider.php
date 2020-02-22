<?php


namespace App\DataProvider;

class RepositoriesDataProvider
{
    /**
     * @var RepositoriesDataProviderInterface[]
     */
    private iterable $providers;

    public function __construct(iterable $providers)
    {
        $this->providers = $providers;
    }

    public function getProviderByName(string $name): ?RepositoriesDataProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->getProviderName() === $name) {
                return $provider;
            }
        }
        return null;
    }

    /**
     * @return RepositoriesDataProviderInterface[]
     */
    public function getProviders(): iterable
    {
        return $this->providers;
    }
}
