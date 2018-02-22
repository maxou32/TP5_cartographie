<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Markers avec context-Menu simple</title>
<meta name="Author" content="NoSmoking">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css">
<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<style>
html, body {
  margin: 0;
  padding: 0;
  font: 1em/1.5 Verdana, sans-serif;
}
h1, h2, h3 {
  margin-bottom: .5em;
  color: #069;
}
#main {
  margin: 0 auto;
  max-width: 60em;
  border-top: 1px solid transparent;
}
.section {
  margin: 0 2em 1em;
}
#cde {
  position: relative;
  margin: 1em auto;
}
#carte {
  height: 37em;
  margin: 0 auto;
  max-width: 50em;
  border: 5px solid #FFF;
  font-size: 1em;
  box-shadow: 0 2px 4px 2px #CCC;
}
.leaflet-popup-content-wrapper {
  border-radius: .25em;
  font-family: Verdana;
  font-size: .8em;
}
.leaflet-popup-content {
  text-align: center;
}
.leaflet-popup-content input {
  margin: .5em auto;
  font-family: inherit;
}
#context_menu {
  display: none;
  position: absolute;
  padding: .125em;
  border: 1px solid #abc;
  background: #fff;
  box-shadow: 2px 2px 5px #ccc;
}
#context_menu ul {
  margin: 0;
  padding: 0;
  font-size: .8em;
  list-style: none;
  cursor: pointer;
}
#context_menu ul li {
  padding: .25em 1em;
  line-height: 1.5em;
  background: #fff;  
}
/* separator */
#context_menu ul li:empty {
  margin: .125em 0;
  padding: 0 1em 1px;    
  background: #abc;
}
#context_menu ul li[id]:hover {
  background: #cde;
}
#context_menu ul hr {
  margin: 0;
  padding: 0;
}
</style>
</head>
<body>
<div id="main">
  <div class="header">
    <h1>Markers avec context-Menu simple</h1>
  </div>
  <div class="section">
    <p>Un clic sur la carte ajoute un marqueur à la carte.</p>
    <p>Un clic droit sur le marqueur fait apparaître un « context-menu ».</p>
  </div>
  <div class="section">
    <div id="carte"></div>
  </div>
</div>
<!-- le context-menu -->
<div id="context_menu">
  <ul>
    <li id="cm_debut">Définir comme Début</li>
    <li id="cm_fin">Définir comme Fin</li>  
    <li></li>  
    <li id="cm_supprime">Supprimer</li>
  </ul>  
</div>
<script>
var oMap;
var lgMarkers;
 
// création de la carte
oMap = L.map('carte', {
    center: [ 46.8, 1.7 ],
    zoom: 6
});
oMap.addLayer( L.tileLayer(
    'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
    {
      attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }
  ));
// création et ajout du LayerGroup
lgMarkers = new L.LayerGroup();
oMap.addLayer(lgMarkers);
 
// fonction sur click oMap
oMap.on('click', function (e) {
    addMarker( e);
});
// efface context-menu
oMap.on('mousedown', function (e) {
    hideContextMenu();
});
 
 
function addMarker(e) {
  // création du marker
  var m = L.marker([e.latlng.lat, e.latlng.lng]);
  // attache le marker au layerGroup
  m.addTo(lgMarkers);
  // sur le click droit du marker le sous menu s'ouvre
  m.on('contextmenu', function( e){
    var me_ = this;
    // position pour affichage
    var pos = {
      x: e.originalEvent.pageX,
      y: e.originalEvent.pageY
    };
    // affiche le context-menu
    showContextMenu( me_, pos);
  });    
}
function hideContextMenu(){
  document.getElementById('context_menu').style.display = 'none';
}
function showContextMenu( marker, pos){
  // positionne le context menu
  var oElem = document.getElementById('context_menu');  
  oElem.style.left = pos.x +'px';
  oElem.style.top = pos.y +'px';
  oElem.style.display = 'block';
  //affecte les fonctions
  document.getElementById('cm_supprime').onclick =  function(){
    lgMarkers.removeLayer( marker);
  };
  document.getElementById('cm_debut').onclick =  function(){
    console.log( 'Deb : ', marker.getLatLng());
    alert( 'Deb : '+ marker.getLatLng().toString());    
  };  
  document.getElementById('cm_fin').onclick =  function(){
    console.log( 'Fin : ', marker.getLatLng());
    alert( 'Fin : ' + marker.getLatLng().toString());    
  };  
}
// pour fermer le contextMenu
document.addEventListener('click', function(){
    hideContextMenu();
}, false);
document.addEventListener('keydown', function (e) {
    var key = e.keyCode;
    if (key === 27) {
        hideContextMenu();
    }
});
</script>
</body>
</html>