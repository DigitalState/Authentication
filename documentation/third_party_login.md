# Third-party Login

The Authentication microservice supports third-party authentication through oAuth. This means a user may opt to login through a preferred third-party instead of going through the normal registration process.

It is recommended to read the [normal login documention](login.md) before reading this documentation.

## Table of Contents

- [Login Flow](#login-flow)
- [Supported Third-parties](#supported-third-parties)
- [Obtaining a JWT token](#obtaining-a-jwt-token)

## Login Flow

On first login, the Authentication microservice will detect a new user has logged in and will be registered accordingly using third-party information.

On subsequent login, the user will simply go through as usual.

## Supported Third-parties

The following third-party authentication methods are currently supported:

- Github
- Google
- Twitter

## Obtaining a JWT token

An authentication endpoint is available for each type of users: [individual](#individual), [organization](#organization) and [staff](#staff).

### Individual

An endpoint is available for individuals who wish to authenticate via a third-party.

#### Request

_Method:_

GET `/oauth/individual/{third-party}/redirect`

#### Response

Generally, a third-party login screen will be presented, followed by a grant screen, to eventually be redirected back to the [configured portal oAuth url](../references/configurations.md).

A one-time usage code is passed along, if the login was successful. This code can then be used to obtain a JWT token from the Authentication microservice.

#### Request

_Method:_

POST `/oauth/individual/{third-party}?code={code}`

_Headers:_

```
Content-Type: application/json
Accept: application/json
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```

### Organization

An endpoint is available for organizations who wish to authenticate via a third-party.

#### Request

_Method:_

GET `/oauth/organization/{third-party}/redirect`

#### Response

Generally, a third-party login screen will be presented, followed by a grant screen, to eventually be redirected back to the [configured portal oAuth url](../references/configurations.md).

A one-time usage code is passed along, if the login was successful. This code can then be used to obtain a JWT token from the Authentication microservice.

#### Request

_Method:_

POST `/oauth/organization/{third-party}?code={code}`

_Headers:_

```
Content-Type: application/json
Accept: application/json
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```

### Staff

An endpoint is available for staff members who wish to authenticate via a third-party.

#### Request

_Method:_

GET `/oauth/staff/{third-party}/redirect`

#### Response

Generally, a third-party login screen will be presented, followed by a grant screen, to eventually be redirected back to the [configured admin oAuth url](../references/configurations.md).

A one-time usage code is passed along, if the login was successful. This code can then be used to obtain a JWT token from the Authentication microservice.

#### Request

_Method:_

POST `/oauth/staff/{third-party}?code={code}`

_Headers:_

```
Content-Type: application/json
Accept: application/json
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```
