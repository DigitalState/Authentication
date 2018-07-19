# Config

## Table of Contents

- [GET /configs](#get-configs)
- [GET /configs/{uuid}](#get-/configs/uuid)
- [PUT /configs/{uuid}](#put-/configs/uuid)

## GET /configs

This endpoint returns the list of configurations.

### Request

`GET /configs`

### Response

```
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

### Request

`GET /configs/20346d3f-5ef2-4aec-a644-210c5e71d662`

### Response

```
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

### Request

`PUT /configs/20346d3f-5ef2-4aec-a644-210c5e71d662`

```
{
  "enabled": false,
  "version": 1
}
```

### Response

```
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
