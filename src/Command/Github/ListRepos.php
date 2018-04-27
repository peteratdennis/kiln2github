<?php

namespace kiln2github\Command\Github;


use Github\Client;
use kiln2github\Github\RepoList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListRepos extends Command {

  protected function configure() {
    $this
      ->setName('github:repos')
      ->setDescription('Lists repos on Github.')
      ->setHelp('Pass your username & access token as arguments; github:repos peteratdennis 123456789')
      ->addArgument('username', InputArgument::REQUIRED, 'Github username.')
      ->addArgument('token', InputArgument::REQUIRED, 'The Github access token.')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $client = new Client();
    $client->authenticate($input->getArgument('token'), '', Client::AUTH_URL_TOKEN);
    $repositories = $client->api('user')->repositories($input->getArgument('username'));

    $repos = new RepoList();
    $repos->setData($repositories);
    $summary = $repos->getSummary();
    foreach ($summary as $repo) {
      $ln = join(",", $repo);
      $output->writeln($ln);
    }
  }
}
