# This project fetches issue related data for a public GitHub repository

See [Live Example](https://githubissuetest.herokuapp.com "Live Example At Heroku")

## Library Used
[See the used PHP API interface](https://github.com/tan-tan-kanarek/github-php-client "Github PHP Client")
I have used above library as was recommended by GitHub for PHP Users

## Scope For Improvement
Apart from making User Interface more user friendly, the solution integrates seemlessly with GitHub.
Only scope, where further improvements could be seen would be to asynchronously load classes for the interface.

```php
<?php
require_once(__DIR__ . '/client/GitHubClient.php');

$client = new GitHubClient();
$client->setCredentials($username, $password);
```