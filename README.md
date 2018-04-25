# kiln2github
Tools to migrate from Kiln to Github

## Install
Checkout this repo them run `composer install`.

## Basic Usage

### List Kiln repos
`app.php kiln:repos token`

 - _token_: the api token obtained from the Kiln settings page.

### List Github repos
`app.php github:repos username token`

 - _username_: the github account to run commands as
 - _token_: the api token obtained from the Github settings page.

### Create a Github repo
`app.php github:create username token name private`

 - _username_: the github account to run commands as
 - _token_: the api token obtained from the Github settings page.
 - _name_:the name of the new repo to be created
 - _private_: **1** for a private repo, **0** for a public repo
