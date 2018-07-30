# Config

The DigitalState Authentication microservice configurations registry.

## Table of Contents

- [Configurations](#configurations)

## Configurations

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| `app.spa.admin` | string | The admin spa url. | `http://admin.lab.ds` |
| `app.spa.portal` | string | The portal spa url. | `http://portal.lab.ds` |
| `app.registration.individual.owner.type` | string | The default owner type when an individual registers. | `` |
| `app.registration.individual.owner.uuid` | string | The default owner UUID when an individual registers. | `` |
| `app.registration.individual.data.github` | string | The template used for identity data when an individual registers through Github. | `` |
| `app.registration.individual.data.google` | string | The template used for identity data when an individual registers through Google. | `` |
| `app.registration.individual.data.twitter` | string | The template used for identity data when an individual registers through Twitter. | `` |
| `app.registration.individual.roles` | string | The default roles array when an individual registers. | `` |
| `app.registration.individual.enabled` | boolean | The default enabled status when an individual registers. | `true` |
| `app.registration.organization.owner.type` | string | The default owner type when an organization registers. | `` |
| `app.registration.organization.owner.uuid` | string | The default owner UUID when an organization registers. | `` |
| `app.registration.organization.data.github` | string | The template used for identity data when an organization registers through Github. | `` |
| `app.registration.organization.data.google` | string | The template used for identity data when an organization registers through Google. | `` |
| `app.registration.organization.data.twitter` | string | The template used for identity data when an organization registers through Twitter. | `` |
| `app.registration.organization.roles` | string | The default roles array when an organization registers. | `` |
| `app.registration.organization.enabled` | boolean | The default enabled status when an organization registers. | `true` |
| `app.resetting.email.subject` | string | The subject of the email sent when a user is requesting a password reset. | `` |
| `app.resetting.email.body.plain` | string | The plain text body of the email sent when a user is requesting a password reset. | `` |
| `app.resetting.email.body.html` | string | The html body of the email sent when a user is requesting a password reset. | `` |
