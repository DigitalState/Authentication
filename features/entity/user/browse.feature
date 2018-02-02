@app @entity @user @browse
Feature: Browse users
  In order to browse users
  As a system identity
  I should be able to send api requests related to users

  Background:
    Given I am authenticated as the "system" identity

  @createSchema @loadFixtures
  Scenario: Browse all users
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse paginated users
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?page=1&limit=1"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific id
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?id=1"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with specific ids
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?id[0]=1"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 2 items

  Scenario: Browse users with a specific uuid
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?uuid=f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with specific uuids
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?uuid[0]=f9df049a-fe95-405f-ba7c-734f1a0ce558"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific owner
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?owner=BusinessUnit"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with specific owners
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?owner[0]=BusinessUnit"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific owner uuid
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?ownerUuid=83bf8f26-7181-4bed-92f3-3ce5e4c286d7"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with specific owner uuids
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?ownerUuid[0]=83bf8f26-7181-4bed-92f3-3ce5e4c286d7"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific before created date
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?createdAt[before]=2050-01-01"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific after created date
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?createdAt[after]=2000-01-01"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific before updated date
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?updatedAt[before]=2050-01-01"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific after updated date
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?updatedAt[after]=2000-01-01"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific before deleted date
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?deletedAt[before]=2050-01-01"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users with a specific after deleted date
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?deletedAt[after]=2000-01-01"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users that are enabled
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?enabled=true"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users that are disabled
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?enabled=false"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by id asc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[id]=asc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by id desc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[id]=desc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by created date asc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[createdAt]=asc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by created date desc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[createdAt]=desc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by updated date asc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[updatedAt]=asc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by updated date desc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[updatedAt]=desc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by deleted date asc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[deletedAt]=asc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by deleted date desc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[deletedAt]=desc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  Scenario: Browse users ordered by owner asc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[owner]=asc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items

  @dropSchema
  Scenario: Browse users ordered by owner desc
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/users?order[owner]=desc"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the response should be in JSON
    And the response should be a collection
    And the response collection should count 1 items
