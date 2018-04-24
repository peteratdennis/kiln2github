#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use kiln2github\Command\Kiln\ReposList;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new ReposList());

$application->run();
