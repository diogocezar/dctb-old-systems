var map;
var baseIcon;
function load() {
  if (GBrowserIsCompatible()) {
	map = new GMap2(document.getElementById("mapag"));
	//map.setCenter(new GLatLng(-23.31293683256248, -51.16779327392578), 12);
	var mapControl = new GMapTypeControl();
	map.addControl(mapControl);
	map.addControl(new GSmallMapControl ());
	baseIcon = new GIcon();
	baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
	baseIcon.iconSize = new GSize(20, 34);
	baseIcon.shadowSize = new GSize(37, 34);
	baseIcon.iconAnchor = new GPoint(9, 34);
	baseIcon.infoWindowAnchor = new GPoint(9, 2);
	baseIcon.infoShadowAnchor = new GPoint(18, 25);
  }
}
var start;
var A;
function marcaPonto(obj,letra,nome,endereco,CidadeUF) {
  var address = endereco + ', ' + CidadeUF;
  var geocoder = new GClientGeocoder();
  if (geocoder) {
	geocoder.getLatLng(
	  address,
	  function(point) {
		if (!point) {
		  //alert(address + " not found");
		} else {
		  map.setCenter(point, 15);
		  var letteredIcon = new GIcon(baseIcon);
		  letteredIcon.image = "http://www.google.com/mapfiles/marker" + letra + ".png";
		  markerOptions = { icon:letteredIcon };
		  A = new GMarker(point, markerOptions);
		  map.addOverlay(A);
		  if(letra=='A')
		  {
			A.openInfoWindowHtml("<strong class='vermelho'>" + nome + "</strong><br>" + endereco + "<br>" + CidadeUF);
		  }
		  start = point;
		  GEvent.addListener(A, "click", function() {
			  A.openInfoWindowHtml("<strong class='vermelho'>" + nome + "</strong><br>" + endereco + "<br>" + CidadeUF);
			});
		}
	  }
	);
  }
}