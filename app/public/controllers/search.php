<?php
// Get the search term from the URL query string
$search_term = $_GET["query"] ?? "";

// Render the gyms_list view with the search results
include "views/partials/gyms_list.php";


