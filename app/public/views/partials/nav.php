<?php require_once "router.php" ?>

<nav>
    <ul>
        <?php
        $is_auth = is_authenticated();
        // skapa strukturlänkar med array $nav_links 
        $current_uri = $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        foreach ($nav_links as $url => $link_item) {
            if ($is_auth && $link_item['hide_if_auth']) continue;
            $class = str_contains($current_uri, $url) ? "class=active" : "";
            $html = "<li><a href='$url' $class>";
            $html .= $link_item['name'];
            $html .= "</a></li>";
            echo $html;
        }
        ?>
        <?= render_logged_in_navbar(); ?>
    </ul>
</nav>
