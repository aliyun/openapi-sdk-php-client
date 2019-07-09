[← 请求](/docs/zh-CN/3-Request.md) | 结果[(English)](/docs/en-US/4-Result.md) | [区域 →](/docs/zh-CN/5-Region.md)
***

# 结果
返回的结果不只是字段，而是个实现了 `ArrayAccess`、 `IteratorAggregate`、 `Countable`、 `JmesPath` 等特性的对象。

```php
<?php

/**
 * @var AlibabaCloud\Client\Result\Result $result
 */

// 以对象方式访问结果
echo $result->RequestId;

// 以数组方式访问结果
echo $result['RequestId'];
echo $result['AccessPointSet.AccessPointType'];

// 将结果转换为数组
$result->toArray();

// 将结果转换为Json
$result->toJson();

// 结果是否包含某字段
$result->has('RequestId');
$result->has('AccessPointSet.AccessPointType');

// 结果是否为空
$result->isEmpty();
$result->isEmpty('RequestId');
$result->isEmpty('AccessPointSet.AccessPointType');
    
// 在结果中匹配搜索
$result->search('AccessPointSet.AccessPointType[0].Name');

// 在结果中获取某个字段
$result->get();
$result->get('AccessPointSet.AccessPointType');

// 统计结果元素
$result->count();
$result->count('AccessPointSet.AccessPointType');

// 请求结果是否成功
$result->isSuccess();

// 获取结果的请求对象
$result->getRequest();
```

***
[← 请求](/docs/zh-CN/3-Request.md) | 结果[(English)](/docs/en-US/4-Result.md) | [区域 →](/docs/zh-CN/5-Region.md)
