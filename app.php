#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use kiln2github\Command\Github\RepoList as GithubRepoList;
use kiln2github\Command\Kiln\RepoList  as KilnRepoList;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new KilnRepoList());
$application->add(new GithubRepoList());

$application->run();
