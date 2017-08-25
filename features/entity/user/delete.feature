@app @entity @user @delete
Feature: Delete users
  In order to delete users
  As a system identity
  I should be able to send api requests related to users

  Background:
    Given I am authenticated as a "system" identity

  @createSchema @loadFixtures @dropSchema
  Scenario: Delete a user
    When I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/users/cd5ca384-436a-44f5-b5bc-0aeed1a3fe02"
    Then the response status code should be 204
    And the response should be empty
