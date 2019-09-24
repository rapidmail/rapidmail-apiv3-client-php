# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail APIv3 client

##  Service

API Service to manage API users

### Retrieve a service instance
```php
$service = $client->apiUsers();
```

###  Available methods
```php
// Get details about an API user

$response = $service->get(/* API USER ID */);

// Delete a single API user

$collection = $service->delete(/* API USER ID */);
 
// Get a list of API users

$collection = $service->query();

// Create a new API user

$response = $service->create(/* PAYLOAD */);

// Partially update an API user

$response = $service->update(/* API USER ID */, /* PAYLOAD */);
```