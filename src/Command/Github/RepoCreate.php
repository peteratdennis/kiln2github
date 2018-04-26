<?php

namespace kiln2github\Command\Github;

use Github\Client;
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
      ->setHelp('Pass your access token, new repo name, and privacy as arguments; 
          github:create 123456789 new_repo 1 --org=dennisinteractive --team=1234')
      ->addArgument('token', InputArgument::REQUIRED, 'The Github access token.')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the repo to create')
      ->addArgument('private', InputArgument::REQUIRED, '1 for private, 0 for public')
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
    $public = ($input->getArgument('private') == '1') ? false : true;
    $client = new Client();
    $client->authenticate($input->getArgument('token'), '', Client::AUTH_URL_TOKEN);
    $repo = $client->api('repo')->create(
      $input->getArgument('name'),
      '',
      '',
      $public,
      $input->getOption('org'),
      true,
      true,
      true,
      $input->getOption('team')
    );
    $output->writeln(print_r($repo, true));
  }
}
