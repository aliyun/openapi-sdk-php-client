[← SSL Verify](/docs/en-US/7-Verify.md) | Debug[(中文)](/docs/zh-CN/8-Debug.md) | [Log →](/docs/en-US/9-Log.md)
***

# Debugging
If there is an environment variable `DEBUG=sdk` , all requests will enable debug mode.

Debug output contains sanitized request/response headers and errors. AccessKey secrets, security/bearer tokens, and complete signatures are masked; raw transport traces and bodies are not printed. Explicit `debug(true)` and a resource supplied through the `debug` request option use the same redaction.

***
[← SSL Verify](/docs/en-US/7-Verify.md) | Debug[(中文)](/docs/zh-CN/8-Debug.md) | [Log →](/docs/en-US/9-Log.md)
