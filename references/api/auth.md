# Auth

## Table of Contents

- [POST /auth/system](#login-as-system-identity)
- [POST /auth/staff](#login-as-staff-identity)
- [POST /auth/individual](#login-as-individual-identity)
- [POST /auth/organization](#login-as-organization-identity)
- [POST /auth/anonymous](#login-as-anonymous-identity)

## Login as system identity

This endpoint returns a system identity JWT token.

### Method

__POST__ `/auth/system`

### Parameters

#### Form urlencoded

| Name | Type | Description |
| :--- | :--- | :---------- |
| username | string | The system identity username. __Required.__ |
| password | string | The system identity password. __Required.__ |

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

__POST__ `/auth/system`

*Headers:*

```yaml
Accept: application/json
```

*Form urlencoded:*

```json
username: system@system.ds
password: system
```

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
  "username": "system@system.ds",
  "identity": {
    "roles": [],
    "type": "System",
    "uuid": "fe1b94ed-783a-48d7-8bf2-2f9cea89f11e"
  },
  "uuid": "4b0237d1-0917-4d8b-af6d-2aa89be336de",
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b",
  "iat": 1532016212,
  "exp": 1532102612
}
```

## Login as staff identity

This endpoint returns a staff identity JWT token.

### Method

__POST__ `/auth/staff`

### Parameters

#### Form urlencoded

| Name | Type | Description |
| :--- | :--- | :---------- |
| username | string | The staff identity username. __Required.__ |
| password | string | The staff identity password. __Required.__ |

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

__POST__ `/auth/staff`

*Headers:*

```yaml
Accept: application/json
```

*Form urlencoded:*

```json
username: admin@staff.ds
password: admin
```

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
  "username": "admin@staff.ds",
  "identity": {
    "roles": [
      "5ab54dd5-56ed-4e96-bd8b-1d60ab668a75"
    ],
    "type": "Staff",
    "uuid": "e32f09b7-e1cf-4a91-a0e1-6822bf47a662"
  },
  "uuid": "40759f94-3e8b-41a1-8a3c-dd84393da5b9",
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b",
  "iat": 1532025361,
  "exp": 1532111761
}
```

## Login as individual identity

This endpoint returns a individual identity JWT token.

### Method

__POST__ `/auth/individual`

### Parameters

#### Form urlencoded

| Name | Type | Description |
| :--- | :--- | :---------- |
| username | string | The individual identity username. __Required.__ |
| password | string | The individual identity password. __Required.__ |

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

__POST__ `/auth/individual`

*Headers:*

```yaml
Accept: application/json
```

*Form urlencoded:*

```json
username: morgan@individual.ds
password: morgan
```

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

## Login as organization identity

This endpoint returns a organization identity JWT token.

### Method

__POST__ `/auth/organization`

### Parameters

#### Form urlencoded

| Name | Type | Description |
| :--- | :--- | :---------- |
| username | string | The organization identity username. __Required.__ |
| password | string | The organization identity password. __Required.__ |

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

__POST__ `/auth/organization`

*Headers:*

```yaml
Accept: application/json
```

*Form urlencoded:*

```json
username: acme@organization.ds
password: acme
```

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
  "username": "acme@organization.ds",
  "identity": {
    "roles": [
      "777b96e7-e183-44f7-b7e4-dc0cb7591f74"
    ],
    "type": "Organization",
    "uuid": "c9599da5-35a8-494c-9181-975d78be9694"
  },
  "uuid": "336dcc1c-d7dc-46de-9640-e19dc567bd3f",
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b",
  "iat": 1532025558,
  "exp": 1532111958
}
```

## Login as anonymous identity

This endpoint returns a anonymous identity JWT token.

### Method

__POST__ `/auth/anonymous`

### Response

#### 200 OK

The request was successful and returns a JSON object that contains the following properties:

| Name | Type | Description |
| :--- | :--- | :---------- |
| token | string | The JWT token. |

### Example

#### Request

*Method:*

__POST__ `/auth/anonymous`

*Headers:*

```yaml
Accept: application/json
```

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
  "username": "anonymous@anonymous.ds",
  "identity": {
    "roles": [],
    "type": "Anonymous",
    "uuid": null
  },
  "uuid": "945824f2-3099-442d-ac4f-6c867a1692e6",
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b",
  "iat": 1532025603,
  "exp": 1532112003
}
```
