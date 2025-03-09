<script>
  function initMap() {
    var mapCenter = {
      lat: 12.8797,
      lng: 121.7740
    };

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: mapCenter
    });

    var locations = [{
        name: "Donation Center 1",
        lat: 14.5995,
        lng: 120.9842
      },
      {
        name: "Donation Center 2",
        lat: 10.3157,
        lng: 123.8854
      },
      {
        name: "Donation Center 3",
        lat: 7.1907,
        lng: 125.4553
      }
    ];

    locations.forEach(function(location) {
      var marker = new google.maps.Marker({
        position: {
          lat: location.lat,
          lng: location.lng
        },
        map: map,
        title: location.name
      });

      var infoWindow = new google.maps.InfoWindow({
        content: `<strong>${location.name}</strong>`
      });

      marker.addListener("click", function() {
        infoWindow.open(map, marker);
      });
    });
  }
</script>

<!-- Load Google Maps API (Replace YOUR_API_KEY) -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAR7aOTRzu3UunfoUOLnEvxiQM6LCo4lbg&callback=initMap" async defer></script>