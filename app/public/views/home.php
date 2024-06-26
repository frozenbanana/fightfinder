<?php
try_session_start();
$title = "Home";
?>
<?php include "views/partials/head.php"; ?>
<?php include "views/partials/header.php"; ?>
<main>
    <?php include "views/partials/nav.php"; ?>
    <?php include "partials/flash_message.php"; ?>
    <!-- Search form -->
    <!-- Use htmx to make the form submit to /search and swap results to gyms_list-->
    <form id="search-form" hx-get="/search" hx-target="#gyms_list" hx-swap="outerHTML">
        <h2>Find gyms</h2>
        <input type="text" name="query" id="query" placeholder="Search gyms">
        <button type="submit">Search</button>
    </form>
    <?php
    $search_term = "";
    include "views/partials/gyms_list.php";
    ?>
</main>
<?php include "views/partials/footer.php"; ?>
