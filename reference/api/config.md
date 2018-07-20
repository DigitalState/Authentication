# Config

The config api endpoints allow authorized users to read and modify application configurations.

The complete list of configs available can be found [here](../config.md).

## Table of Contents

- [Get List](#get-list)
- [Get Item](#get-item)
- [Edit Item](#edit-item)

## Get List

This endpoint returns the list of configurations.

### Method

GET `/configs`

### Parameters

#### Query Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| id | integer | Filter configs by the given id. | `1` |
| uuid | string | Filter configs by the given uuid. | `20346d3f-5ef2-4aec-a644-210c5e71d662` |
| owner | string | Filter configs by the given owner. | `BusinessUnit` |
| ownerUuid | string | Filter configs by the given owner uuid. | `c11c546e-bd01-47cf-97da-e25388357b5a` |
| key | string | Filter configs by the given key. | `app.registration.individual.owner.type` |
| createdAt[before] | string | Filter configs that were created before the given date. | `2018-07-20T13:19:30.181Z` |
| createdAt[after] | string | Filter configs that were created after the given date. | `2018-07-20T13:19:30.181Z` |
| updatedAt[before] | string | Filter configs that were updated before the given date. | `2018-07-20T13:19:30.181Z` |
| updatedAt[after] | string | Filter configs that were updated after the given date. | `2018-07-20T13:19:30.181Z` |
| enabled | boolean | Filter configs by given enabled status. | `true` |
| page | integer | The current page in the pagination. Default: `1`. | `1` |
| limit | integer | The number of items per page. Default: `10`. | `25` |

### Response

#### 200 OK

A JSON array of objects. Each object contains the following properties:

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

### Example

#### Request

*Method*

__GET__ /configs

*Headers*

```yaml
Accept: application/json
```

#### Response

*Code*

`200 Successful`

*Body*

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
| uuid | string | The uuid of the config. __Required.__ | `20346d3f-5ef2-4aec-a644-210c5e71d662` |

### Response

#### 200 OK

A JSON object that contains the following properties:

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

#### 404 OK

The config with the given uuid does not exist.

### Example

#### Request

*Method*

__GET__ `/configs/20346d3f-5ef2-4aec-a644-210c5e71d662`

*Headers*

```yaml
Accept: application/json
```

#### Response

*Code*

`200 Successful`

*Body*

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

## Edit Item

This endpoint edits a specific configuration.

### Method

PUT `/configs/{uuid}`

### Parameters

#### Path Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| uuid | string | The uuid of the config. __Required.__ | `20346d3f-5ef2-4aec-a644-210c5e71d662` |

#### Body

A JSON object that contains the following properties:

| Name | Value | Description | Example |
| ---- | ----- | ----------- | ------- |
| uuid | string | The config uuid. __Optional.__ | `d8fdec77-7816-45e6-a2d8-e75d38c5637a` |
| owner | string | The config owner. __Required.__ | `BusinessUnit` |
| ownerUuid | string | The config owner uuid. __Required.__ | `c11c546e-bd01-47cf-97da-e25388357b5a` |
| key | string | The config key. This value is unique. __Required.__ | `app.registration.individual.owner.type` |
| value | mixed | The config value. This value may be an array, object, integer, boolean or string. __Required.__ | `BusinessUnit` |
| enabled | boolean | Whether the config is enabled or not. __Required.__ | true |
| version | integer | The config version. This value is used for optimistic locking. __Required.__ | `1` |

### Response

#### 201 Created

A JSON object that contains the following properties:

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

#### 400 Bad Request

There were some validation errors.

### Example

#### Request

*Method*

__PUT__ `/configs/20346d3f-5ef2-4aec-a644-210c5e71d662`

*Headers*

```yaml
Accept: application/json
```

*Body*

```json
{
  "enabled": false,
  "version": 1
}
```

#### Response

*Code*

`201 Created`

*Body*

```json
{
  "id": 1,
  "uuid": "20346d3f-5ef2-4aec-a644-210c5e71d662",
  "createdAt": "2018-07-18T19:20:18+00:00",
  "updatedAt": "2018-07-19T19:21:29+00:00",
  "owner": "BusinessUnit",
  "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
  "key": "app.registration.individual.owner.type",
  "value": "BusinessUnit",
  "enabled": false,
  "version": 2,
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
}
```
