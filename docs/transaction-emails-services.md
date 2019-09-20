# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail APIv3 client

## Transaction Emails Service

API service to fetch transactional emails

```php
$service = $client->transactionEmails();
```

###  Available methods
```php
// Get list of transaction emails

$collection = $service->query(/* OPTIONAL FILTER */);

// Get info about a single transaction email

$response = $service->get(/* MAILHASH */);
```