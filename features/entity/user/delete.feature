@app @entity @user @delete
Feature: Delete users
  In order to delete users
  As a system identity
  I should be able to send api requests related to users

  Background:
    Given I am authenticated as the "system" identity

  @createSchema @loadFixtures
  Scenario: Delete a user
    When I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 204
    And the response should be empty

  Scenario: Read the deleted user
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 404
    And the header "Content-Type" should be equal to "application/problem+json; charset=utf-8"

  @dropSchema
  Scenario: Delete a deleted user
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users/f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 404
    And the header "Content-Type" should be equal to "application/problem+json; charset=utf-8"
