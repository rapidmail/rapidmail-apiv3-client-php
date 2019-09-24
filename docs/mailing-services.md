# ![rapidmail Logo](https://avatars0.githubusercontent.com/u/25850436?v=3&s=50 "rapidmail Logo") rapidmail APIv3 client

## Mailing Service

The API service to manage mailings.

### Examples

* [Fetch mailings](/examples/example-02-fetch-mailings.php)

### Retrieve a service instance
```php
$service = $client->mailings();
```
###  Available methods
```php
// Get detailed info about single mailing

$response = $service->get(/* ID */);

// Delete a single mailing

$response = $service->delete(/* ID */);

// List available mailings with optional filter crtierial applied

$collection = $service->query(/* OPTIONAL FILTER */);

// Create a new mailing using zip file content
 
$response = $service->create(/* PAYLOAD */);

// Pause a mailing

$response = $service->pause(/* ID */);

// Cancel a mailing

$response = $service->cancel(/* ID */);
```

## MailingRecipients Service

API service to get recipient details for specific mailing

```php
$service = $client->mailingRecipients();
```

###  Available methods
```php
// Get recipients for mailing

$collection = $service->query(/* MAILING ID */);

// Get details about specific mailing recipient

$response = $service->get(/* MAILING ID */, /* MAILING RECIPIENT ID */);
```

## MailingStats Service

API Service to get stats for a mailing

```php
$service = $client->mailingStats();
```

###  Available methods
```php
// Get stats for specific mailing

$response = $service->get(/* MAILING ID */);
```

## MailingStatsAnonymize Service

API service to anonymize stats for a sent mailing

```php
$service = $client->mailingStatsAnonymize();
```

###  Available methods
```php
// Anonymize mailing stats for a specific sent mailing

$response = $service->anonymize(/* MAILING ID */);
```
