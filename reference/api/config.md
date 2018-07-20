# Config

## Table of Contents

- [Get List](#get-list)
- [Get](#get)
- [Update](#update)

## Get List

This endpoint returns the list of configurations.

### Method

GET `/configs`

### Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| id | integer | Restrict to configs with the given id. | 1 |
| uuid | string | Restrict to configs with the given uuid. | 21046af5-26e7-4a05-bfd8-38c0d9aa0302 |
| owner | string | Restrict to configs with the given owner. | BusinessUnit |
| ownerUuid | string | Restrict to configs with the given owner uuid. | 5809b2e4-3ab1-4ed5-a419-04e6f3d05959 |
| key | string | Restrict to configs with the given key. | app.registration.individual.owner.type |
| createdAt[before] | string | Restrict to configs created before the given date. | 2018-07-20T13:19:30.181Z |
| createdAt[after] | string | Restrict to configs created after the given date. | 2018-07-20T13:19:30.181Z |
| updatedAt[before] | string | Restrict to configs update before the given date. | 2018-07-20T13:19:30.181Z |
| updatedAt[after] | string | Restrict to configs created after the given date. | 2018-07-20T13:19:30.181Z |
| enabled | boolean | Restrict to configs with given enabled status. | true |

### Response

A JSON array of config objects. Each config object contains the following properties:

| Name | Value | Description |
| ---- | ----- | ----------- |
| id | integer | The config id. |
| uuid | string | The config uuid. |
| createdAt | string | The date the config was created on. |
| updatedAt | string | The date the config was update at. |
| owner | string | The config owner. |
| ownerUuid | string | The config owner uuid. |
| key | string | The config key. This value is unique. |
| value | mixed | The config value. This value may be an array, object, integer, boolean or string. |
| enabled | boolean | Whether the config is enabled or not. |
| version | integer | The config version. This value is used for optimistic locking. |
| tenant | string | The config tenant uuid. |

### Codes

| Code | Type | Description |
| ---- | ----- | ----------- |
| 200 | application/json | Successful |

### Example

*Request*

__GET__ /configs

```
Accept: application/json
```

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
    "id": 2,
    "uuid": "1547893c-5873-40b5-8c45-e6cd08bee82e",
    "createdAt": "2018-07-18T19:20:18+00:00",
    "updatedAt": "2018-07-18T19:20:18+00:00",
    "owner": "BusinessUnit",
    "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
    "key": "app.registration.individual.owner.uuid",
    "value": "a9d68bf7-5000-49fe-8b00-33dde235b327",
    "enabled": true,
    "version": 1,
    "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
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
