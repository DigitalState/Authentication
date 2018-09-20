# OAuth

## Table of Contents

- [GET /oauth/{identity}/{authenticator}/redirect](#login-using-third-party-authenticator)

## Login using third-party authenticator

This endpoint returns a system identity JWT token.

### Method

__GET__ `/oauth/{identity}/{authenticator}/redirect`

### Parameters

#### Path Parameters

| Name | Type | Description |
| :--- | :--- | :---------- |
| identity | string | The identity type. __Required.__ Possible values: `individual`, `organization`. |
| authenticator | string | The third-party authenticator. __Required.__ Possible values: `github`, `google`, `twitter`. |

### Response

#### 200 OK

The request was successful and returns a JSON object that contains the following properties:

| Name | Type | Description |
| :--- | :--- | :---------- |
| token | string | The JWT token. |

#### 401 Unauthorized

The request was unsuccessful and and returns a JSON object that contains the following properties:

| Name | Type | Description |
| :--- | :--- | :---------- |
| code | string | The error code. |
| message | string | The error message. |

### Example

#### Request

*Method:*

__GET__ `/oauth/individual/github/redirect`

#### Response

*Code:*

`200 OK`

*Body:*

```json
{
  "token": "{header}.{payload}.{signature}"
}
```

Decoded payload:

```
{
  "roles": [
    "ROLE_USER"
  ],
  "username": "morgan@individual.ds",
  "identity": {
    "roles": [
      "54d82fc6-8ce7-498e-832f-3598664a9d9d"
    ],
    "type": "Individual",
    "uuid": "d0daa7e4-07d1-47e6-93f2-0629adaa3b49"
  },
  "uuid": "42182fd0-9665-4ba4-9f5c-ec290e23814e",
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b",
  "iat": 1532025449,
  "exp": 1532111849
}
```
