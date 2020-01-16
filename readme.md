# Nighten Api Client

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
