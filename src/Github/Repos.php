<?php

namespace kiln2github\Github;

Class Repos {

  protected $data;

  public function setData(array $data) {
    $this->data = $data;
  }

  public function getSummary() {
    $list = [];

    foreach ($this->data as $repo) {
      $item['id'] = $repo['id'];
      $item['name'] = $repo['name'];
      $item['private'] = $repo['private'];
      $item['git_url'] = $repo['git_url'];
      $item['clone_url'] = $repo['clone_url'];
      $list[] = $item;
    }

    return $list;
  }

}
