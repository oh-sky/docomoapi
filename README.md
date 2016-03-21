# PHP Library for docomo APIs


# Installation

```
composer require oh-sky/docomoapi
```

# How to use

```
<?php

$apiKey = 'Your Api Key';
$talk = new \OhSky\DocomoApi\Talk($apiKey);
$res = $talk->request('Hello');
echo $res->utt;
```
