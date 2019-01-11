@api @security @firewall @access @deny
Feature: Deny access to non-authenticated users to access endpoints

  @upMigrations @loadFixtures
  Scenario: Browse accesses
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/accesses"
    Then the response status code should be 401
    And the header "Content-Type" should be equal to "application/json"
    And the response should be in JSON

  Scenario: Read an access
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/accesses/060d2507-60c3-4594-b5f6-062d330c6bdf"
    Then the response status code should be 401
    And the header "Content-Type" should be equal to "application/json"
    And the response should be in JSON

  Scenario: Add an access
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "POST" request to "/accesses" with body:
    """
    {}
    """
    Then the response status code should be 401
    And the header "Content-Type" should be equal to "application/json"
    And the response should be in JSON

  Scenario: Edit an access
    When I add "Accept" header equal to "application/json"
    And I add "Content-Type" header equal to "application/json"
    And I send a "PUT" request to "/accesses/060d2507-60c3-4594-b5f6-062d330c6bdf" with body:
    """
    {}
    """
    Then the response status code should be 401
    And the header "Content-Type" should be equal to "application/json"
    And the response should be in JSON

  @downMigrations
  Scenario: Delete an access
    When I add "Accept" header equal to "application/json"
    And I send a "DELETE" request to "/accesses/060d2507-60c3-4594-b5f6-062d330c6bdf"
    Then the response status code should be 401
    And the header "Content-Type" should be equal to "application/json"
    And the response should be in JSON