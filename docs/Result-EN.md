[← Request](Request-EN.md) | Result[(中文)](Result-CN.md) | [Region →](Region-EN.md)
***

## Result
Returned result is not just filed, but the objects with characters like `ArrayAccess`, `IteratorAggregate`, `Countable`, `JmesPath` et al.

```php
<?php

/**
 * @var AlibabaCloud\Client\Result\Result $result
 */

// Accessing results by objects
echo $result->RequestId;

// Accessing results by array
echo $result['RequestId'];
echo $result['AccessPointSet.AccessPointType'];

// Convert result to array
$result->toArray();

// Convert result to Json
$result->toJson();

// Result contains some fields
$result->has('RequestId');
$result->has('AccessPointSet.AccessPointType');
    
// Is the result empty
$result->isEmpty();
$result->isEmpty('RequestId');
$result->isEmpty('AccessPointSet.AccessPointType');
    
// Search and match from the result
$result->search('AccessPointSet.AccessPointType[0].Name');

// Get a field from the results
$result->get();
$result->get('AccessPointSet.AccessPointType');

// Count result elements
$result->count();
$result->count('AccessPointSet.AccessPointType');

// Is the result requested successful
$result->isSuccess();

// Get response from the result
$result->getResponse();

// Get the request object from the result
$result->getRequest();
```

***
[← Request](Request-EN.md) | Result[(中文)](Result-CN.md) | [Region →](Region-EN.md)
