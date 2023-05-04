Feature: Message Board
  In order to communicate with others
  As a user
  I need to be able to post messages in rooms

  Scenario: Create and post message
    Given there is a message board
    When I create a room named "general"
    And I create a user named "Alice"
    And I post a message as "Alice" in "general" with content "Hello"
    Then I should see the following messages in "general":
      | user  | content |
      | Alice | Hello   |