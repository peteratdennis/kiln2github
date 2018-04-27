<?php

namespace kiln2github\Github;

use Github\Client;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Repo {

  public static function create(InputInterface $input) {
    $public = ($input->getOption('private') == '1') ? false : true;
    $org = (empty($input->getOption('org'))) ? null : $input->getOption('org');
    $team = (empty($input->getOption('team'))) ? null : $input->getOption('team');
    $client = new Client();
    $client->authenticate($input->getArgument('token'), '', Client::AUTH_URL_TOKEN);
    $repo = $client->api('repo')->create(
      $input->getArgument('name'),
      '',
      '',
      $public,
      $org,
      true,
      true,
      true,
      $team
    );

    $urls = [
      'url' => $repo['url'],
      'git_url' => $repo['git_url'],
      'ssh_url' => $repo['ssh_url'],
      'clone_url' => $repo['clone_url'],
    ];

    return $urls;
  }

}
