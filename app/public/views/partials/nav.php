<?php require_once "router.php" ?>

<nav>
    <ul>
        <?php
        // skapa strukturlänkar med array $nav_links 
        $current_uri = $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        foreach ($nav_links as $key => $value) {
            // med ternary operator: tilldela ett värde, kontroll ? värde om sant : värde om falskt
            $class = str_contains($current_uri, $key) ? "class=active" : "";
            $html = "<li><a href='$key' $class>";
            $html .= $value;
            $html .= "</a></li>";
            echo $html;
        }
        ?>
        <?= render_logged_in_navbar(); ?>
    </ul>
</nav>