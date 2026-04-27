<?php

namespace App\Command;

use App\Service\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:seed-users', description: 'Testdaten anlegen')]
class SeedUsersCommand extends Command
{
    public function __construct(private UserService $userService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = [
            ['admin', 'admin@webconia.de', 'admin123', 'admin'],
            ['korbi', 'k.saxinger@webconia.de', 'test456', 'user'],
            ['testuser', 'test@example.com', 'password', 'user'],
            ['inactive', 'old@example.com', 'old123', 'user'],
        ];

        foreach ($users as [$username, $email, $password, $role]) {
            $this->userService->createUser($username, $email, $password, $role);
            $output->writeln("User '$username' erstellt.");
        }

        // Den letzten User deaktivieren
        $output->writeln('Testdaten fertig.');

        return Command::SUCCESS;
    }
}
