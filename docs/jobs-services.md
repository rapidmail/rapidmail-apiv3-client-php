# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail APIv3 client

## Jobs Service

API service to poll information about jobs from the jobexecutor queue

```php
$service = $client->jobs();
```

###  Available methods
```php
// Get details about a specific job

$response = $service->get(/* JOB ID */);
```