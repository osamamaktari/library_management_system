<?php
namespace LibrarySystem;

class SmsNotification implements NotificationInterface {
    public function send($message) {
        
        echo "Sending SMS: " . $message;
    }
}
