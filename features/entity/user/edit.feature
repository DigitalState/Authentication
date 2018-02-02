@app @entity @user @edit
Feature: Edit users
  In order to edit users
  As a system identity
  I should be able to send api requests related to users

  Background:
    Given I am authenticated as the "system" identity

  @createSchema @loadFixtures
  Scenario: Edit a user
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "PUT" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558" with body:
    """
    {
      "enabled": false
    }
    """
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "enabled" should be false

  Scenario: Confirm the edited user
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "enabled" should be false

  Scenario: Edit a user's read-only properties
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "PUT" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558" with body:
    """
    {
      "id": 9999,
      "uuid": "d4100ac8-cb3f-4d5d-9f19-b81dd208dc85",
      "createdAt":"2000-01-01T12:00:00+00:00",
      "updatedAt":"2000-01-01T12:00:00+00:00",
      "deletedAt":"2000-01-01T12:00:00+00:00"
    }
    """
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "id" should be equal to the number 1
    And the JSON node "uuid" should be equal to the string "f9df049a-fe95-405f-ba7c-734f1a0ce558"
    And the JSON node "createdAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "updatedAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "deletedAt" should not contain "2000-01-01T12:00:00+00:00"

  Scenario: Confirm the unedited user
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "id" should be equal to the number 1
    And the JSON node "uuid" should be equal to the string "f9df049a-fe95-405f-ba7c-734f1a0ce558"
    And the JSON node "createdAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "updatedAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "deletedAt" should not contain "2000-01-01T12:00:00+00:00"

  @dropSchema
  Scenario: Edit a user with an invalid optimistic lock
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "PUT" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558" with body:
    """
    {
      "enabled": true,
      "version": 1
    }
    """
    Then the response status code should be 500
    And the header "Content-Type" should be equal to "application/problem+json; charset=utf-8"
    And the response should be in JSON
