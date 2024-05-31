<?php

try_session_start();

if (isset($_SESSION['flash_message'])) {
    $flash_message = display_flash_message();
    echo "<article><aside><p>$flash_message</p><aside></article>";
}



