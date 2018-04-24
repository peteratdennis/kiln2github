<?php

namespace kiln2github\Kiln;

Class Projects {

  protected $response;
  protected $data;

  public function setResponse($str) {
    $this->response = $str;
    $this->data = json_decode($str);
  }

  public function getProjectIxs() {
    $ixs = [];
    foreach ($this->data as $datum) {
      $ixs[] = $datum->ixProject;
    }

    return $ixs;
  }

  public function getRepos() {
    $list = [];
    foreach ($this->data as $project) {
      foreach ($project->repoGroups as $repoGroup) {
        foreach ($repoGroup->repos as $repo) {
          $list[$repo->ixRepo] = [
            'ProjectName' => $repo->sProjectSlug,
            'GroupName' => $repo->sGroupName,
            'Name' => $repo->sName,
            'url' => $repo->sGitUrl,
          ];
        }
      }
    }

    return $list;
  }

}
