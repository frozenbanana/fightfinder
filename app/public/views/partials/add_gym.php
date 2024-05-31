<form hx-post="/gyms/add">
  <h1>Add Gym</h1>
  <div>
  <label for="name">Gym Name:</label>
  <input type="text" id="name" name="name" >
  </div>
        <div>

  <label for="address">Address:</label>
  <input type="text" id="address" name="address">
  </div>
        <div>

  <label for="description">description:</label>
  <input type="text" id="description" name="description">
  </div>

  <h2>Add Sessions</h2>
  <!-- Dynamically add inputs for each session -->
  <div id="sessions">
   </div>
 
  <button type="button" onclick="addSession()">Add Session</button>

  <button type="submit">Save Gym</button>

</form>


<template id="session-template" hidden>
    <div>
        <div>
        <label for="session_name">Session Name:</label>
        <input type="text" id="session_name" name="session_name[]">
        </div>
        <div>
        <label for="session_styles">Session Style:</label>
        <select id="session_styles" name="session_style[]">
            <?php foreach ($styles as $style) : ?>
                <option value="<?=$style['id']?>"><?=$style['name']?></option>
            <?php endforeach; ?>
        </div>
        <div>
        <label for="start_times">Start Time:</label>
        <input type="time" id="start_times" name="start_times[]">
        </div>
        <div>
        <label for="end_time">End Time:</label>
        <input type="time" id="end_times" name="end_times[]">
        </div>
        <div>
        <label for="days">Day:</label>
        <select id="days" name="days[]">
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
            <option value="sunday">Sunday</option>
        </select>
        </div>
    </div>
</template>

<script>
    const template = document.getElementById('session-template');
    const sessions = document.getElementById('sessions');

    function addSession() {
        const clone = template.content.cloneNode(true);
        clone.hidden = false;
        sessions.appendChild(clone);
    }

    addSession();
    const addSessionButton = document.getElementById('add-session');

    const inputName = document.getElementById('name');
    inputName.addEventListener("focusout", (evt) => {
        console.log(evt);
    });
</script>
