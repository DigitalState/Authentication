@app @entity @user @edit
Feature: Edit users
  In order to edit users
  As a system identity
  I should be able to send api requests related to users

  Background:
    Given I am authenticated as a "system" identity

  @createSchema @loadFixtures
  Scenario: Edit a user
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "PUT" request to "/users/cd5ca384-436a-44f5-b5bc-0aeed1a3fe02" with body:
    """
    {
      "ownerUuid": "8cbacf9f-949e-4deb-b3fb-75f75c3dcb6c",
      "enabled": false
    }
    """
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "ownerUuid" should be equal to the string "8cbacf9f-949e-4deb-b3fb-75f75c3dcb6c"
    And the JSON node "enabled" should be false

  Scenario: Confirm the edited user
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users/cd5ca384-436a-44f5-b5bc-0aeed1a3fe02"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "ownerUuid" should be equal to the string "8cbacf9f-949e-4deb-b3fb-75f75c3dcb6c"
    And the JSON node "enabled" should be false

  Scenario: Edit a user's read-only properties
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "PUT" request to "/users/cd5ca384-436a-44f5-b5bc-0aeed1a3fe02" with body:
    """
    {
      "id": 9999,
      "uuid": "ae0aebf7-8bae-45af-853b-fc01ac3b9e20",
      "createdAt":"2000-01-01T12:00:00+00:00",
      "updatedAt":"2000-01-01T12:00:00+00:00",
      "deletedAt":"2000-01-01T12:00:00+00:00"
    }
    """
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "id" should be equal to the number 1
    And the JSON node "uuid" should be equal to the string "cd5ca384-436a-44f5-b5bc-0aeed1a3fe02"
    And the JSON node "createdAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "updatedAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "deletedAt" should not contain "2000-01-01T12:00:00+00:00"

  Scenario: Confirm the unedited user
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users/cd5ca384-436a-44f5-b5bc-0aeed1a3fe02"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the JSON node "id" should be equal to the number 1
    And the JSON node "uuid" should be equal to the string "cd5ca384-436a-44f5-b5bc-0aeed1a3fe02"
    And the JSON node "createdAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "updatedAt" should not contain "2000-01-01T12:00:00+00:00"
    And the JSON node "deletedAt" should not contain "2000-01-01T12:00:00+00:00"

  @dropSchema
  Scenario: Edit a user with an invalid optimistic lock
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "PUT" request to "/users/cd5ca384-436a-44f5-b5bc-0aeed1a3fe02" with body:
    """
    {
      "enabled": true,
      "version": 1
    }
    """
    Then the response status code should be 500
    And the header "Content-Type" should be equal to "application/problem+json; charset=utf-8"
    And the response should be in JSON
