# JWT

## Table of Contents

- [Structure](#structure)

## Structure

*Header*

```
{
  "alg": "RS256"
}
```

*Payload*
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

*Signature*
```
************************
```
