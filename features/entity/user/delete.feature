@app @entity @user @delete
Feature: Delete users
  In order to delete users
  As an admin identity
  I should be able to send api requests related to users

  Background:
    Given I am authenticated as an "admin" identity

  @createSchema @loadFixtures @dropSchema
  Scenario: Delete a user
    When I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/users/ae0aebf7-8bae-45af-853b-fc01ac3b9e20"
    Then the response status code should be 204
    And the response should be empty
