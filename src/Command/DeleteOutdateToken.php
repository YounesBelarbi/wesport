<?php

namespace App\Command;

use App\Repository\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteOutdateToken extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:token-cleaner';
    private $entitymanager;
    private $userTokenRepository;

    public function __construct(EntityManagerInterface $entitymanager, UserTokenRepository $userTokenRepository)
    {
        parent::__construct();
        $this->entitymanager = $entitymanager;
        $this->userTokenRepository = $userTokenRepository;
    }

    protected function configure()
    {
        $this
        ->setDescription('Delete token if it is obsolete.')
        ->setHelp('This command is used to clean the database of perimated tokens.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Token cleaner',
            '============',
            '',
        ]);

        $compteur = 0;
        $currentDate = new \DateTime();
        $allTokens = $this->userTokenRepository->findAll();

        foreach ($allTokens as $key => $token) {
            if ($token->getExpirationDate() < $currentDate) {
                $this->entitymanager->remove($token);
                $this->entitymanager->flush();
                $compteur++;
            }
        }

        $io = new SymfonyStyle($input, $output);
        $io->success($compteur . ' token ont été suuprimés avec succès !');
        $output->writeln('your database is clean.');

        return 0;
    }
}
