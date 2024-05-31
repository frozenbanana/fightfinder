<div id="gyms_list" class='gyms-grid'>
<?php $gyms = is_authenticated() ? get_gyms_with_users($search_term) : get_gyms($search_term); ?>
<?php include "gyms_map.php"; ?>
<hr>
<?php foreach ($gyms as $gym) : ?>
    <?= "<div class='gym-card'>\n" ?>
    <?= "<h2>{$gym['name']}</h2>\n" ?>
    <?= "<p>{$gym['address']}</p>\n" ?>
    <?= "<p>{$gym['description']}</p>\n" ?>
    <?= is_authenticated() ? "<p>Added by {$gym['username']}</p>\n" : "" ?>
    <details>
        <!-- Use htmx to make the form submit to /session and swap results to schedule_container-->
        <summary hx-get="/sessions?gym_id=<?= $gym['id']?>" hx-target="next .schedule_container" hx-swap="outerHTML">Schedule</summary>
        <div class="schedule_container">
            <!-- Schedule will be rendered here -->
        </div>

        
    </details>
    <?= "</div>\n" ?>
<?php endforeach; ?>  
</div>


