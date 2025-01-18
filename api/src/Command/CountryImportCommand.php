<?php

namespace App\Command;

use App\Service\CountryImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'country:import',
    description: 'Populate the country table with the latest data from restcountries.com API',
)]
class CountryImportCommand extends Command
{
    private CountryImporter $countryImporter;

    // Inject the CountryImporter service
    public function __construct(CountryImporter $countryImporter)
    {
        $this->countryImporter = $countryImporter;
        parent::__construct();
    }

    protected function configure(): void
    {
        // You can add any necessary options or arguments if needed
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Call the import function on the service to populate the country table
        $this->countryImporter->import();

        // Provide feedback to the user
        $io->success('Countries have been successfully imported into the database!');

        return Command::SUCCESS;
    }
}
