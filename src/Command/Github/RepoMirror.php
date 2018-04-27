<?php

namespace kiln2github\Command\Github;


use Github\Client;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RepoMirror extends Command {

  protected function configure() {
    $this
      ->setName('github:mirror')
      ->setDescription('Mirrors a repo with all its branches tags etc to Github.')
      ->setHelp('Pass your access token, new repo name, repo to clone, and privacy as arguments; 
          github:create 123456789 new_repo 1 --org=dennisinteractive --team=1234')
      ->addArgument('token', InputArgument::REQUIRED, 'The Github access token.')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the repo to create')
      ->addArgument('source', InputArgument::REQUIRED, 'The repo to mirror')
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
    $mirrored = $this->mirrorClone($output, $input->getArgument('source'));
    $uri = $this->createNewRepo($input, $output);
    $this->mirrorPush($output, $mirrored, $uri);
  }

  protected function createNewRepo(InputInterface $input, OutputInterface $output) {
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
    //todo return the uri of the new repo to push to.
    return '';
  }

  protected function mirrorClone(OutputInterface $output, $uri) {
    // todo: not hard code mirror name
    $dir = '/tmp/repo_clone';
    $process = new Process('git clone --bare ' . $uri .' '. $dir);
    $process->run();
    if (!$process->isSuccessful()) {
      throw new ProcessFailedException($process);
    }
    $output->writeln($process->getOutput());

    return $dir;
  }

  protected function mirrorPush(OutputInterface $output, $mirrored, $uri) {
    $process = new Process('cd '. $mirrored .' && git push --mirror ' . $uri);
    $process->run();
    if (!$process->isSuccessful()) {
      throw new ProcessFailedException($process);
    }
    $output->writeln($process->getOutput());
  }
}
