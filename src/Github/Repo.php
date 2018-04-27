<?php

namespace kiln2github\Github;

use Github\Client;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Repo {

  public static function create(InputInterface $input, OutputInterface $output) {
    $public = ($input->getOption('private') == '1') ? false : true;
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
    //todo return the uri of the new repo to push to.
    return '';
  }

}
