# OwnerRez API
Official PHP wrapper for the OwnerRez API

## Usage

The `OwnerRez\Api\Client` serves as the entry point for all requests. Full documentation is available at TODO

```
$ownerRez = new OwnerRez\Api\Client($username, $accessToken);

$ownerRez->users()->me();

$ownerRez->properties()->get(1);

$ownerRez->properties()->search([ 
    'availabilityFrom' => '2020-01-01', 
    'availabilityTo' => '2020-01-08', 
    'limit' => 10
]);
```