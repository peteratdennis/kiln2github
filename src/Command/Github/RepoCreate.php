<?php

namespace kiln2github\Command\Github;

use Github\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepoCreate extends Command {

  protected function configure() {
    $this
      ->setName('github:create')
      ->setDescription('Creates a repo on Github.')
      ->setHelp('Pass your username, access token, new repo name, and privacy as arguments; 
          github:create peteratdennis 123456789 new_repo 1')
      ->addArgument('username', InputArgument::REQUIRED, 'Github username.')
      ->addArgument('token', InputArgument::REQUIRED, 'The Github access token.')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the repo to create')
      ->addArgument('private', InputArgument::REQUIRED, '1 for private, 0 for public')
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
      $public
    );
    $output->writeln(print_r($repo, true));
  }
}
