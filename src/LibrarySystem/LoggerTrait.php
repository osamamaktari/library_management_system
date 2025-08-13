<?php
namespace LibrarySystem;

trait LoggerTrait {
    public function log($message) {
       
        echo "Log: " . $message . "\n";
    }
}
