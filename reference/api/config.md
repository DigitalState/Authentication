# Config

## Table of Contents

- [GET /configs](#get-configs)
- [GET /configs/{uuid}](#get-configsuuid)
- [PUT /configs/{uuid}](#put-configsuuid)

## GET /configs

This endpoint returns the list of configurations.

#### Endpoint

`/configs`

#### Headers

Authorization: Bearer ********
Content-Type: application/json
Accept: application/json

#### Response

##### Code

200
403
404

##### Body

```json
[
  {
    "id": 0,
    "uuid": "string",
    "createdAt": "2018-07-20T13:19:30.181Z",
    "updatedAt": "2018-07-20T13:19:30.181Z",
    "owner": "string",
    "ownerUuid": "string",
    "key": "string",
    "value": [
      "string"
    ],
    "enabled": true,
    "version": 0,
    "tenant": "string"
  }
]
```

### Example

*Request*

__GET__ /configs

*Response*

```json
[
  {
    "id": 1,
    "uuid": "20346d3f-5ef2-4aec-a644-210c5e71d662",
    "createdAt": "2018-07-18T19:20:18+00:00",
    "updatedAt": "2018-07-18T19:20:18+00:00",
    "owner": "BusinessUnit",
    "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
    "key": "app.registration.individual.owner.type",
    "value": "BusinessUnit",
    "enabled": true,
    "version": 1,
    "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
  },
  {
    ...
  }
]
```

## GET /configs/{uuid}

This endpoint returns a specific configuration.

### Example

*Request*

__GET__ /configs/20346d3f-5ef2-4aec-a644-210c5e71d662

*Response*

```json
{
  "id": 1,
  "uuid": "20346d3f-5ef2-4aec-a644-210c5e71d662",
  "createdAt": "2018-07-18T19:20:18+00:00",
  "updatedAt": "2018-07-18T19:20:18+00:00",
  "owner": "BusinessUnit",
  "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
  "key": "app.registration.individual.owner.type",
  "value": "BusinessUnit",
  "enabled": true,
  "version": 1,
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
}
```

### PUT /configs/{uuid}

This endpoint edits a specific configuration.

### Example

*Request*

__PUT__ /configs/20346d3f-5ef2-4aec-a644-210c5e71d662

```json
{
  "enabled": false,
  "version": 1
}
```

*Response*

```json
{
  "id": 1,
  "uuid": "20346d3f-5ef2-4aec-a644-210c5e71d662",
  "createdAt": "2018-07-18T19:20:18+00:00",
  "updatedAt": "2018-07-18T19:20:18+00:00",
  "owner": "BusinessUnit",
  "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
  "key": "app.registration.individual.owner.type",
  "value": "BusinessUnit",
  "enabled": false,
  "version": 2,
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
}
```
