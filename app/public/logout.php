<?php
include_once "_includes/functions.php";
// Starta upp sessionen igen
session_start();

// Logga ut genom att förstöra sessionen
session_destroy();

// skicka användaren till home
set_flash_message_and_redirect_to("Du är nu utloggad", "home");

