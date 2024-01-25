<h1 align="center">MONICREDIT PHP</h1>

<p align="center">
  <img alt="Github top language" src="https://img.shields.io/github/languages/top/feranmiemmanuel/php-monicredit?color=56BEB8">

  <img alt="License" src="https://img.shields.io/github/license/feranmiemmanuel/php-monicredit?color=56BEB8">

  <img alt="Github issues" src="https://img.shields.io/github/issues/feranmiemmanuel/php-monicredit?color=56BEB8" />

  <img alt="Github forks" src="https://img.shields.io/github/forks/feranmiemmanuel/php-monicredit?color=56BEB8" />

</p>

<hr>

<p align="center">
  <a href="#dart-about">About</a> &#xa0; | &#xa0; 
  <a href="#white_check_mark-requirements">Requirements</a> &#xa0; | &#xa0;
  <a href="#checkered_flag-usage">Usage</a> &#xa0; | &#xa0;
  <a href="#hammer-contribution">Contribution</a> &#xa0; | &#xa0;
  <a href="#memo-license">License</a> &#xa0; | &#xa0;
  <a href="https://github.com/feranmiemmanuel" target="_blank">Author</a>
</p>

<br>

## :dart: About ##

PHP Library for [Monicredit API](https://monicredit.gitbook.io/mc-api/)

## :white_check_mark: Requirements ##

Before starting :checkered_flag:, you need to have [Git](https://git-scm.com) and [PHP 7+](https://php.net/) installed.

## :checkered_flag: Usage ##

```bash
# Installation
$ composer require jesuferanmi/php-monicredit
```

## ENV Configuration

Open your .env file and add your demo public key, live public key, demo private key, live private key and monicredit environment('DEMO' or 'LIVE') like this:

```php
MONICREDIT_DEMO_PUBLIC_KEY=""
MONICREDIT_DEMO_PRIVATE_KEY=""
MONICREDIT_LIVE_PUBLIC_KEY=""
MONICREDIT_LIVE_PRIVATE_KEY=""
MONICREDIT_ENVIRONMENT="DEMO"
```
*If you are using a hosting service like heroku, ensure to add the above details to your configuration variables.*

#Usage

- Initiate Transaction
```php
$monicredit = new Monicredit();

$customer = [
            'first_name' => 'Olasunkanmi',
            'last_name' => 'Feranmi',
            'email' => 'feranmiolasunkanmi91@gmail.com',
            'phone' => '0000000002'
        ];

$splitDetails = [
    'sub_account_code' => 'SB0000000',
    'fee_percentage' => 100,
    'fee_flat' => 0
];
$itemDetails = [
    "item" => 'Test Transaction',
    "revenue_head_code" => 'REV0000000',
    "unit_cost" => '300',
    "split_details" => array($splitDetails),
];

$payload = [
    'order_id' => rand(1000, 9000),
    'customer' => $customer,
    'items' => [$itemDetails],
    'feeBearer' => 'merchant'
];

$initiate = $monicredit->intiateTransaction($payload);
```

- Verify Transaction
```php
$monicredit = new Monicredit();

$payload = ["transaction_id" => "ACX000000"];

$verify = $monicredit->verifyTransaction($payload);
```

- Get Transaction Info
```php
$monicredit = new Monicredit();
$payload = "ACX000000";

$response = $monicredit->getInitiatedTransactionInfo();
```
<!-- 
- Available Methods 
```php
$monicredit = new Monicredit();


``` -->


## :hammer: Countribution

```bash
# fork and Clone the fork project
# Access the folder
$ cd monicredit-php

# Install dependencies
$ composer Install

# Create .env and update
$ cp .env.example .env

# Run test
$ vendor/bin/phpunit tests

```

## :memo: License ##

This project is under license from MIT. For more details, see the [LICENSE](LICENSE.md) file.

Made with :heart: by <a href="https://github.com/feranmiemmanuel" target="_blank">Emmanuel Jesuferanmi</a>

&#xa0;

## Todo:

- Update Readme with Usage

<a href="#top">Back to top</a>
