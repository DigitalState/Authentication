# Login

## Table of Contents

- [Preface](#preface)
- [Obtaining a JWT token](#obtaining-a-jwt-token)
- [Structure of a JWT token](#structure-of-a-jwt-token)

## Preface

The majority of endpoints available on the DigitalState Api are protected by a JWT-based firewall. This means a JWT token must be provided along side every HTTP requests for them to be processed.

When issuing an HTTP request, the JWT token is to be passed via the `Authorization` HTTP header, otherwise a `401` HTTP response will be returned. For example:

#### Request

_Method:_

GET `/users`

_Headers:_

```
Authorization: eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]
Accept: application/json
```

#### Response

_Body:_

```
[
  {
    "uuid": "42182fd0-9665-4ba4-9f5c-ec290e23814e",
    "createdAt": "2018-10-11T18:35:45+00:00",
    "username": "morgan@individual.ds",
    "email": "morgan@individual.ds",
    "version": 2
  }
]
```

## Obtaining a JWT token

The Authentication microservice is charge of issuing JWT tokens to users wishing to login.

It is possible to obtain a JWT Token by one of two methods: providing a username and password combination to the auth endpoint or login in through a supported oAuth third-party authenticator.

### Username/password authentication

Then Authentication microservice allows you to authenticate yourself using the proper credentials, if you are already a registered user. For documentation on how to register, consult the [registration](registration.md) page.

An authentication endpoint is available for each type of users: individual, organization, staff and anonymous.

### Individual

An endpoint is available for individuals who wish to authenticate as their user.

#### Request

_Method:_

POST `/auth/individual`

_Headers:_

```
Content-Type: application/x-www-form-urlencoded
Accept: application/json
```

_Body:_

```
username: morgan@individual.ds
password: morgan
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```

### Organization

An endpoint is available for organizations who wish to authenticate as their organization.

#### Request

_Method:_

POST `/auth/organization`

_Headers:_

```
Content-Type: application/x-www-form-urlencoded
Accept: application/json
```

_Body:_

```
username: acme@organization.ds
password: acme
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```

### Staff

An endpoint is available for staff members who wish to authenticate as their user.

#### Request

_Method:_

POST `/auth/staff`

_Headers:_

```
Content-Type: application/x-www-form-urlencoded
Accept: application/json
```

_Body:_

```
username: manager@staff.ds
password: manager
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```

### Anonymous

As mentioned previously, the majority of endpoints available on the DigitalState Api are protected by a JWT-based firewall. This includes endpoints that would normally appear to be public at first glance, for example: the list of available services located on the Services microservice or general informational pages located on the CMS microservice.

A JWT token of type `anonymous` is required even when requesting the most basic of information from a microservice api. This convention has been adopted for a more streamlined approach to security where everything passes through the JWT firewall in place.

An endpoint is available for anonymous users who wish to anonymously authenticate.

#### Request

_Method:_

POST `/auth/anonymous`

_Headers:_

```
Content-Type: application/x-www-form-urlencoded
Accept: application/json
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```

### Third-party authentication

The Authentication microservice also supports third-party authentication through oAuth.

This means a user may opt to login through a preferred third-party instead of going through the normal registration process.

On first login, the Authentication microservice will detect a new user has logged in and will be registered accordingly using third-party information. On subsequent login, the user will go through as normal.

The following third-party authentication methods are currently supported:

- Github
- Google
- Twitter

### Individual

An endpoint is available for individuals who wish to authenticate via a third-party.

#### Request

_Method:_

GET `/oauth/individual/{third-party}/redirect`

#### Response

Generally, a third-party login screen will be presented, followed by a grant screen, to eventually be redirected back to the [configured oAuth url](../references/configurations).

A code is passed to the configured oAuth url, which can be used to obtain a JWT token from the Authentication microservice.

#### Request

_Method:_

POST `/oauth/organization/github`

_Headers:_

```
Content-Type: application/json
Accept: application/json
```

_Body:_

```
{
  "code": "129085890324893"
}
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

Generally, a third-party login screen will be presented, followed by a grant screen, to eventually be redirected back to the [configured oAuth url](../references/configurations).

A code is passed to the configured oAuth url, which can be used to obtain a JWT token from the Authentication microservice.

#### Request

_Method:_

POST `/oauth/organization/github`

_Headers:_

```
Content-Type: application/json
Accept: application/json
```

_Body:_

```
{
  "code": "129085890324893"
}
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

Generally, a third-party login screen will be presented, followed by a grant screen, to eventually be redirected back to the [configured oAuth url](../references/configurations).

A code is passed to the configured oAuth url, which can be used to obtain a JWT token from the Authentication microservice.

#### Request

_Method:_

POST `/oauth/organization/github`

_Headers:_

```
Content-Type: application/json
Accept: application/json
```

_Body:_

```
{
  "code": "129085890324893"
}
```

#### Response

_Body:_

```
{
  "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xF[...].Ds34hb80MfOZfViFx0wI[...]"
}
```

## Structure of a JWT token

The JWT token is structured into 3 sections: the header, the payload and finally the signature.

### Header

The header contains meta data about the token, typically includes the algorithm and type.

```
{
  "alg": "RS256"
}
```

### Payload

The payload contains information about the user, its claims, issue and expiration timestamps.

```
{
  "roles": [
    "ROLE_USER"
  ],
  "username": "morgan@individual.ds",
  "identity": {
    "roles": [],
    "type": "Individual",
    "uuid": "eb9ad709-2e81-40c5-80c8-446aa88e44fe"
  },
  "uuid": "a81979ea-5a9a-46cb-bca8-a373396b3e69",
  "tenant": "d928b020-94f6-4928-a510-04fc49d5a174",
  "iat": 1532016212,
  "exp": 1532102612
}
```

### Signature

The signature is used to verify the token authenticity and assuring it hasn't been tampered with.

```
************************
```
