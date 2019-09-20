# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail APIv3 client

## Recipients Service

API Service to manage recipients

```php
$service = $client->recipients();
```

###  Available methods
```php
// Load a single recipient by ID

$response = $service->get(/* RECIPIENT ID */);

// Delete recipient by ID

$response = $service->delete(/* RECIPIENT ID */, /* OPTIONAL MODIFIER */);

// List all recipients

$collection = $service->query(/* FILTER */);

// Create a new recipient

$response = $service->create(/* PAYLOAD */, /* OPTIONAL MODIFIER */);

// Update a specific recipient allowing partial updates

$response = $service->update(/* RECIPIENT ID */, /* PAYLOAD */);

// Import a list of recipients into the recipientlist from a CSV file

$response = $service->import(/* PAYLOAD */, /* OPTIONAL MODIFIER */);
```