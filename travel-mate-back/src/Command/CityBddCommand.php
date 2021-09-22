<?php

namespace App\Command;

use App\Entity\City;
use App\Repository\CountryRepository;
use App\Service\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CityBddCommand extends Command
{
    protected static $defaultName = 'city:bdd';
    protected static $defaultDescription = 'Add a short description for your command';

    private $callApiService;
    private $countryRepository;
    private $manager;

    public function __construct(CallApiService $callApiService, CountryRepository $countryRepository, EntityManagerInterface $manager) 
    {
        // retrieving the country list.
        $this->countryRepository = $countryRepository;

        // we need to call the API's datas.
        $this->callApiService = $callApiService;

        // to save the datas to the database.
        $this->manager = $manager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $countriesList = $this->countryRepository->findAll();

        foreach ($countriesList as $country) {
            
            $id = $country->getId();
            $citiesList = $this->callApiService->getCitiesData($country->getCountryCode());

            foreach ($citiesList as $city) {
                
                $countryCode = $city['country']['id'];
                $cityName = $city['name'];


                $newCity = new City;

                // we add the country properties to the new country.
                $newCity->setName($cityName);
                $newCity->setCountryCode($countryCode);
                $newCity->setCountry($country);

                // we save it 
                $this->manager->persist($newCity);

            }

        }

        // 3) We add all the news countries to the database.
        $this->manager->flush();

        // success message
        $io->success('Ajout des Villes effectuées avec succès !');

        return Command::SUCCESS;
    }
}
