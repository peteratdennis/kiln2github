<?php

namespace kiln2github\Command\Github;

use Github\Client;
use kiln2github\Github\Repo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RepoCreate extends Command {

  protected function configure() {
    $this
      ->setName('github:create')
      ->setDescription('Creates a repo on Github.')
      ->setHelp('Pass your access token, new repo name, repo to clone, and privacy as arguments; 
          github:create 123456789 new_repo --private=1 --org=dennisinteractive --team=1234')
      ->addArgument('token', InputArgument::REQUIRED, 'The Github access token.')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the repo to create')
      ->addOption(
        'private',
        'p',
        InputOption::VALUE_OPTIONAL,
        '1 for private repo',
        '0'
      )
      ->addOption(
        'org',
        'o',
        InputOption::VALUE_OPTIONAL,
        'Organisation to create the repo in',
        ''
      )
      ->addOption(
        'team',
        't',
        InputOption::VALUE_OPTIONAL,
        'Team that can use the repo',
        ''
      )
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    Repo::create($input, $output);
  }
}
