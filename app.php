#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use kiln2github\Command\Github\RepoCreate;
use kiln2github\Command\Github\ListRepos as GithubRepoList;
use kiln2github\Command\Github\RepoMirror;
use kiln2github\Command\Kiln\RepoCloneIds;
use kiln2github\Command\Kiln\ListRepos  as KilnRepoList;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new KilnRepoList());
$application->add(new GithubRepoList());
$application->add(new RepoCreate());
$application->add(new RepoCloneIds());
$application->add(new RepoMirror());

$application->run();
