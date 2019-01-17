@api @config @delete
Feature: Delete configs

  Background:
    Given I am authenticated as the "system@system.ds" user from the tenant "b6ac25fe-3cd6-4100-a054-6bba2fc9ef18"

  Scenario: Delete a config
    When I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/configs/dc58c698-5af1-4f2c-afe5-43002a15646d"
    Then the response status code should be 405
    And the header "Content-Type" should be equal to "application/json"
    And the response should be in JSON

