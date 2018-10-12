# Login

Then Authentication microservice allows registered users to authenticate themselves using their designated credentials.

For documentation on how to register, consult the [registration documentation](registration.md).

## Table of Contents

- [Preface](#preface)
- [Obtaining a JWT token](#obtaining-a-jwt-token)
- [JWT Structure](#jwt-structure)

## Preface

The majority of endpoints available on the DigitalState Api are protected by a JWT-based firewall. This means a JWT token must be provided along side every HTTP requests for them to be processed, otherwise a `401` HTTP response will be returned.

When issuing an HTTP request, the JWT token is to be passed via the `Authorization` HTTP header. For example:

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

## JWT Structure

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
