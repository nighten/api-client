# Nighten Api Client

[![Latest Stable Version](https://poser.pugx.org/nighten/api-client/v/stable)](https://packagist.org/packages/nighten/api-client)
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

## Лицензия

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details
