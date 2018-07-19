# Authentication

The Authentication microservice provide centralized login cpabilities for "users" which have a assoication with a Identity.

Authentication preforms the following functions:

1. Login / Logout
1. JWT Issueing / Management
1. User Management
1. Password Recovery

The Authentication microservice managers "users" which are the accounts that are used to login as a Individual, Organization, and Staffer.  

No personal data about an identity is or should be stored in the Authentication microservice.

## Screenshots

The following are screenshots from the Portal and Admin UI

### Admin

![Admin Login](./docs/resources/Admin-Login.png)

---

![Admin User List](./docs/resources/Admin-Users-List.png)

---

![Admin User View](./docs/resources/Admin-Users-View.png)

---

### Portal (Individuals)

![Portal Individual Login](./docs/resources/Individual-Login.png)

---

![Portal Individual Signup](./docs/resources/Individual-Signup.png)

[![Build Status](https://travis-ci.org/DigitalState/Authentication.svg?branch=develop)](https://travis-ci.org/DigitalState/Authentication)
[![Coverage Status](https://coveralls.io/repos/github/DigitalState/Authentication/badge.svg?branch=develop)](https://coveralls.io/github/DigitalState/Authentication?branch=develop)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DigitalState/Authentication/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/DigitalState/Authentication/?branch=develop)

## Table of Contents

- [Documentation](#documentation)
- [Contributing](#contributing)
- [Credits](#credits)

## Documentation

1. [LDAP/Active Directory Integration](./docs/ldap.md)
1. [Social Media Login Integration](./docs/social_media.md)
1. Swap Authentication microservice with a third-party authentication system (Cloud, Gluu, Keycloak, etc)
1. JWT Sctructure and Details

Further documentation can be found in the [Documentation Repository](https://github.com/DigitalState/Documentation)

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Credits

This work has been developed by DigitalState.io
