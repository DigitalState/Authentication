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

The admin spa url.

## app.spa.portal

The portal spa url.

## app.registration.individual.owner.type

The default owner type when an individual registers.

## app.registration.individual.owner.uuid

The default owner UUID when an individual registers.

## app.registration.individual.data.github

The template used for identity data when an individual registers through Github.

## app.registration.individual.data.google

The template used for identity data when an individual registers through Google.

## app.registration.individual.data.twitter

The template used for identity data when an individual registers through Twitter.

## app.registration.individual.roles

The default roles array when an individual registers.

## app.registration.individual.enabled

The default enabled status when an individual registers.

__options:__ `true`, `false`

## app.registration.organization.owner.type

The default owner type when an organization registers.

## app.registration.organization.owner.uuid

The default owner UUID when an organization registers.

## app.registration.organization.data.github

The template used for identity data when an organization registers through Github.

## app.registration.organization.data.google

The template used for identity data when an organization registers through Google.

## app.registration.organization.data.twitter

The template used for identity data when an organization registers through Twitter.

## app.registration.organization.roles

The default roles array when an organization registers.

## app.registration.organization.enabled

The default enabled status when an organization registers.

__options:__ `true`, `false`

## app.resetting.email.subject

The subject of the email sent when a user is requesting a password reset.

## app.resetting.email.body.plain

The plain text body of the email sent when a user is requesting a password reset.

## app.resetting.email.body.html

The html body of the email sent when a user is requesting a password reset.
