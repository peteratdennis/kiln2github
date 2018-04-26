<?php

namespace kiln2github\Command\Kiln;


use GitWrapper\GitWrapper;
use kiln2github\Kiln\ClientFactory;
use kiln2github\Kiln\Projects;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepoCloneIds extends Command {

  protected function configure() {
    $this
      ->setName('kiln:cloneids')
      ->setDescription('Clones repos for the given list of repo ids "ixRepo".')
      ->setHelp('Call with token & a csv of kiln repo ids to clone')
      ->addArgument('token', InputArgument::REQUIRED, 'The Kiln access token.')
      ->addArgument('ids', InputArgument::REQUIRED, 'The Kiln repo ids.')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $gitWrapper = new GitWrapper();
    $ids = explode(',', $input->getArgument('ids'));
    $client = ClientFactory::get($input->getArgument('token'), 'Project');
    $response = $client->request('GET', '');
    $projects = new Projects();
    $projects->setResponse((string)$response->getBody());
    $repos = $projects->getRepos();
    foreach ($repos as $repo) {
      if (in_array($repo->ixRepo, $ids)) {
        $output->writeln('Cloning ' . $repo->sProjectSlug . ' ' . $repo->sGroupName . ' ' . $repo->sName);
        $dir = '/tmp/kiln_' . $repo->ixRepo;
        $git = $gitWrapper->cloneRepository(
          $repo->sGitSshUrl,
          $dir,
          ['--mirror' => null]
        );

        $output->writeln('Created repo at ' . $git->getDirectory());
      }
    }
  }
}
