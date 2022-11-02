<?php

namespace App\Model\Entity;

class Exception extends Exception {
  protected $details;

  public function __construct($details) {
      $this->details = $details;
      parent::__construct();
  }

  public function __toString() {
    return 'I am an exception. Here are the deets: ' . $this->details;
  }
}