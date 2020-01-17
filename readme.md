# Nighten Api Client

[![Latest Stable Version](https://poser.pugx.org/nighten/api-client/v/stable)](https://packagist.org/packages/nighten/api-client)
[![Build Status](https://travis-ci.org/nighten/api-client.svg?branch=master)](https://travis-ci.org/nighten/api-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nighten/api-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nighten/api-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/nighten/api-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/nighten/api-client/?branch=master)
[![License](https://poser.pugx.org/nighten/api-client/license)](https://packagist.org/packages/nighten/api-client)

## Описание

Библиотека для взаимодействия с API

## Установка
```
composer require nighten/api-client
```

## Пример

### Создание клиента
```php
$client = new \Nighten\ApiClient\Client($host);
```

### Аунтификация в API
```php
$response = $client->request(new AuthRequest($login, $password)); //return \Nighten\ApiClient\Response\Auth\AuthResponse;
$response->getUserId(); //Уникальный идентификатор пользователя
$response->getKey(); //Api ключ, для аунтификации в запросах требующих ключ.
```

### Запросы требующие ключ
```php
$client->setAuthenticationProvider(new DefaultAuthenticationProvider('api-key'));
$response = $client->request(...);
```

## Лицензия

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details
