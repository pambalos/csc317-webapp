function initMap() {
  // The location 
  var parking_lot = {lat: 37.723810, lng: -122.482034};
  // The map, centered at location
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 15, center: parking_lot});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: parking_lot, map: map});
}