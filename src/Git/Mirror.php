<?php

namespace kiln2github\Git;


use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Mirror {

  public static function mirrorClone(OutputInterface $output, $uri, $dir) {
    $process = new Process('git clone --bare ' . $uri .' '. $dir);
    $process->start();

    foreach ($process as $type => $data) {
      $output->writeln($data);
    }

    if (!$process->isSuccessful()) {
      throw new ProcessFailedException($process);
    }


    return $dir;
  }

  public static function mirrorPush(OutputInterface $output, $mirrored, $uri) {
    $output->writeln('Pushing mirror to ' . $uri);
    $process = new Process('cd '. $mirrored .' && git push --mirror ' . $uri);
    $process->run();
    if (!$process->isSuccessful()) {
      throw new ProcessFailedException($process);
    }
    $output->writeln($process->getOutput());

    // Delete the local clone.
    $process = new Process('rm -fr '. $mirrored);
    $process->run();
    if (!$process->isSuccessful()) {
      throw new ProcessFailedException($process);
    }
    $output->writeln($process->getOutput());
  }
}
