[← SSL 验证](/docs/zh-CN/7-Verify.md) | 调试[(English)](/docs/en-US/8-Debug.md) | [日志 →](/docs/zh-CN/9-Log.md)
***

# 调试
如果存在环境变量 `DEBUG=sdk` ，所有请求将启用调试输出。

调试输出包含脱敏后的请求头、响应头及错误信息；AccessKey Secret、Security Token、Bearer Token 和完整签名会被隐藏，不再输出原始传输跟踪或正文。显式 `debug(true)` 和通过 `debug` 请求选项传入的输出资源使用同样的脱敏规则。

***
[← SSL 验证](/docs/zh-CN/7-Verify.md) | 调试[(English)](/docs/en-US/8-Debug.md) | [日志 →](/docs/zh-CN/9-Log.md)
