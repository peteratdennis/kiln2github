<?php

namespace kiln2github\Github;


use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Mirror {

  public static function mirrorClone(OutputInterface $output, $uri, $dir) {
    $process = new Process('git clone --bare ' . $uri .' '. $dir);
    $process->run();
    if (!$process->isSuccessful()) {
      throw new ProcessFailedException($process);
    }
    $output->writeln($process->getOutput());

    return $dir;
  }

  public static function mirrorPush(OutputInterface $output, $mirrored, $uri) {
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
