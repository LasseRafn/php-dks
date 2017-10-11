# PHP DKS REST wrapper
 
<p align="center"> 
<a href="https://travis-ci.org/LasseRafn/php-dks"><img src="https://img.shields.io/travis/LasseRafn/php-dks.svg?style=flat-square" alt="Build Status"></a>
<a href="https://coveralls.io/github/LasseRafn/php-dks"><img src="https://img.shields.io/coveralls/LasseRafn/php-dks.svg?style=flat-square" alt="Coverage"></a>
<a href="https://styleci.io/repos/106525200"><img src="https://styleci.io/repos/106525200/shield?branch=master" alt="StyleCI Status"></a>
<a href="https://packagist.org/packages/LasseRafn/php-dks"><img src="https://img.shields.io/packagist/dt/LasseRafn/php-dks.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/LasseRafn/php-dks"><img src="https://img.shields.io/packagist/v/LasseRafn/php-dks.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/LasseRafn/php-dks"><img src="https://img.shields.io/packagist/l/LasseRafn/php-dks.svg?style=flat-square" alt="License"></a>
</p>

## Installation

Require using composer

``` bash
$ composer require lasserafn/php-dks
```

### Usage

#### Example

``` php
<?php  
require_once vendor/autoload.php';

$dks = new \LasseRafn\DKS\Api();

$dks->testMode()->requestToken('customerNumber', 'username', 'password');

var_dump( $dks->statuses() ); // returns all case statuses
```

#### Auth

todo

#### Test auth

todo

#### Create Case

todo

#### Get case statuses

todo

#### Production / Testing

todo

### Requirements

* PHP +7.0