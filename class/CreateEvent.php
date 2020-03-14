<?php
require 'connect.php';

class CreateEvent {
  
  private $event_name = [];
  private $details    = [];
  private $event_date = [];
  private $created    = [];
  private $modified   = [];
  private $user_id    = [];

  function __construct() {
    $this->event_name = $event_name;
    $this->details = $details;
    $this->event_date = $event_date;
    $this->created = $created;
    $this->modified = $modified;
    $this->user_id = $user_id;
  }

  public function setEvent() {
    $sql = 'INSERT INTO `events` (`event_name`, `details`, `event_date`, `created`, `modified`, `user_id`) VALUES ($event_name, $details, $event_date, current_timestamp(), null, $user_ud)';

    
  }
}

$new_event = new CreateEvent();

$new_event->setEvent();
