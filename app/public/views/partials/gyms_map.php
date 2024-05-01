
<?= "<div id='map' style='height: 500px;'></div>" ?>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- make script wait for script tag to load -->
<script>
    // dynamically set map view using lat,long from first gym in array
    var lat = <?= $gyms[0]['lat'] ?>;
    var lon = <?=  $gyms[0]['lon']?>;
    var mymap = L.map('map').setView([Number(lat), Number(lon)], 13); // New York's latitude and longitude

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(mymap);

</script>

<?php foreach ($gyms as $gym): ?>
    <script>
        (function () {
            const marker = L.marker([<?= $gym['lat'] ?>, <?= $gym['lon'] ?>]).addTo(mymap);
            marker.bindPopup("<b><?= htmlspecialchars($gym['name']) ?></b><br><?= htmlspecialchars($gym['address']) ?>");
        })()
    </script>
<?php endforeach; ?>
