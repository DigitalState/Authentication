# Config

The DigitalState Authentication microservice configurations registry.

## Table of Contents

- App
  - Spa
    - [Admin](#appspaadmin)
    - [Portal](#appspaportal)
  - Registration
    - Individual
      - Owner
        - [Type](#appregistrationindividualownertype)
        - [UUID](#appregistrationindividualowneruuid)
      - Data
        - [Github](#appregistrationindividualdatagithub)
        - [Google](#appregistrationindividualdatagoogle)
        - [Twitter](#appregistrationindividualdatatwitter)
      - [Roles](#appregistrationindividualroles)
      - [Enabled](#appregistrationindividualenabled)
    - Organization
      - Owner
        - [Type](#appregistrationorganizationownertype)
        - [UUID](#appregistrationorganizationowneruuid)
      - Data
        - [Github](#appregistrationorganizationdatagithub)
        - [Google](#appregistrationorganizationdatagoogle)
        - [Twitter](#appregistrationorganizationdatatwitter)
      - [Roles](#appregistrationorganizationroles)
      - [Enabled](#appregistrationorganizationenabled)
  - Resetting
    - Email
      - [Subject](#appresettingemailsubject)
      - Body
        - [Plain](#appresettingemailbodyplain)
        - [Html](#appresettingemailbodyhtml)

## app.spa.admin

__description:__ The admin spa url.

## app.spa.portal

__description:__ The portal spa url.

## app.registration.individual.owner.type

__description:__ The default owner type when an individual registers.

## app.registration.individual.owner.uuid

__description:__ The default owner UUID when an individual registers.

## app.registration.individual.data.github

__description:__ The template used for identity data when an individual registers through Github.

## app.registration.individual.data.google

__Description:__ The template used for identity data when an individual registers through Google.

## app.registration.individual.data.twitter

__Description:__ The template used for identity data when an individual registers through Twitter.

## app.registration.individual.roles

__description:__ The default roles array when an individual registers.

## app.registration.individual.enabled

__description:__ The default enabled status when an individual registers.

__options:__ `true`, `false`

## app.registration.organization.owner.type

__description:__ The default owner type when an organization registers.

## app.registration.organization.owner.uuid

__description:__ The default owner UUID when an organization registers.

## app.registration.organization.data.github

__description:__ The template used for identity data when an organization registers through Github.

## app.registration.organization.data.google

__Description:__ The template used for identity data when an organization registers through Google.

## app.registration.organization.data.twitter

__Description:__ The template used for identity data when an organization registers through Twitter.

## app.registration.organization.roles

__description:__ The default roles array when an organization registers.

## app.registration.organization.enabled

__description:__ The default enabled status when an organization registers.

__options:__ `true`, `false`

## app.resetting.email.subject

__description:__ The subject of the email sent when a user is requesting a password reset.

## app.resetting.email.body.plain

__description:__ The plain text body of the email sent when a user is requesting a password reset.

## app.resetting.email.body.html

__description:__ The html body of the email sent when a user is requesting a password reset.
