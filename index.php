<!DOCTYPE html>
<html>
<head>
	<title>Главная</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="css/leaflet.css">
    <link rel="stylesheet" href="css/qgis2web.css"><link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/leaflet-search.css">
    <link rel="stylesheet" href="css/filter.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/leaflet-control-geocoder.Geocoder.css">
	<style type="text/css">
		body {
			font-family: 'Montserrat', Arial, sans-serif;
			background-color: #fff;
			overflow-x: hidden;
		}
		#map {
            width: 100%;
            height: 852px;
        }
        a {
			color: #000;
			text-decoration: none;
			transition-duration: 0.3s;
		}
		a:hover {
			color: #c4c4c4;
		}
		h1 {
			font-size: 64px;
		}
		.white {
			background-color: #fff;
		}
		.yellow {
			background-color: #EDE8AB;
		}
		.blue {
			background-color: #EDE8AB;
			padding: 10px;
			margin-bottom: 10px;
			border-radius: 5px;
		}
	</style>
</head>
<body>
	<?php require 'header.php' ?>

	<div class="container mt-5">
		<div class="row py-5 white">
			<div class="col-5">
				<h1><b>Из таблиц <br>в карты</b></h1> <br>
				<p>Сайт был разработан с целью упростить мониторинг предпринимательской деятельности. Сайт поможет не только мониторингу, но и самим предпринимателем и потребителям.</p>	
			</div>
			<div class="col-6 text-center">
				<img src="img/map.png" width="50%">
			</div>
		</div>
	</div>
	<div class="container-fluid yellow">
		<div class="row py-5 ">
			<div class="col-5 mx-auto">
				<img src="img/mapa.png" width="100%">
			</div>
			<div class="col-7 mx-auto text-end">
				<h1><b>Чем сайт помогает предпринимателям?</b></h1>
				<p>Карта сайта включает в себя плотность предпринимательской <br> деятельности, также и их критерии. </p> <br>
				<h1><b>Выбирайте свой район</b></h1> <br>
				<p>Каждый район индивидуален. <br>
					На карте каждый район имеет свои критерии.</p>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row py-5 white">
			<div class="col-6 mx-auto">
				<h1><b>Возможности потребителя на сайте </b></h1> <br>
				<p>Потребитель может оставить заявку на недостаток какого-то предприятия в его районе. </p> <br>
			</div>
			<div class="col-6 text-center">
				<img src="img/circles.png" width="80%">
			</div>
		</div>
		<div class="row mb-4">
			<h1 class="text-center"><b>Перейти к району</b></h1>
		</div>
	</div>


    <div id="map">
        </div>
        <script src="js/qgis2web_expressions.js"></script>
        <script src="js/leaflet.js"></script>
        <script src="js/leaflet.rotatedMarker.js"></script>
        <script src="js/leaflet.pattern.js"></script>
        <script src="js/leaflet-hash.js"></script>
        <script src="js/Autolinker.min.js"></script>
        <script src="js/rbush.min.js"></script>
        <script src="js/labelgun.min.js"></script>
        <script src="js/labels.js"></script>
        <script src="js/leaflet-control-geocoder.Geocoder.js"></script>
        <script src="js/leaflet-search.js"></script>
        <script src="js/tailDT.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/wNumb.js"></script>
        <script src="data/1000_0.js"></script>
        <script>
        var highlightLayer;
        function highlightFeature(e) {
            highlightLayer = e.target;

            if (e.target.feature.geometry.type === 'LineString') {
              highlightLayer.setStyle({
                color: '#ffff00',
              });
            } else {
              highlightLayer.setStyle({
                fillColor: '#ffff00',
                fillOpacity: 1
              });
            }
        }
        var map = L.map('map', {
            zoomControl:true, maxZoom:28, minZoom:1
        }).fitBounds([[50.323725814314116,89.70612758935819],[75.51915994756062,175.32524225800492]]);
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');
        var autolinker = new Autolinker({truncate: {length: 30, location: 'smart'}});
        var bounds_group = new L.featureGroup([]);
        function setBounds() {
        }
        function pop_1000_0(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Район:'] !== null ? autolinker.link(feature.properties['Район:'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Кол-во предприятий:</th>\
                        <td>' + (feature.properties['Кол-во предприятий:'] !== null ? autolinker.link(feature.properties['Кол-во предприятий:'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Численность насления:</th>\
                        <td>' + (feature.properties['Численность насления:'] !== null ? autolinker.link(feature.properties['Численность насления:'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Плотность(МСП/Кол-во чел.):</th>\
                        <td>' + (feature.properties['Плотность(МСП/Кол-во чел.):'] !== null ? autolinker.link(feature.properties['Плотность(МСП/Кол-во чел.):'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Кол-во МСП/1000 чел.:</th>\
                        <td>' + (feature.properties['Кол-во МСП/1000 чел.:'] !== null ? autolinker.link(feature.properties['Кол-во МСП/1000 чел.:'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Шкала плотности:</th>\
                        <td>' + (feature.properties['Шкала плотности:'] !== null ? autolinker.link(feature.properties['Шкала плотности:'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Шкала МСП/1000 чел.:</th>\
                        <td>' + (feature.properties['Шкала МСП/1000 чел.:'] !== null ? autolinker.link(feature.properties['Шкала МСП/1000 чел.:'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td><a href="hangalassky/index.php">Подробнее</a></td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_1000_0_0(feature) {
            switch(String(feature.properties['Шкала МСП/1000 чел.:'])) {
                case '1':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(43,131,186,1.0)',
                interactive: true,
            }
                    break;
                case '2':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(116,183,174,1.0)',
                interactive: true,
            }
                    break;
                case '3':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(183,226,168,1.0)',
                interactive: true,
            }
                    break;
                case '4':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(231,246,184,1.0)',
                interactive: true,
            }
                    break;
                case '5':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(255,232,164,1.0)',
                interactive: true,
            }
                    break;
                case '6':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(254,186,110,1.0)',
                interactive: true,
            }
                    break;
                case '7':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(237,110,67,1.0)',
                interactive: true,
            }
                    break;
                case '8':
                    return {
                pane: 'pane_1000_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(215,25,28,1.0)',
                interactive: true,
            }
                    break;
            }
        }
        map.createPane('pane_1000_0');
        map.getPane('pane_1000_0').style.zIndex = 400;
        map.getPane('pane_1000_0').style['mix-blend-mode'] = 'normal';
        var layer_1000_0 = new L.geoJson(json_1000_0, {
            attribution: '',
            interactive: true,
            dataVar: 'json_1000_0',
            layerName: 'layer_1000_0',
            pane: 'pane_1000_0',
            onEachFeature: pop_1000_0,
            style: style_1000_0_0,
        });
        bounds_group.addLayer(layer_1000_0);
        map.addLayer(layer_1000_0);
        var osmGeocoder = new L.Control.Geocoder({
            collapsed: true,
            position: 'topleft',
            text: 'Search',
            title: 'Testing'
        }).addTo(map);
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
        .className += ' fa fa-search';
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
        .title += 'Search for a place';
        var baseMaps = {};
        L.control.layers(baseMaps,{'Кол-во МСП/1000 чел.<br /><table><tr><td style="text-align: center;"><img src="legend/1000_0_200.png" /></td><td><20</td></tr><tr><td style="text-align: center;"><img src="legend/1000_0_20251.png" /></td><td>20-25</td></tr><tr><td style="text-align: center;"><img src="legend/1000_0_26302.png" /></td><td>26-30</td></tr><tr><td style="text-align: center;"><img src="legend/1000_0_31353.png" /></td><td>31-35</td></tr><tr><td style="text-align: center;"><img src="legend/1000_0_36404.png" /></td><td>36-40</td></tr><tr><td style="text-align: center;"><img src="legend/1000_0_40455.png" /></td><td>40-45</td></tr><tr><td style="text-align: center;"><img src="legend/1000_0_46506.png" /></td><td>46-50</td></tr><tr><td style="text-align: center;"><img src="legend/1000_0_507.png" /></td><td>>50</td></tr></table>': layer_1000_0,},{collapsed:false}).addTo(map);
        setBounds();
        var i = 0;
        layer_1000_0.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['Район:'] !== null?String('<div style="color: #000000; font-size: 10pt; font-family: \'MS Shell Dlg 2\', sans-serif;">' + layer.feature.properties['Район:']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_1000_0'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        map.addControl(new L.Control.Search({
            layer: layer_1000_0,
            initial: false,
            hideMarkerOnCollapse: true,
            propertyName: 'Район:'}));
        document.getElementsByClassName('search-button')[0].className +=
         ' fa fa-binoculars';
        var mapDiv = document.getElementById('map');
        var row = document.createElement('div');
        row.className="row";
        row.id="all";
        row.style.height = "100%";
        var col1 = document.createElement('div');
        col1.className="col9";
        col1.id = "mapWindow";
        col1.style.height = "99%";
        col1.style.width = "80%";
        col1.style.display = "inline-block";
        var col2 = document.createElement('div');
        col2.className="col3";
        col2.id = "menu";
        col2.style.display = "inline-block";
        mapDiv.parentNode.insertBefore(row, mapDiv);
        document.getElementById("all").appendChild(col1);
        document.getElementById("all").appendChild(col2);
        col1.appendChild(mapDiv)
        var Filters = {"Шкала МСП/1000 чел.:": "int","Шкала плотности:": "int","Район:": "str"};
        function filterFunc() {
          map.eachLayer(function(lyr){
          if ("options" in lyr && "dataVar" in lyr["options"]){
            features = this[lyr["options"]["dataVar"]].features.slice(0);
            try{
              for (key in Filters){
                keyS = key.replace(/[^a-zA-Z0-9_]/g, "")
                if (Filters[key] == "str" || Filters[key] == "bool"){
                  var selection = [];
                  var options = document.getElementById("sel_" + keyS).options
                  for (var i=0; i < options.length; i++) {
                    if (options[i].selected) selection.push(options[i].value);
                  }
                    try{
                      if (key in features[0].properties){
                        for (i = features.length - 1;
                          i >= 0; --i){
                          if (selection.indexOf(
                          features[i].properties[key])<0
                          && selection.length>0) {
                          features.splice(i,1);
                          }
                        }
                      }
                    } catch(err){
                  }
                }
                if (Filters[key] == "int"){
                  sliderVals =  document.getElementById(
                    "div_" + keyS).noUiSlider.get();
                  try{
                    if (key in features[0].properties){
                    for (i = features.length - 1; i >= 0; --i){
                      if (parseInt(features[i].properties[key])
                          < sliderVals[0]
                          || parseInt(features[i].properties[key])
                          > sliderVals[1]){
                            features.splice(i,1);
                          }
                        }
                      }
                    } catch(err){
                    }
                  }
                if (Filters[key] == "real"){
                  sliderVals =  document.getElementById(
                    "div_" + keyS).noUiSlider.get();
                  try{
                    if (key in features[0].properties){
                    for (i = features.length - 1; i >= 0; --i){
                      if (features[i].properties[key]
                          < sliderVals[0]
                          || features[i].properties[key]
                          > sliderVals[1]){
                            features.splice(i,1);
                          }
                        }
                      }
                    } catch(err){
                    }
                  }
                if (Filters[key] == "date"
                  || Filters[key] == "datetime"
                  || Filters[key] == "time"){
                  try{
                    if (key in features[0].properties){
                      HTMLkey = key.replace(/[&\/\\#,+()$~%.'":*?<>{} ]/g, '');
                      startdate = document.getElementById("dat_" +
                        HTMLkey + "_date1").value.replace(" ", "T");
                      enddate = document.getElementById("dat_" +
                        HTMLkey + "_date2").value.replace(" ", "T");
                      for (i = features.length - 1; i >= 0; --i){
                        if (features[i].properties[key] < startdate
                          || features[i].properties[key] > enddate){
                          features.splice(i,1);
                        }
                      }
                    }
                  } catch(err){
                  }
                }
              }
            } catch(err){
            }
          this[lyr["options"]["layerName"]].clearLayers();
          this[lyr["options"]["layerName"]].addData(features);
        var i = 0;
        layer_1000_0.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['Район:'] !== null?String('<div style="color: #000000; font-size: 10pt; font-family: \'MS Shell Dlg 2\', sans-serif;">' + layer.feature.properties['Район:']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_1000_0'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
          }
          })
        }
            document.getElementById("menu").appendChild(
                document.createElement("div"));
            var div_1000 = document.createElement("div");
            div_1000.id = "div_1000";
            div_1000.className = "slider";
            document.getElementById("menu").appendChild(div_1000);
            var lab_1000 = document.createElement('div');
            lab_1000.innerHTML  = 'Шкала МСП/1000 чел.:: <span id="val_1000"></span>';
            lab_1000.className = 'filterlabel';
            document.getElementById("menu").appendChild(lab_1000);
            var reset_1000 = document.createElement('div');
            reset_1000.innerHTML = 'clear filter';
            reset_1000.className = 'filterlabel';
            lab_1000.className = 'filterlabel';
            reset_1000.onclick = function() {
                sel_1000.noUiSlider.reset();
            };
            document.getElementById("menu").appendChild(reset_1000);
            var sel_1000 = document.getElementById('div_1000');
            noUiSlider.create(sel_1000, {
                connect: true,
                start: [1, 8],
                step: 1,
                format: wNumb({
                    decimals: 0,
                    }),
                range: {
                min: 1,
                max: 8
                }
            });
            sel_1000.noUiSlider.on('update', function (values) {
            filterVals =[];
            for (value in values){
            filterVals.push(parseInt(value))
            }
            val_1000 = document.getElementById('val_1000');
            val_1000.innerHTML = values.join(' - ');
                filterFunc()
            });
            document.getElementById("menu").appendChild(
                document.createElement("div"));
            var div_ = document.createElement("div");
            div_.id = "div_";
            div_.className = "slider";
            document.getElementById("menu").appendChild(div_);
            var lab_ = document.createElement('div');
            lab_.innerHTML  = 'Шкала плотности:: <span id="val_"></span>';
            lab_.className = 'filterlabel';
            document.getElementById("menu").appendChild(lab_);
            var reset_ = document.createElement('div');
            reset_.innerHTML = 'clear filter';
            reset_.className = 'filterlabel';
            lab_.className = 'filterlabel';
            reset_.onclick = function() {
                sel_.noUiSlider.reset();
            };
            document.getElementById("menu").appendChild(reset_);
            var sel_ = document.getElementById('div_');
            noUiSlider.create(sel_, {
                connect: true,
                start: [1, 5],
                step: 1,
                format: wNumb({
                    decimals: 0,
                    }),
                range: {
                min: 1,
                max: 5
                }
            });
            sel_.noUiSlider.on('update', function (values) {
            filterVals =[];
            for (value in values){
            filterVals.push(parseInt(value))
            }
            val_ = document.getElementById('val_');
            val_.innerHTML = values.join(' - ');
                filterFunc()
            });
            document.getElementById("menu").appendChild(
                document.createElement("div"));
            var div_ = document.createElement('div');
            div_.id = "div_";
            div_.className= "filterselect";
            document.getElementById("menu").appendChild(div_);
            sel_ = document.createElement('select');
            sel_.multiple = true;
            sel_.size = 10;
            sel_.id = "sel_";
            var _options_str = "<option value='' unselected></option>";
            sel_.onchange = function(){filterFunc()};
            _options_str  += '<option value="Абыйский">Абыйский</option>';
            _options_str  += '<option value="Алданский">Алданский</option>';
            _options_str  += '<option value="Аллаиховский">Аллаиховский</option>';
            _options_str  += '<option value="Амгинский">Амгинский</option>';
            _options_str  += '<option value="Анабарский">Анабарский</option>';
            _options_str  += '<option value="Булунский">Булунский</option>';
            _options_str  += '<option value="Верхневилюйский">Верхневилюйский</option>';
            _options_str  += '<option value="Верхнеколымский">Верхнеколымский</option>';
            _options_str  += '<option value="Верхоянский">Верхоянский</option>';
            _options_str  += '<option value="Вилюйский">Вилюйский</option>';
            _options_str  += '<option value="Горный">Горный</option>';
            _options_str  += '<option value="Жатай">Жатай</option>';
            _options_str  += '<option value="Жиганский">Жиганский</option>';
            _options_str  += '<option value="Кобяйский">Кобяйский</option>';
            _options_str  += '<option value="Ленский">Ленский</option>';
            _options_str  += '<option value="Мегино-Кангаласский">Мегино-Кангаласский</option>';
            _options_str  += '<option value="Мирнинский">Мирнинский</option>';
            _options_str  += '<option value="Момский">Момский</option>';
            _options_str  += '<option value="Намский">Намский</option>';
            _options_str  += '<option value="Нерюнгринский">Нерюнгринский</option>';
            _options_str  += '<option value="Нижнеколымский">Нижнеколымский</option>';
            _options_str  += '<option value="Нюрбинский">Нюрбинский</option>';
            _options_str  += '<option value="Оймяконский">Оймяконский</option>';
            _options_str  += '<option value="Олекминский">Олекминский</option>';
            _options_str  += '<option value="Оленекский">Оленекский</option>';
            _options_str  += '<option value="Среднеколымский">Среднеколымский</option>';
            _options_str  += '<option value="Сунтарский">Сунтарский</option>';
            _options_str  += '<option value="Таттинский">Таттинский</option>';
            _options_str  += '<option value="Томпонский">Томпонский</option>';
            _options_str  += '<option value="Усть-Алданский">Усть-Алданский</option>';
            _options_str  += '<option value="Усть-Майский">Усть-Майский</option>';
            _options_str  += '<option value="Усть-Янский">Усть-Янский</option>';
            _options_str  += '<option value="Хангаласский">Хангаласский</option>';
            _options_str  += '<option value="Чурапчинский">Чурапчинский</option>';
            _options_str  += '<option value="Эвено-Бытантайский">Эвено-Бытантайский</option>';
            _options_str  += '<option value="Якутск">Якутск</option>';
            sel_.innerHTML = _options_str;
            div_.appendChild(sel_);
            var lab_ = document.createElement('div');
            lab_.innerHTML = 'Район:';
            lab_.className = 'filterlabel';
            div_.appendChild(lab_);
            var reset_ = document.createElement('div');
            reset_.innerHTML = 'clear filter';
            reset_.className = 'filterlabel';
            reset_.onclick = function() {
                var options = document.getElementById("sel_").options;
                for (var i=0; i < options.length; i++) {
                    options[i].selected = false;
                }
                filterFunc();
            };
            div_.appendChild(reset_);
        resetLabels([layer_1000_0]);
        map.on("zoomend", function(){
            resetLabels([layer_1000_0]);
        });
        map.on("layeradd", function(){
            resetLabels([layer_1000_0]);
        });
        map.on("layerremove", function(){
            resetLabels([layer_1000_0]);
        });
        </script>

        <div class="container mt-5">
    		<div class="col-6 blue mx-auto p-5">
    			<p>*МСП - Малый, средний предприниматели <br>
        			Шкала МСП/1000 - плотность предприятий на 1 тыс. чел. <br>
        			Шкала плотности - плотность предприятий на все население района <br>
        		</p>
    		</div>
        </div>

	<?php require 'footer.php' ?>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>