<?php

namespace App\Command;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:populate-countries',
    description: 'Fetches countries from the REST API and populates the Country table.',
)]
class PopulateCountries extends Command
{
    private EntityManagerInterface $entityManager;
    private HttpClientInterface $httpClient;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Fetching country data from REST API...');

        // Fetch countries from the REST API
        $response = $this->httpClient->request('GET', 'https://restcountries.com/v3.1/all');
        $countriesData = $response->toArray();

        $now = new \DateTimeImmutable();
        $repository = $this->entityManager->getRepository(Country::class);

        foreach ($countriesData as $countryData) {
            $name = $countryData['name']['common'] ?? null;
            $code = $countryData['cca3'] ?? null;
            $region = $countryData['region'] ?? 'Unknown';

            if (!$name || !$code) {
                continue; // Skip if essential data is missing
            }

            $existingCountry = $repository->findOneBy(['code' => $code]);

            if ($existingCountry) {
                // Update the updated_at timestamp if the country exists
                $existingCountry->setUpdatedAt($now);
                $output->writeln("Updated: $name");
            } else {
                // Create a new country entry
                $country = new Country();
                $country->setName($name)
                        ->setCode($code)
                        ->setRegion($region)
                        ->setCreatedAt($now)
                        ->setUpdatedAt($now);

                $this->entityManager->persist($country);
                $output->writeln("Inserted: $name");
            }
        }

        // Flush all changes to the database
        $this->entityManager->flush();

        $output->writeln('Country table population complete.');
        return Command::SUCCESS;
    }
}
