# Config

The DigitalState Authentication microservice configurations registry.

## Table of Contents

- [Configurations](#configurations)

## Configurations

| Name | Type | Description | Example |
| ---- | ---- | ----------- | ------- |
| `app.spa.admin` | string | The admin spa url. | `http://admin.lab.ds` |
| `app.spa.portal` | string | The portal spa url. | `http://portal.lab.ds` |
| `app.spa.portal.oauth.success` | string | The oauth success portal spa url. | `http://portal.lab.ds/oauth/success` |
| `app.registration.individual.owner.type` | string | The default owner type when an individual registers. | `BusinessUnit` |
| `app.registration.individual.owner.uuid` | string | The default owner UUID when an individual registers. | `a9d68bf7-5000-49fe-8b00-33dde235b327` |
| `app.registration.individual.data.github` | string | The template used for identity data when an individual registers through Github. | `{ "email": "%email%", "firstName": "%firstName%", "lastName": "%lastName%" }` |
| `app.registration.individual.data.google` | string | The template used for identity data when an individual registers through Google. | `{ "email": "%email%", "firstName": "%firstName%", "lastName": "%lastName%" }` |
| `app.registration.individual.data.twitter` | string | The template used for identity data when an individual registers through Twitter. | `{ "email": "%email%", "firstName": "%firstName%", "lastName": "%lastName%" }` |
| `app.registration.individual.roles` | array | The default roles array when an individual registers. | `['54d82fc6-8ce7-498e-832f-3598664a9d9d']` |
| `app.registration.individual.enabled` | boolean | The default enabled status when an individual registers. | `true` |
| `app.registration.organization.owner.type` | string | The default owner type when an organization registers. | `BusinessUnit` |
| `app.registration.organization.owner.uuid` | string | The default owner UUID when an organization registers. | `a9d68bf7-5000-49fe-8b00-33dde235b327` |
| `app.registration.organization.data.github` | string | The template used for identity data when an organization registers through Github. | `{ "email": "%email%", "firstName": "%firstName%", "lastName": "%lastName%" }` |
| `app.registration.organization.data.google` | string | The template used for identity data when an organization registers through Google. | `{ "email": "%email%", "firstName": "%firstName%", "lastName": "%lastName%" }` |
| `app.registration.organization.data.twitter` | string | The template used for identity data when an organization registers through Twitter. | `{ "email": "%email%", "firstName": "%firstName%", "lastName": "%lastName%" }` |
| `app.registration.organization.roles` | array | The default roles array when an organization registers. | `['777b96e7-e183-44f7-b7e4-dc0cb7591f74']` |
| `app.registration.organization.enabled` | boolean | The default enabled status when an organization registers. | `true` |
| `app.resetting.email.subject` | string | The subject of the email sent when a user is requesting a password reset. | `Password Reset` |
| `app.resetting.email.body.plain` | string | The plain text body of the email sent when a user is requesting a password reset. | `You have requested...` |
| `app.resetting.email.body.html` | string | The html body of the email sent when a user is requesting a password reset. | `<b>You have requested...</b>` |
