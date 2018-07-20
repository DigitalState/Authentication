# Config

## Table of Contents

- [Get List](#get-list)
- [Get Item](#get-item)
- [Update](#update)

## Get List

This endpoint returns the list of configurations.

### Method

GET `/configs`

### Parameters

#### Query Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| id | integer | Filter configs by the given id. | 1 |
| uuid | string | Filter configs by the given uuid. | 21046af5-26e7-4a05-bfd8-38c0d9aa0302 |
| owner | string | Filter configs by the given owner. | BusinessUnit |
| ownerUuid | string | Filter configs by the given owner uuid. | 5809b2e4-3ab1-4ed5-a419-04e6f3d05959 |
| key | string | Filter configs by the given key. | app.registration.individual.owner.type |
| createdAt[before] | string | Filter configs that were created before the given date. | 2018-07-20T13:19:30.181Z |
| createdAt[after] | string | Filter configs that were created after the given date. | 2018-07-20T13:19:30.181Z |
| updatedAt[before] | string | Filter configs that were updated before the given date. | 2018-07-20T13:19:30.181Z |
| updatedAt[after] | string | Filter configs that were updated after the given date. | 2018-07-20T13:19:30.181Z |
| enabled | boolean | Filter configs by given enabled status. | true |
| page | integer | The current page in the pagination. __Default: 1.__ | 1 |
| limit | integer | The number of items per page. __Default: 10.__ | 25 |

### Response

A JSON array of objects. Each object represents a config and contains the following properties:

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
| 200 | application/json | Successful request. |

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

## GET Item

This endpoint returns a specific configuration.

### Method

GET `/configs/{uuid}`

### Parameters

#### Path Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| uuid | string | The uuid of the config. __Required.__ | 21046af5-26e7-4a05-bfd8-38c0d9aa0302 |

### Response

A JSON object that represents a config and contains the following properties:

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
| 200 | application/json | Successful request. |
| 404 | application/json | Config with given uuid does not exist. |

### Example

*Request*

__GET__ /configs/20346d3f-5ef2-4aec-a644-210c5e71d662

```
Accept: application/json
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
