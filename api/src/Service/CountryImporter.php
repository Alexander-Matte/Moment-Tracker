<?php

namespace App\Service;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class CountryImporter
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function import(): void
    {
        $apiKey = $_ENV['COUNTRY_API_KEY'];
        try {
            $response = $this->httpClient->request('GET', 'https://countryapi.io/api/all?apikey=' . $apiKey);
            $countryData = $response->toArray();
            $this->logger->info('Successfully fetched country data from API.');
        } catch (\Exception $e) {
            $this->logger->error('Failed to fetch country data: ' . $e->getMessage());
            throw $e;
        }

        foreach ($countryData as $country) {
            $name = $country['name'];
            $iso = $country['alpha3Code'];
            $region = $country['region'];

            // Check if the country already exists by its ISO code
            $existingCountry = $this->entityManager->getRepository(Country::class)->findOneBy(['iso' => $iso]);

            if ($existingCountry) {
                $isNameChanged = $existingCountry->getName() !== $name;
                $isRegionChanged = $existingCountry->getRegion() !== $region;

                if ($isNameChanged || $isRegionChanged) {
                    $existingCountry->setName($name);
                    $existingCountry->setRegion($region);
                    $existingCountry->setUpdatedAt(new \DateTimeImmutable());

                    $this->logger->info('Updated country: ' . $name . ' (' . $iso . ')');
                }

                continue;
            }

            // Create a new country entity and set the fields
            $newCountry = new Country();
            $newCountry->setId(Uuid::v4()); // Generate a UUID for the id field
            $newCountry->setName($name);
            $newCountry->setIso($iso);
            $newCountry->setRegion($region);
            $newCountry->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($newCountry);
            $this->logger->info('Created new country: ' . $name . ' (' . $iso . ')');
        }

        // Flush the changes to the database
        $this->entityManager->flush();
        $this->logger->info('All countries have been successfully imported/updated.');
    }
}
