<?php

namespace kiln2github\Command\Github;


use kiln2github\Git\Mirror;
use kiln2github\Github\Repo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class RepoMirror extends Command {

  protected function configure() {
    $this
      ->setName('github:mirror')
      ->setDescription('Mirrors a repo with all its branches tags etc to Github.')
      ->setHelp('Pass your access token, new repo name, repo to clone, and privacy as arguments; 
          github:mirror 123456789 new_repo git@github.com:peteratdennis/kiln2github.git --private=1 --org=dennisinteractive --team=1234')
      ->addArgument('token', InputArgument::REQUIRED, 'The Github access token.')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the repo to create')
      ->addArgument('source', InputArgument::REQUIRED, 'The repo to mirror')
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
    //todo: not hard code the directory of the mirror clone.
    $mirrored = Mirror::mirrorClone($output, $input->getArgument('source'), '/tmp/repo_clone');
    $urls = Repo::create($input);
    $output->writeln('Created ' . $urls['url']);
    Mirror::mirrorPush($output, $mirrored, $urls['ssh_url']);
  }
}
