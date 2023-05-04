<?php
// features/bootstrap/FeatureContext.php
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;

class FeatureContext implements Context {
    private $messageBoard;

    /**
     * @Given there is a message board
     */
    public function thereIsAMessageBoard() {
        $this->messageBoard = new MessageBoard();
    }

    /**
     * @When I create a room named :name
     */
    public function iCreateARoomNamed($name) {
        $this->messageBoard->createRoom($name);
    }

    /**
     * @When I create a user named :name
     */
    public function iCreateAUserNamed($name) {
        $this->messageBoard->createUser($name);
    }

    /**
     * @When I post a message as :userName in :roomName with content :content
     */
    public function iPostAMessageAsInWithContent($userName, $roomName, $content) {
        $this->messageBoard->postMessage($userName, $roomName, $content);
    }

    /**
     * @Then I should see the following messages in :roomName:
     */
    public function iShouldSeeTheFollowingMessagesIn($roomName, TableNode $table) {
        $messages = $this->messageBoard->getMessages($roomName);
        foreach ($table->getHash() as $i => $row) {
            if ($messages[$i]->getUser()->getName() !== $row['user']) {
                throw new Exception('Invalid user');
            }
            if ($messages[$i]->getContent() !== $row['content']) {
                throw new Exception('Invalid content');
            }
        }
    }
}
?>