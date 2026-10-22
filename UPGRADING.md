# Upgrading from 1.x to 2.x

Version 2.0 drops support for old PHP and Guzzle releases and adds native type declarations throughout the client.
The API endpoints, the service methods and the array formats you pass in and get back are unchanged. If you only
use the client as shown in the [README](README.md), upgrading usually comes down to checking your platform and
updating the Composer constraint.

## 1. Check your platform

| Requirement | 1.x                 | 2.x                  |
|-------------|---------------------|----------------------|
| PHP         | 5.6 or later        | **7.4 or later**     |
| Guzzle      | 6.3, 7 or 8         | **7.15.2+ or 8.0.1+** |
| Extensions  | `json`, `fileinfo`  | `json`, `fileinfo`   |

Guzzle 6 is end of life, and all Guzzle releases below 7.15.2 (as well as 8.0.0) have known security advisories.
If your project or another dependency pins Guzzle 6, you need to upgrade it first.

If you cannot move to PHP 7.4 or a supported Guzzle version yet, stay on `^1.1`.

## 2. Update the Composer constraint

```bash
composer require rapidmail/rapidmail-apiv3-client-php:^2.0
```

## 3. Check the values you pass in

Methods now declare native parameter types. Passing a value of the wrong type throws a `TypeError` instead of
being sent to the API.

**IDs must be integers.** This affects `get()`, `delete()`, `update()`, `pause()`, `cancel()`, `anonymize()`,
`activityStats()`, the mailing folder methods and `MailingRecipientsService::get()`/`query()`.
`TrxEmailService::get()` (`$client->transactionEmails()`) is the exception and takes the email hash as a string.

```php
$client->mailings()->get(123);      // works
$client->mailings()->get('123');    // works, numeric strings are converted, see below
$client->mailings()->get('abc');    // 2.x: TypeError
$client->mailings()->get(null);     // 2.x: TypeError
```

Numeric strings such as IDs read from a request or a database are still accepted, because PHP converts them
automatically. That conversion does not happen in files that declare `declare(strict_types=1);`: there you need to
cast the value yourself, e.g. `get((int) $mailingId)`.

**Other typed parameters:**

- `Client::mailings()` and the other service accessors take `?string $version`.
- `MailingService::cancel()` takes `string $reason`.
- `MailingFoldersService::create()` and `rename()` take a `string` folder name.
- `RecipientlistService::query()` takes an `array` filter. Passing anything else already failed in 1.x.

Methods that accept either an array or a parameter object (`query($filter)`, `create($data)`, `import($data)` and
so on) and the setters on parameter objects are untyped on purpose and accept the same values as before.

**Stricter enum checks:** values for recipient gender and mail type, recipient sort field and order, recipient
import handling modes, mailing status and mailing destination type and action are now compared strictly. A non-string value that loosely matched in 1.x, such as `0` for
`'male'` on PHP 7.4, now throws an `InvalidArgumentException`. Pass the documented string values.

## 4. Update your own subclasses and implementations

Skip this step if you only call the client. It applies if you extend a class or implement an interface of this
library, e.g. to mock the HTTP client in your tests or to add a service.

Methods now declare native parameter and return types, and PHP requires overriding methods to be compatible. An
override without matching types fails with a fatal error as soon as the class is loaded.

The most common cases:

```php
// Rapidmail\ApiClient\Http\HttpClientInterface
public function request(string $method, $uri, array $options = []): \Psr\Http\Message\ResponseInterface;

// Rapidmail\ApiClient\Service\ServiceFactoryInterface
public function create(array $dependencies = []): ServiceInterface;

// Rapidmail\ApiClient\Service\Parameter\ParameterInterface
public function toArray(): array;

// Rapidmail\ApiClient\Service\AbstractService
abstract protected function getResourcePath(): string;

// Rapidmail\ApiClient\Service\Parameter\GenericParameter (and all parameter classes)
protected function getKnownAttributeKeys(): array;
protected function setAttributeRaw(string $key, $value): void;
protected function stringifyDateTime($dateTime, string $format = 'Y-m-d H:i:s'): string;

// Rapidmail\ApiClient\Service\Response\ResponseFactory
public function newHalResponse(HttpClientInterface $client, ResponseInterface $response): HalResponse;
public function newHalResponseResourceIterator(
    HttpClientInterface $client,
    string $resourceKey,
    ResponseInterface $response
): HalResponseResourceIterator;
```

Service methods, service factories and parameter factories now declare their concrete return types too, e.g.
`MailingService::get(int $mailingId): HalResponse` or `ParameterFactory::newQueryParam(array $input = []): MailingQueryParam`.
Check the class you extend for the exact signature.

Because return types are enforced, overrides can no longer return `null` where the parent declares a non-nullable
type. A mocked `ResponseFactory::newHalResponse()`, for instance, must return a `HalResponse` instance.

## 5. Behaviour you may notice

- The `User-Agent` header sent to the API now reports the client version as `2.0.0`. 1.x always sent `1.0.0`.
- `HalResponse::getIterator()` returns an `\ArrayIterator`, `HalResponseResourceIterator::key()` an `int` and
  `count()`/`totalCount()` an `int`.

See the [changelog](CHANGELOG.md) for the full list of changes.
