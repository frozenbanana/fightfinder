<!-- Render table with the sessions
 with columns day, start_time, end_time, style, is_free_for_all -->
<table>
    <tr><th>Day</th><th>Type</th><th>Start Time</th><th>End Time</th><th>Style</th><th>Is Free</th></tr>
 <?php foreach($sessions as $session) : ?>
     <tr>
        <td><?= $session['day']?></td>
        <td><?= $session['type'] ?? "Standard" ?></td>
        <td><?= $session['start_time']?></td>
        <td><?= $session['end_time']?></td>
        <td><?= $session['name']?></td>
        <td><?= $session['is_free_for_all'] ? "Yes" : "No"?></td>
     </tr>
<?php endforeach ?>
 </table>