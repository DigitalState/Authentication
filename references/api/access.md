# Access

The access api endpoints allow authorized users to read, modify and delete access cards.

For more information about the architecture and core concepts of access cards, you may consult the [Security component documentation](https://github.com/DigitalState/Core/blob/develop/documentation/security/acl.md).

## Table of Contents

- [Get List](#get-list)
- [Get Item](#get-item)
- [Add Item](#add-item)
- [Edit Item](#edit-item)
- [Delete Item](#delete-item)

## Get List

This endpoint returns the list of access cards.

### Method

GET `/accesses`

### Parameters

#### Query Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| id | integer | Filter access cards by the given id. __Optional.__ | `id=1`<br><br>`id[]=1&id[]=2` |
| uuid | string | Filter access cards by the given uuid. __Optional.__ | `uuid=d3e8fa50-c802-4dc2-8792-93e80d3fb888`<br><br>`uuid[]=d3e8fa50-c802-4dc2-8792-93e80d3fb888&uuid[]=8e2bca9c-dd33-4c66-9d2f-99b37d39edfe` |
| owner | string | Filter access cards by the given owner. __Optional.__ | `owner=BusinessUnit`<br><br>`owner[]=BusinessUnit&owner[]=Staff` |
| ownerUuid | string | Filter access cards by the given owner uuid. __Optional.__ | `ownerUuid=c11c546e-bd01-47cf-97da-e25388357b5a`<br><br>`ownerUuid[]=c11c546e-bd01-47cf-97da-e25388357b5a&ownerUuid[]=a9d68bf7-5000-49fe-8b00-33dde235b327` |
| assignee | string | Filter access cards by the given assignee. __Optional.__ | `assignee=Staff`<br><br>`assignee[]=Individual&assignee[]=Organization` |
| assigneeUuid | string | Filter access cards by the given assignee uuid. __Optional.__ | `assigneeUuid=f06dd49d-8ad4-437a-beee-387b834ee217`<br><br>`assigneeUuid[]=f06dd49d-8ad4-437a-beee-387b834ee217&assigneeUuid[]=3e64bbd1-4d00-47e7-a35e-92691f5a6018` |
| createdAt[before] | string | Filter access cards that were created before the given date. __Optional.__ | `createdAt[before]=2018-07-20T13:19:30.181Z` |
| createdAt[after] | string | Filter access cards that were created after the given date. __Optional.__ | `createdAt[after]2018-07-20T13:19:30.181Z` |
| updatedAt[before] | string | Filter access cards that were updated before the given date. __Optional.__ | `updatedAt[before]=2018-07-20T13:19:30.181Z` |
| updatedAt[after] | string | Filter access cards that were updated after the given date. __Optional.__ | `updatedAt[after]=2018-07-20T13:19:30.181Z` |
| page | integer | The current page in the pagination. __Optional.__ Default: `1`. | `page=2` |
| limit | integer | The number of items per page. __Optional.__ Default: `10`. | `limit=25` |

### Response

#### 200 OK

A JSON array of objects. Each object contains the following properties:

| Name | Type | Description |
| ---- | ---- | ----------- |
| id | integer | The access card id. |
| uuid | string | The access card uuid. |
| createdAt | string | The date the access card was created on. |
| updatedAt | string | The date the access card was update at. |
| owner | string | The access card owner. |
| ownerUuid | string | The access card owner uuid. |
| assignee | string | The access card assignee. |
| assigneeUuid | string | The access card assignee uuid. |
| permissions | array | The access card granted permissions. |
| version | integer | The access card version. This value is used for optimistic locking. |
| tenant | string | The access card tenant uuid. |

### Example

#### Request

*Method:*

__GET__ /accesses

*Headers:*

```yaml
Accept: application/json
```

#### Response

*Code:*

`200 OK`

*Body:*

```json
[
  {
    "id": 1,
    "uuid": "d3e8fa50-c802-4dc2-8792-93e80d3fb888",
    "createdAt": "2018-07-31T14:57:10+00:00",
    "updatedAt": "2018-07-31T14:57:10+00:00",
    "owner": "BusinessUnit",
    "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
    "assignee": "Role",
    "assigneeUuid": "f06dd49d-8ad4-437a-beee-387b834ee217",
    "permissions": [
      {
        "scope": "owner",
        "entity": "BusinessUnit",
        "entityUuid": "a9d68bf7-5000-49fe-8b00-33dde235b327",
        "key": "user",
        "attributes": ["EDIT", "ADD", "DELETE"]
      }
    ],
    "version": 1,
    "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
  },
  {
    "id": 2,
    "uuid": "8e2bca9c-dd33-4c66-9d2f-99b37d39edfe",
    "createdAt": "2018-07-31T14:57:10+00:00",
    "updatedAt": "2018-07-31T14:57:10+00:00",
    "owner": "BusinessUnit",
    "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
    "assignee": "Role",
    "assigneeUuid": "3e64bbd1-4d00-47e7-a35e-92691f5a6018",
    "permissions": [
      {
        "scope": "owner",
        "entity": "BusinessUnit",
        "entityUuid": "a9d68bf7-5000-49fe-8b00-33dde235b327",
        "key": "user",
        "attributes": ["BROWSE", "READ"]
      }
    ],
    "version": 1,
    "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
  }
]
```

## GET Item

This endpoint returns a specific access card.

### Method

GET `/accesses/{uuid}`

### Parameters

#### Path Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| uuid | string | The uuid of the access card. __Required.__ | `d3e8fa50-c802-4dc2-8792-93e80d3fb888` |

### Response

#### 200 OK

A JSON object that contains the following properties:

| Name | Type | Description |
| ---- | ---- | ----------- |
| id | integer | The access card id. |
| uuid | string | The access card uuid. |
| createdAt | string | The date the access card was created on. |
| updatedAt | string | The date the access card was update at. |
| owner | string | The access card owner. |
| ownerUuid | string | The access card owner uuid. |
| assignee | string | The access card assignee. |
| assigneeUuid | string | The access card assignee uuid. |
| permissions | array | The access card granted permissions. |
| version | integer | The access card version. This value is used for optimistic locking. |
| tenant | string | The access card tenant uuid. |

#### 404 Not Found

The access card with the given uuid does not exist.

### Example

#### Request

*Method:*

__GET__ `/accesses/d3e8fa50-c802-4dc2-8792-93e80d3fb888`

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
  "id": 1,
  "uuid": "d3e8fa50-c802-4dc2-8792-93e80d3fb888",
  "createdAt": "2018-07-31T14:57:10+00:00",
  "updatedAt": "2018-07-31T14:57:10+00:00",
  "owner": "BusinessUnit",
  "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
  "assignee": "Role",
  "assigneeUuid": "f06dd49d-8ad4-437a-beee-387b834ee217",
  "permissions": [
    {
      "scope": "owner",
      "entity": "BusinessUnit",
      "entityUuid": "a9d68bf7-5000-49fe-8b00-33dde235b327",
      "key": "user",
      "attributes": ["EDIT", "ADD", "DELETE"]
    }
  ],
  "version": 1,
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
}
```

## Add Item

This endpoint adds an access card to the list.

### Method

POST `/accesses`

### Parameters

#### Body

A JSON object that contains the following properties:

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| uuid | string | The access card uuid. __Optional.__ Default: auto-generated. | `56079ab0-0f24-42fa-aa34-9c9d775935d0` |
| owner | string | The access card owner. __Required.__ | `BusinessUnit` |
| ownerUuid | string | The access card owner uuid. __Optional.__ Default: `null`. | `c11c546e-bd01-47cf-97da-e25388357b5a` |
| assignee | string | The access card assignee. __Required.__ | `BusinessUnit` |
| assigneeUuid | string | The access card assignee uuid. __Optional.__ Default: `null`. | `5ab54dd5-56ed-4e96-bd8b-1d60ab668a75` |
| permissions | array | The access card granted permissions. __Optional.__ Default: `[]`. |
| version | integer | The access card version. This value is used for optimistic locking. __Required.__ | `1` |

### Response

#### 200 OK

A JSON object that contains the following properties:

| Name | Type | Description |
| ---- | ---- | ----------- |
| id | integer | The access card id. |
| uuid | string | The access card uuid. |
| createdAt | string | The date the access card was created on. |
| updatedAt | string | The date the access card was update at. |
| owner | string | The access card owner. |
| ownerUuid | string | The access card owner uuid. |
| assignee | string | The access card assignee. |
| assigneeUuid | string | The access card assignee uuid. |
| permissions | array | The access card granted permissions. |
| version | integer | The config version. This value is used for optimistic locking. |
| tenant | string | The config tenant uuid. |

#### 400 Bad Request

There were some validation errors.

### Example

#### Request

*Method:*

__POST__ `/accesses`

*Headers:*

```yaml
Accept: application/json
```

*Body:*

```json
{
  "owner": "BusinessUnit",
  "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
  "assignee": "Anonymous",
  "assigneeUuid": null,
  "permissions": [
    {
      "scope": "owner",
      "entity": "BusinessUnit",
      "entityUuid": null,
      "key": "registration",
      "attributes": ["ADD"]
    }
  ],
  "version": 1
}
```

#### Response

*Code:*

`200 OK`

*Body:*

```json
{
  "id": 1,
  "uuid": "56079ab0-0f24-42fa-aa34-9c9d775935d0",
  "createdAt": "2018-07-19T12:08:30+00:00",
  "updatedAt": "2018-07-19T12:08:30+00:00",
  "owner": "BusinessUnit",
  "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
  "assignee": "Anonymous",
  "assigneeUuid": null,
  "permissions": [
    {
      "scope": "owner",
      "entity": "BusinessUnit",
      "entityUuid": null,
      "key": "registration",
      "attributes": ["ADD"]
    }
  ],
  "version": 1,
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
}
```

## Edit Item

This endpoint edits a specific access card.

### Method

PUT `/accesses/{uuid}`

### Parameters

#### Path Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| uuid | string | The uuid of the access card. __Required.__ | `d3e8fa50-c802-4dc2-8792-93e80d3fb888` |

#### Body

A JSON object that contains the following properties:

| Name | Type | Description | Example |
| ---- | ----- | ----------- | ------- |
| uuid | string | The access card uuid. __Optional.__ Default: auto-generated. | `d3e8fa50-c802-4dc2-8792-93e80d3fb888` |
| owner | string | The access card owner. __Required.__ | `BusinessUnit` |
| ownerUuid | string | The access card owner uuid. __Optional.__ Default: `null`. | `c11c546e-bd01-47cf-97da-e25388357b5a` |
| assignee | string | The access card assignee. __Required.__ | `BusinessUnit` |
| assigneeUuid | string | The access card assignee uuid. __Optional.__ Default: `null`. | `f06dd49d-8ad4-437a-beee-387b834ee217` |
| permissions | array | The access card granted permissions. __Optional.__ Default: `[]`. |
| version | integer | The access card version. This value is used for optimistic locking. __Required.__ | `1` |

### Response

#### 200 OK

A JSON object that contains the following properties:

| Name | Type | Description |
| ---- | ---- | ----------- |
| id | integer | The access card id. |
| uuid | string | The access card uuid. |
| createdAt | string | The date the access card was created on. |
| updatedAt | string | The date the access card was update at. |
| owner | string | The access card owner. |
| ownerUuid | string | The access card owner uuid. |
| assignee | string | The access card assignee. |
| assigneeUuid | string | The access card assignee uuid. |
| permissions | array | The access card granted permissions. |
| version | integer | The config version. This value is used for optimistic locking. |
| tenant | string | The config tenant uuid. |

#### 400 Bad Request

There were some validation errors.

### Example

#### Request

*Method:*

__PUT__ `/accesses/d3e8fa50-c802-4dc2-8792-93e80d3fb888`

*Headers:*

```yaml
Accept: application/json
```

*Body:*

```json
{
  "permissions": [
    {
      "scope": "owner",
      "entity": "BusinessUnit",
      "entityUuid": null,
      "key": "user",
      "attributes": ["BROWSE", "READ", "EDIT", "ADD", "DELETE"]
    }
  ],
  "version": 1
}
```

#### Response

*Code:*

`200 OK`

*Body:*

```json
{
  "id": 1,
  "uuid": "d3e8fa50-c802-4dc2-8792-93e80d3fb888",
  "createdAt": "2018-07-31T14:57:10+00:00",
  "updatedAt": "2018-08-01T12:30:15+00:00",
  "owner": "BusinessUnit",
  "ownerUuid": "c11c546e-bd01-47cf-97da-e25388357b5a",
  "assignee": "Role",
  "assigneeUuid": "f06dd49d-8ad4-437a-beee-387b834ee217",
  "permissions": [
    {
      "scope": "owner",
      "entity": "BusinessUnit",
      "entityUuid": null,
      "key": "user",
      "attributes": ["BROWSE", "READ", "EDIT", "ADD", "DELETE"]
    }
  ],
  "version": 1,
  "tenant": "e5a2120d-6bf7-4c58-a900-bac1e55e986b"
}
```

## Delete Item

This endpoint deletes a specific access card from the list.

### Method

DELETE `/accesses/{uuid}`

### Parameters

#### Path Parameters

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| uuid | string | The uuid of the access card. __Required.__ | `d3e8fa50-c802-4dc2-8792-93e80d3fb888` |

### Response

#### 204 No Content

The request was successful and returns no content.

### Example

#### Request

*Method:*

__DELETE__ `/accesses/d3e8fa50-c802-4dc2-8792-93e80d3fb888`

#### Response

*Code:*

`204 No Content`

*Body:*

```

```

