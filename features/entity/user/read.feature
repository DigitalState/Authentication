@app @entity @user @read
Feature: Read users
  In order to read users
  As a system identity
  I should be able to send api requests related to users

  Background:
    Given I am authenticated as the "system" identity

  @createSchema @loadFixtures @dropSchema
  Scenario: Read a user
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "id" should exist
    And the JSON node "id" should be equal to the number 1
    And the JSON node "uuid" should exist
    And the JSON node "uuid" should be equal to the string "f9df049a-fe95-405f-ba7c-734f1a0ce558"
    And the JSON node "createdAt" should exist
    And the JSON node "updatedAt" should exist
    And the JSON node "deletedAt" should exist
    And the JSON node "deletedAt" should be null
    And the JSON node "owner" should exist
    And the JSON node "owner" should be equal to the string "BusinessUnit"
    And the JSON node "ownerUuid" should exist
    And the JSON node "ownerUuid" should be equal to the string "e3048503-19e2-4f68-9346-0398bb196748"
    And the JSON node "enabled" should exist
    And the JSON node "enabled" should be true
    And the JSON node "version" should exist
    And the JSON node "version" should be equal to the number 1
