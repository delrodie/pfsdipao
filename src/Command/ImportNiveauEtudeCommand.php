<?php

namespace App\Command;

use App\Entity\NiveauEtude;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-niveau-etude',
        description: "Importation du fichier Excel Niveau d'étude dans la base de données.",
)]
class ImportNiveauEtudeCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Utilities $utilities
    )
    {
        parent::__construct();
    }

//    protected function configure(): void
//    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
//    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $progressBar = new ProgressBar($output);
        $progressBar->start();

        // Chemin vers le fichier Excel
        if (!file_exists(dirname(__DIR__).'/../doc/niveau.xlsx')){
            $io->error("Echec, le fichier Excel niveau.xlsx n'existe pas.");
            return Command::FAILURE;
        }

        $filePath = dirname(__DIR__).'/../doc/niveau.xlsx';

        try{
            // Lecture du fichier Excel
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Boucle pour traiter chaque ligne
            $nb=0;
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;

                $titre = $row[0];
                $slug = $this->utilities->importNiveau($titre);
                if ($slug){
                    $niveauEtude = new NiveauEtude();
                    $niveauEtude->setTitre($titre);
                    $niveauEtude->setSlug($slug);

                    $this->entityManager->persist($niveauEtude);
                    $nb++;
                    $progressBar->advance();
                }

            }

            $this->entityManager->flush();
            $progressBar->finish();

            $io->success("{$nb} niveaux d'étude ont été importés avec succès dans la base de données.");

            return Command::SUCCESS;

        } catch (\Exception $e){
            $io->error("Erreur lors de l'importation: {$e->getMessage()} ");
            return Command::FAILURE;
        }

    }
}
