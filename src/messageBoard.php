<?php
    class MessageBoard {
        private $rooms = [];
        private $users = [];

        public function createRoom($name) {
            if (isset($this->rooms[$name])) {
                return false;
            }
            $this->rooms[$name] = new Room($name);
            return true;
        }

        public function createUser($name) {
            if (isset($this->users[$name])) {
                return false;
            }
            $this->users[$name] = new User($name);
            return true;
        }

        public function postMessage($userName, $roomName, $content) {
            if (!isset($this->users[$userName]) || !isset($this->rooms[$roomName])) {
                return false;
            }
            $user = $this->users[$userName];
            $room = $this->rooms[$roomName];
            if (!$user->canPostMessage($room)) {
                return false;
            }
            $message = new Message($user, $content);
            $room->addMessage($message);
            return true;
        }

        public function getMessages($roomName) {
            if (!isset($this->rooms[$roomName])) {
                return [];
            }
            return $this->rooms[$roomName]->getMessages();
        }
    }

    class Room {
        private $name;
        private $messages = [];

        public function __construct($name) {
            $this->name = $name;
        }

        public function addMessage($message) {
            $this->messages[] = $message;
        }

        public function getMessages() {
            return $this->messages;
        }
    }

    class User {
        private $name;
        private $lastMessageTime = [];

        public function __construct($name) {
            $this->name = $name;
        }

        public function canPostMessage($room) {
            if (!isset($this->lastMessageTime[spl_object_hash($room)])) {
                return true;
            }
            if (time() - $this->lastMessageTime[spl_object_hash($room)] > 24 * 60 * 60) {
                return true;
            }
            return false;
        }

        public function postMessage($room, $content) {
            if (!$this->canPostMessage($room)) {
                return false;
            }
            if (strlen($content) < 2 || strlen($content) > 2048) {
                return false;
            }
            $message = new Message($this, $content);
            $room->addMessage($message);
            $this->lastMessageTime[spl_object_hash($room)] = time();
            return true;
        }
    }

    class Message {
        private $user;
        private $content;

        public function __construct($user, $content) {
            $this->user = $user;
            $this->content = $content;
        }

        public function getUser() {
            return $this->user;
        }

        public function getContent() {
            return $this->content;
        }
    }
?>