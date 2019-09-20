# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail APIv3 client

## Recipientlists Service

API Service to manage recipientlists

```php
$service = $client->recipientlists();
```

###  Available methods
```php
// Get details for a specific recipientlist

$response = $service->get(/* RECIPIENTLIST ID */);

// Delete recipientlist specified by ID

$response = $service->delete(/* RECIPIENTLIST ID */);

// Get a list of recipientlists from current account

$collection = $service->query(/* OPTIONAL FILTER */);

// Create a new recipientlist

$response = $service->create(/* PAYLOAD */);

// Update a specific recipientlist allowing partial updates

$response = $service->update(/* RECIPIENTLIST ID */, /* PAYLOAD */);

// Get activity stats for a specific recipientlist

$response = $service->activityStats(/* RECIPIENTLIST ID */, /* REQUIRED FILTER */);
```