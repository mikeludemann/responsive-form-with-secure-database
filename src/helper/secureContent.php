<?php

// Helper functions

function validationContent($data) {

    # XSS - Security helper

    $data = trim($data); // Remove Whitespaces and any other character at start and end of a string
    $data = stripslashes($data); // Remove masking character of a string
    $data = htmlspecialchars($data); // Convert special characters to HTML entities

    return $data;

}

?>