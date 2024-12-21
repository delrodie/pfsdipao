<?php

namespace App\Command;

use App\Entity\FormationProfessionnelle;
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
    name: 'app:import-formation-professionnelle',
    description: 'Importation du fichier Formation Professionnelle dans la base de données.',
)]
class ImportFormationProfessionnelleCommand extends Command
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
        $filePath = dirname(__DIR__).'/../doc/formation.xlsx';
        if (!file_exists($filePath)){
            $io->error("Echec! Le fichier Excel formation.xlxs n'existe pas dans le repertoire doc.");
            return Command::FAILURE;
        }

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
                $slug = $this->utilities->importExcel($titre, 'formation');
                if ($slug){
                    $formation = new FormationProfessionnelle();
                    $formation->setTitre($titre);
                    $formation->setSlug($slug);

                    $this->entityManager->persist($formation);
                    $nb++;
                    $progressBar->advance();
                }

            }

            $this->entityManager->flush();
            $progressBar->finish();

            $message = $nb === 0 ? "Aucune formation professionnelle n'a été importée." :
                ($nb === 1 ? "{$nb} formation professionnelle a été importée avec succès dans la base de données" :
                    "{$nb} formations professionnelles ont été importées avec succès dans la base de données");

            $io->success($message);

            return Command::SUCCESS;

        } catch (\Exception $e){
            $io->error("Erreur lors de l'importation: {$e->getMessage()} ");
            return Command::FAILURE;
        }
    }
}
