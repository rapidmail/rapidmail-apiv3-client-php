# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail APIv3 client

## Blacklist Service

API service to manage blacklist entries

### Examples

* [Import blacklist data](/examples/example-06-import-blacklist.php)

### Retrieve a service instance
```php
$service = $client->blacklist();
```

###  Available methods
```php
// Get info about a single blacklist entry

$response = $service->get(/* BLACKLIST ID */);

// Delete blacklist entry by ID

$response = $service->delete(/* BLACKLIST ID */);

// Get list of blacklist entries

$collection = $service->query(/* OPTIONAL FILTER */);

// Create a new blacklist entry

$response = $service->create(/* PAYLOAD */);

// Import blacklist from CSV file

$response = $service->import(/* FILE */);
```