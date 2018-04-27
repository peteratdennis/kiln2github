# kiln2github
Tools to migrate from Kiln to Github

## Install
Checkout this repo them run `composer install`.

## Usage

### List Kiln repos
`./app.php kiln:repos token`

 - _token_: the api token obtained from the Kiln settings page.

### List Github repos
`./app.php github:repos token`

 - _token_: the api token obtained from the Github settings page.

### Create a Github repo
`./app.php github:create token name`

 - _token_: the api token obtained from the Github settings page.
 - _name_:the name of the new repo to be created
 
 ##### Options
 - _--private_: **1** for a private repo, **0** for a public repo
 - _--org_:  the organisation to create the repo in.
 - _--team_: the teamid for the repo permissions

### Copy a repo with all branches, tags etc to Github
`./app.php github:mirror token name source`

 - _token_: the api token obtained from the Github settings page.
 - _name_:the name of the new repo to be created
 - _source_: the clone url of the repo to copy
 
 ##### Options
 - _--private_: **1** for a private repo, **0** for a public repo
 - _--org_:  the organisation to create the repo in.
 - _--team_: the teamid for the repo permissions
