
/*******************************************
		globales
********************************************/
	/*******************************************
		variables
	********************************************/

var FormeLigne={
	1:{
		couleur:'blue',	
		libelle :'Ami',
		icone:'https://web-max.fr/gesFront/public/sdk-ol/img/front-ami.png'				
	},
	2:{
		couleur:'red',
		libelle :'Ennemi',
		icone:'https://web-max.fr/gesFront/public/sdk-ol/img/front-ennemi.png'				
	},
	3:{
		couleur:'green',
		libelle :'Neutre',
		icone:'https://web-max.fr/gesFront/public/sdk-ol/img/front-neutre.png'				
	},
	4:{
		couleur:'gray',
		libelle :'Centre',
		icone: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-canon-24.png'	//icons8-poing-serrÃ©-48.png
	}
};
	/*******************************************
		fonctions
	********************************************/
function removeOptions(selectbox){
	for(var i = selectbox.options.length - 1 ; i >= 1 ; i--){
		selectbox.remove(i);
	}
};


function centerMap (e) {
	mymap.panTo(e.latlng);
};

function zoomIn (e) {
	mymap.zoomIn();
};

function zoomOut (e) {
	mymap.zoomOut();
};

function gererlesDates(idfront){
	var idFront=listeLeaflet[idfront.relatedTarget._leaflet_id]['idFront'];
	sessionStorage['idFront']=idFront;
	appelAjax('listeDate.html', 'idfront/'+idFront,'json');
};

function ajoutConflit(e){
	$('#addFront').css({display:'inline-block'});
	
};

function modifierUnConflit(idfront){
	var unFront= Object.create(Front);
	var idfront=listeLeaflet[idfront.relatedTarget._leaflet_id]['idFront'];
	alert('modifier le conflit num = '+idfront);
	$('.detailFront').css({display:'inline-block'});
	$('#btnCommande').css({display:'inline-block'});
	$('.addDateLigne').css({display:'none'});
	$('#dateFront-show').css({display:'none'});
	$("#descriptionDetailFront").val(listeFronts[idfront].description);
	$("#nomDetailFront").val(listeFronts[idfront].nom);
	sessionStorage['operationFront']='update';
	sessionStorage['idfront']=idfront;
};
function supprimerUnConflit(idfront){
	var unFront= Object.create(Front);
	alert('supprimer le conflit num = '+listeLeaflet[idfront.relatedTarget._leaflet_id]['idFront']);
	unFront.deleteFront(listeLeaflet[idfront.relatedTarget._leaflet_id]['idFront']);
	
};
function donneCarte(){
	return mymap;
}

function voirDumpPoint (e){
	// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	console.log('dump fonction');
	
	if(typeof mymap._editablePolylines !== "undefined"){
		mymap._editablePolylines.forEach(function(uneLigneFront) {
			var points = uneLigneFront.getPoints();
			console.log('uneLigneFront id = '+uneLigneFront._leaflet_id+", type ="+uneLigneFront.options.newPolylineTypeMessage);
			
			points.forEach(function(point) {
				var latLng = point.getLatLng();
				console.debug('context du point =' + point.context);
				pointsTextArea.innerHTML += 
					'originalPointNo=' + (point.context ? point.context.originalPointNo : null)
					+ ' originalPolylineNo=' + (point.context ? point.context.originalPolylineNo : null)
					+ ' (' + latLng.lat + ',' + latLng.lng + ')\n';
					+ '\n';
			});
			pointsTextArea.innerHTML += '----------------------------------------------------------------------------------------------------\n';
		});
	}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}

function ouvrirCarte(){
	appelAjax('paramGenerauxCarte','','json');
	
	mymap = L.map("mapid",{
		center : [ ParamGeneraux[0]['latCentre'],ParamGeneraux[0]['lngCentre'] ],
		zoom: ParamGeneraux[0]['zoom'],
		contextmenu: true,
		contextmenuWidth: 140,
		contextmenuItems: [
			{
				text: 'Créer une nouvelle zone de fronts',
				icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png',
				callback: ajoutConflit
			},{ 
				separator: true
			}, {
				text: 'Centrer la carte ici',
				callback: centerMap
			}, {
				text: 'Aggrandir',
				icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png',
				callback: zoomIn
			}, {
				text: 'Réduire',
				icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png',
				callback: zoomOut
			}]
		}
	);

	var etatMajor =	L.tileLayer('https://wxs.ign.fr/hz2zuzccg4dyv6kacncfnbxj/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer='+ParamGeneraux[0]['layer']+'&format=image/jpeg&style=normal',  //
		{
			minZoom : 0,
			maxZoom : ParamGeneraux[0]['maxZoom'] ,
			tileSize : ParamGeneraux[0]['tileSize'],
			boxZoom : ParamGeneraux[0]['boxZoom'],
			attribution : ParamGeneraux[0]['attribution']
		});
	etatMajor.addTo(mymap);	
	//alert('fin chgt carte');
	//return mymap;
}


function appelAjax(action, param, monDataType){
	if(param.length>0){
		madata='action='+action+'/'+param;
		console.log ('action = '+madata);
	}else{
		madata='action='+action
	}
	monDataType===''? monDataType='json' : monDataType=monDataType;
	$.ajax({
       url : 'index.php',
       type : 'GET',
	   async: false,
	   data : madata, 			
       dataType : monDataType,
       success : function(resultat, statut){
		    if (resultat==="Success"){
				console.log('OK');
			}
			console.debug('resultat = '+resultat);
			return resultat;
		},
       error : function(resultat, statut, erreur){
			//alert ('erreur : '+action);
			console.log('erreur deb : '+erreur);
			console.log('statut deb : '+statut);
			
			console.debug(resultat);
			//console.debug(erreur);
			console.log('erreur fin : '+action);
       },
       complete : function(resultat, statut){
		    //alert('complete ');
			if(action==="paramGenerauxCarte"){
				console.log('param');
				console.debug(resultat);
				var tempParam=Object.create(paramGeneraux);
				tempParam.init(
					resultat.responseJSON.zoom,
					resultat.responseJSON.latCentre,
					resultat.responseJSON.lngCentre,
					resultat.responseJSON.maxZoom,
					resultat.responseJSON.tileSize,
					resultat.responseJSON.boxZoom,
					resultat.responseJSON.attribution,
					resultat.responseJSON.layer
				);
				ParamGeneraux.push(tempParam);
				console.debug(ParamGeneraux[0]);
			}else if(action==="listeFront.html"){
				console.log('front');
				console.debug(resultat);
				console.log('nb fronts prévu :'+resultat.responseJSON.length);
				for (i=0;i<resultat.responseJSON.length;i++){
					console.log('fronts JSON '+resultat.responseJSON[i].idfront);
					var unFront=Object.create(Front);
					unFront.init(
						resultat.responseJSON[i].idfront,
						resultat.responseJSON[i].nom,
						resultat.responseJSON[i].zoom,
						resultat.responseJSON[i].lat,
						resultat.responseJSON[i].lng,
						resultat.responseJSON[i].valide,
						resultat.responseJSON[i].idauteur,
						resultat.responseJSON[i].description
					);
					listeFronts[unFront['idfront']]=unFront;
					console.log('id front =' + unFront['idfront']);
				}
				console.log('nb front =' +listeFronts.length);
			}else if(action==="listeDate.html"){
				console.log('nb dates  avt :'+listeDates.length);
				listeDates.splice(0,listeDates.length);
				console.log('nb dates  apr :'+listeDates.length);
				console.log('date');
				console.debug(resultat);
				
				var nbDate=resultat.responseJSON.length;
				console.log('nb dates prévues :'+nbDate);
				for (i=0;i<nbDate;i++){
					console.log('Dates JSON '+resultat.responseJSON[i].iddate);
					var uneDateFront=Object.create(DateFront);
					uneDateFront.init(
						resultat.responseJSON[i].iddate,
						resultat.responseJSON[i].description,
						resultat.responseJSON[i].valide,
						resultat.responseJSON[i].numordre,
						resultat.responseJSON[i].date,
						resultat.responseJSON[i].idfront
					);
					listeDates[uneDateFront['iddate']]=uneDateFront;
				}
						
				removeOptions(document.getElementById("dateLigne"));
				$('#btnCommande').css({display:'inline-block'});
				if(nbDate>0){
					listeDates.forEach(function(madate){
						console.log('clic date = '+madate.getIddate());
						var newOption = new Option(madate.getDate(), madate.getIddate(), false, false);
						$('.dateLigne').css({display:'inline-block'});
						$('#dateLigne').append(newOption).trigger('change');
						$('.addDateLigne').css({display:'none'});
						$('#infoDateLigne').css({display:'inline-block'});
					});
				}else{
					console.log('clic date : pas de date');
					$('.dateLigne').css({display:'none'});
					$('.addDateLigne').css({display:'none'});
					$('.dateFront-save-button').css({display:'inline-block'});
					$('#infoDateLigne').css({display:'none'});
					console.log("Mode ajout commencé");
				}
				console.debug('nb date =' +listeDates.length);
				return listeDates.length;
			}else if(action==='listeLigneDate.html'){
				console.log('nb ligne avt :'+listeLigneFront.length);
				listeLigneFront.splice(0,listeLigneFront.length);
				listePoint.splice(0,listePoint.length);
				console.log('nb dates  apr :'+listeLigneFront.length);
				console.log('ligne date');
				console.debug(resultat);
				console.log('nb lignes dates prévues :'+resultat.responseJSON.length);
				if(resultat.responseJSON.length>0){
					for (i=0;i<resultat.responseJSON.length;i++){
						console.log('Ligne de front JSON '+resultat.responseJSON[i].idlignefront);
						var uneLigneFront=Object.create(LigneFront);
						uneLigneFront.init(
							resultat.responseJSON[i].idlignefront,
							resultat.responseJSON[i].couleur,
							resultat.responseJSON[i].type,
							resultat.responseJSON[i].valide,
							resultat.responseJSON[i].iddatefront,
							resultat.responseJSON[i].idcontributeurfront
						);
						listeLigneFront[uneLigneFront['idlignefront']]=uneLigneFront;	
						listeLigneFront[uneLigneFront['idlignefront']].montreMoi();				
					}
				}else{
					var newLigne=Object.create(LigneFront);
					newLigne.autoriseCreation();
				}
				
				console.debug('nb date =' +listeLigneFront.length);
				
			}else if(action==='listePoint.html'){
				console.log('liste des points');
				console.debug(resultat);
				//console.log('nb dates prévues :'+resultat.responseJSON.length);
				for (i=0;i<resultat.responseJSON.length;i++){
					console.log('Points JSON '+resultat.responseJSON[i].idlignefront);
					var unPoint=Object.create(Point);
					unPoint.init(
						resultat.responseJSON[i].idpoint,
						resultat.responseJSON[i].lat,
						resultat.responseJSON[i].lng,
						resultat.responseJSON[i].idmarqueur,
						resultat.responseJSON[i].idlignefront
					);
					listePoint[unPoint['idpoint']]=unPoint;
				}
				console.debug('nb point=' +listePoint.length);
			}	
        }
    });
	
}


/*******************************************
		objets
********************************************/
	/*******************************************
		ref leaflet
	********************************************/
var listeLeaflet=[];
var Leaflet={
	init:function(idFront){ 
		this.idFront=idFront;
	},
	getIdFront:function(){
		return this.idFront;
	}
};	

	/*******************************************
		param généraux
	********************************************/
ParamGeneraux=[];
var paramGeneraux={
	init:function(zoom, latCentre,lngCentre,maxZoom,tileSize,boxZoom,attribution,layer){
	this.zoom=zoom;
	this.latCentre=latCentre;
	this.lngCentre=lngCentre;
	this.maxZoom=maxZoom;
	this.tileSize=tileSize;
	this.boxZoom=boxZoom;
	this.attribution=attribution;
	this.layer=layer;
	}
};
	/*******************************************
		liste de fronts
	********************************************/
var listeFronts=[];	
var Front={
	init:function(idfront,nom,zoom, lat,lng,valide,idauteur,description){
		this.idfront=idfront;
		this.nom=nom;
		this.zoom=zoom;
		this.lat=lat;
		this.lng=lng;
		this.valide=valide;
		this.idauteur=idauteur;
		this.description=description;
		this.modifEnCours=false;
	},
	getNom:function(){
		return this.nom;
	},
	getDescription:function(){
		return this.description;
	},
	getParamCarteUnFront:function(){
		console.log('getParamCarteUnFront 1  ');
		var paramCarte=[];
		paramCarte['lat']=this.lat;
		paramCarte['lng']=this.lng;
		paramCarte['zoom']=this.zoom;
		console.log('getParamCarteUnFront 2  '+paramCarte);
		
		return paramCarte;
	},
	getModifEnCours:function(){
		return this.modifEnCours;
	},
	setModifEnCours:function(etat){
		this.modifEnCours=etat;
	},

	montreMoi:function(formeligne){
		console.log('prepare context menu id '+this.idfront+ ' lat = '+this.lat+' lng = '+this.lng);
		sessionStorage['idFront']=this.idfront;
		var centreFront = L.marker( 
			[this.lat,this.lng], 
			{
				draggable: true, 
				contextmenu: true,
				icon:  L.icon({
					iconUrl:formeligne,		//FormeLigne[4].icone
					iconSize: [24,24],
					iconAnchor: [12,12],
					popupAnchor:  [0,-24]
					}),
				riseOnHover:true,
				alt: 'Point central du front',
				title: this.nom,
				contextmenuItems: [
					{
						text: 'gérer les dates du conflit',
						icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png',
						callback: gererlesDates,
						index: 0
					},{
						text: 'Modifier un conflit',
						icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png',
						callback: modifierUnConflit,
						index: 1
					},{
						text: 'Supprimer un conflit',
						icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png',
						callback: supprimerUnConflit,
						index: 1
					}
				]
			}
		).addTo(mymap);	
		this.creePointeur(centreFront);
		return centreFront;
	},
	creePointeur:function(centreFront){
		var newLeaflet= Object.create(Leaflet);
		
		newLeaflet.init(this.idfront);
		//listeLeaflet[this._leaflet_id]=newLeaflet;
		listeLeaflet[centreFront._leaflet_id]=newLeaflet;
		console.log ('taille leaflet = '+listeLeaflet.length);
		console.debug(listeLeaflet);

		centreFront.bindPopup("<b>"+this.nom+" <i>"+this.idfront+"</i></b><br />"+this.description);
		
	}, 
	addFront:function(){
		//alert ('add front');
		var rep='';
		rep += 'zoom>' + this.zoom + '|';
		rep += 'lat>'+ this.lat +'|';  // 
		rep += 'lng>'+ this.lng +'|';  // 
		rep += 'nom>'+ this.nom +'|';
		rep += 'description>'+this.description +'|';
		//rep += 'nbLignesFront>'+ mesFront.length +'|';
		appelAjax('addFront','nbFront/1/mesFronts/'+rep,'','text');
		
	},
	deleteFront:function(monFront){
		appelAjax('supprimeFront','idfront/'+monFront,'','text');
		console.log("Mode suppression terminés");
	},
	updateFront:function(monFront){
		var rep='';
		rep += 'idfront>' + this.idfront+ '|';
		rep += 'zoom>' + this.zoom + '|';
		rep += 'lat>'+ this.lat +'|';  // 
		rep += 'lng>'+ this.lng +'|';  // 
		rep += 'nom>'+ this.nom +'|';
		rep += 'description>'+this.description +'|';
		rep += 'valide>'+false +'|';
		rep += 'idauteur>'+this.idauteur +'|';
		appelAjax('modifieFront','mesFronts/'+rep,'','text');
		console.log("Mode modification terminé");		
	}
};

	/*******************************************
			liste de date des fronts
	********************************************/
var listeDates=[];
var DateFront={
	init:function(iddate,description,valide,numordre,date,idfront){
		this.iddate=iddate;
		this.description=description;
		this.valide=valide;
		this.numordre=numordre;
		this.date=date;
		this.idfront=idfront;
		this.modifEnCours=false;
	},
	getIddate:function(){
		return this.iddate;
	},
	getDate:function(){
		return this.date;
	},
	getDescription:function(){
		return this.description;
	},
	getDate:function(){
		return this.date;
	},
	getIdfront:function(){
		return this.idfront;
	},
	getModifEnCours:function(){
		return this.modifEnCours;
	},
	setModifEnCours:function(etat){
		this.modifEnCours=etat;
	},
	donneDernierId:function(){
		$.ajax({
		   url : 'index.php',
		   type : 'GET',
		   async: false,
		   data : 'action=NewIdDateFront/', 			
		   dataType : 'text',
		   success : function(resultat, statut){
				return resultat;
			},
		   error : function(resultat, statut, erreur){
				console.log('erreur fin : '+action);
		   },
		   complete : function(resultat, statut){	
		   }
		})
	},
	addDateFront:function(){
		var rep='';
		rep += 'date>' + this.date + '|';
		rep += 'numordre>'+ this.numordre +'|';  // 
		rep += 'valide>'+ this.valide +'|';  // 
		rep += 'description>'+this.description +'|';
		rep += 'idfront>'+this.idfront +'|';		
		appelAjax('addDateFront','nbFront/1/maDate/'+rep,'','text');
	},
	deleteDateFront:function(maDate){
		appelAjax('supprimeDateFront','iddate/'+maDate,'','text');
		console.log("Mode suppression terminés");		
	},
	updateDateFront:function(maDate){
		var refDate=this.iddate;
		var rep='';
		rep += 'iddate>' + this.iddate + '|';
		rep += 'date>' + this.date + '|';
		rep += 'numordre>'+ this.numordre +'|';  // 
		rep += 'valide>'+ this.valide +'|';  // 
		rep += 'description>'+this.description +'|';
		rep += 'idfront>'+this.idfront +'|';
		appelAjax('modifieDateFront','madate/'+rep,'','text');
		console.log("Mode modification terminé");	
		var mesLignes=Object.create(LigneFront);
		var maDate=this.iddate;
		mesLignes.supprimeLigne(this.iddate);
		if(this.iddate=0){
			this.iddate=this.donneDernierId();
			console.log('uneLigneFront id = '+ this.iddate);
		}
		
				
		// Ajout des nouvelles lignes
		if(typeof mymap._editablePolylines !== "undefined"){
			mymap._editablePolylines.forEach(function(uneLigneFront) {
				var points = uneLigneFront.getPoints();
				console.log('uneLigneFront id = '+uneLigneFront._leaflet_id+", type ="+uneLigneFront.options.newPolylineTypeMessage);
				var maLigneDate=Object.create(LigneFront);
				
				console.debug(uneLigneFront._map._editablePolylines[uneLigneFront._map._editablePolylines.length-1]);
				var mesOptions=uneLigneFront._map._editablePolylines[uneLigneFront._map._editablePolylines.length-1]._options
				var couleur = mesOptions.color;
				var type = mesOptions.type;
				console.log('couleur ligne = '+FormeLigne[uneLigneFront.options.newPolylineTypeMessage]);
				console.log('type ligne = '+type);
				console.log('date ligne = '+maDate);
				maLigneDate.init(0,couleur,type,false,maDate,0);
				var idLigneDate=maLigneDate.addLigneDate();					
				points.forEach(function(point) {
					var latLng = point.getLatLng();
					var monPoint=Object.create(Point);
					monPoint.init(0,latLng.lat,latLng.lng,'',idLigneDate);
					monPoint.addPoint();
				});
			});
		};
	}
};
	/*******************************************
		liste de lignes de front
	********************************************/
var listeLigneFront=[];
var LigneFront={
	init:function(idlignefront, couleur, type, valide,iddatefront, idcontributeurfront){
		this.idlignefront=idlignefront;
		this.couleur=couleur;
		this.type=type;
		this.valide=valide;
		this.iddatefront=iddatefront;
		this.idcontributeurfront=idcontributeurfront;
	},
	getIdlignefront:function(){
		return this.idlignefront;
	},
	getIddatefront:function(){
		return this.iddatefront;
	},
	donneCoordonneesMesPoints:function(maLigne){
		var listeCoordonneesUnFront=[];
		var uneCoordonnee;
		console.log('id front ='+maLigne);
		listePoint.forEach(function(monPoint){
			console.log('id front ='+maLigne+' point id = '+monPoint.getIdlignefront());
			if(monPoint.getIdlignefront()===maLigne){
				uneCoordonnee=[String(monPoint.getLat()),String(monPoint.getLng())];
				listeCoordonneesUnFront.push (uneCoordonnee);
				console.log('un point : '+listeCoordonneesUnFront[listeCoordonneesUnFront.length-1]);
			}			
		});
		return listeCoordonneesUnFront;		
	},
	autoriseCreation:function(){
		var polylineOptions = {
			// The user can add new polylines by clicking anywhere on the map:
			newPolylines: true,
			contextmenu: true,
			newPolylineConfirmMessage: 'Voulez-vous commencer une ligne ici 	?',
			// Show editable markers only if less than this number are in map bounds:
			contextmenuItems: []
		};
		var newLigneFront = L.Polyline.PolylineEditor([], polylineOptions).addTo(mymap);	
	},
	montreMoi:function(){
		console.log('recherche des points de la ligne '+ this.idlignefront);
		listeLigneFront.forEach(function(monLigneFront){
			appelAjax('listePoint.html', 'idlignefront/'+monLigneFront.idlignefront,'json');
			console.log('nombre de points '+listePoint.length);
			
			var polylineOptions = {
				// The user can add new polylines by clicking anywhere on the map:
				newPolylines: true,
				contextmenu: true,
				newPolylineConfirmMessage: 'Voulez-vous commencer une ligne ici 	?',
				// Show editable markers only if less than this number are in map bounds:
				newPolylineTypeMessage: 2,
				maxMarkers: 100,
				color: monLigneFront.couleur,
				formeLigne:monLigneFront.type,
				weight: 3,
				dashArray: '10,7',
				lineJoin:'round',
				maxMarkers: 100,
				contextmenuItems: [
					{ 
						separator: true
					}, {
						text: 'Voir dump',
						icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png',
						callback: this.voirDumpPoint
					}
				]
			};
			uneLigneFront = L.Polyline.PolylineEditor(monLigneFront.donneCoordonneesMesPoints(monLigneFront.idlignefront), polylineOptions).addTo(mymap);
			
			//uneLigneFront =  L.polyline
			
			console.log('id une ligne de front = '+uneLigneFront._leaflet_id);
			
			//uneLigneFront.bindPopup("<b>Ligne de front"+" <i>"+uneLigneFront._leaflet_id+"<br /><button class='ligne-delete-button' title='supprime la ligne'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> </button>").openPopup();	
			//uneLigneFront.on("popupopen", this.onPopupLigneFrontOpen);
		});
		
		var monFrontMere=listeDates[this.iddatefront].getIdfront();
		console.log('id front mere '+monFrontMere);
		var paramFront=[];
		paramFront=listeFronts[monFrontMere].getParamCarteUnFront();
		console.debug("paramFront = "+paramFront['lat']+' '+paramFront['lng']+' '+paramFront['zoom']);
		
		
		mymap.setView([paramFront['lat'],paramFront['lng']],paramFront['zoom']);
	},
	addLigneDate:function(){
		var rep='';
		rep += 'iddatefront>' + this.iddatefront + '|';
		rep += 'valide>' + true + '|';
		rep += 'type>'+ this.type+'|';  // 
		rep += 'couleur>'+ this.couleur +'|';  // 
		rep += 'idcontributeurfront>'+this.idcontributeurfront +'|';
		var idLigneDate=appelAjax('creeLigneDate','maligne/'+rep,'','text');	
	},
	supprimeLigne:function(iddate){
		// Suppression des lignes existantes pour la date
		appelAjax('supprimeLigneDate', 'iddatefront/'+iddate,'json');
	}	
};

	/*******************************************
		liste de points d'une ligne
	********************************************/
var listePoint=[];
var Point={
	init:function(idpoint, lat, lng, idmarqueur,idlignefront){
		this.idpoint=idpoint;
		this.lat=lat;
		this.lng=lng;
		this.idmarqueur=idmarqueur;
		this.idlignefront=idlignefront;
	},
	getIdpoint:function(){
		return this.idpointt;
	},
	getLat:function(){
		return this.lat;
	},
	getLng:function(){
		return this.lng;
	},
	getIdlignefront:function(){
		return this.idlignefront;
	},
	addPoint:function(){
		var rep='';
		rep += 'iddatefront>' + this.iddatefront + '|';
		rep += 'lat>' + this.lat + '|';
		rep += 'lng>'+ this.lng+'|';  // 
		rep += 'idmarqueur>'+ this.idmarqueur +'|';  // 
		rep += 'idlignefront>'+this.idlignefront +'|';
		appelAjax('creePoint','monPoint/'+rep,'','text');	
	}
	
};

/*******************************************
		Main
********************************************/


window.onload = function () {

	var mymap=ouvrirCarte();
	
	// chargement des fronts
	console.log('debut chgt fronts');
	
	appelAjax('listeFront.html', '','','json');	
	console.log('fin chgt fronts');
	
	//affichage carte
	//console.log('nombre de cartes ='+listeCartes.length);
	
	//positionnement des combats
	listeFronts.forEach(function(unFront){
		centreMonFront=unFront.montreMoi( FormeLigne[4].icone);
	});
	
	
	
		/*******************************************
			gestion des evenements de la feuille
		********************************************/
		
	document.getElementById("dateLigne").addEventListener("change", function(e){
		$('#dateFront-action').css({display:'inline-block'});
		
		// objet jQuery contenant l'option sélectionnée
		var jObj = $("option", this).filter(":selected"), 
			id = jObj.get(0).id, // id
			n = id.slice(1), // numéro
			v = jObj.val(), // value
			t = jObj.text(); // texte
			console.log('date ligne option value = '+v);
			console.log('date ligne option value = '+t);
		sessionStorage['idDate']=v;
		console.log("Choix date ligne en cours");
	});
	
	document.getElementById("dateFront-show-button").addEventListener("click", function(e){
		console.log('id Date = '+sessionStorage['idDate'] +'dans liste = '+listeDates[sessionStorage['idDate']].description);
		console.log('id Date = '+sessionStorage['idDate'] +'dans liste = '+listeDates[sessionStorage['idDate']].date);
		
		$("#addDescriptionLigne").val(listeDates[sessionStorage['idDate']].description);
		$("#addDateLigne").val(listeDates[sessionStorage['idDate']].date);
		var maDate = Object.create(DateFront);
		if(!maDate.getModifEnCours()){
			appelAjax('listeLigneDate.html', 'iddatefront/'+sessionStorage['idDate'],'','json');
			$('#btnAjoutLigne').css({display:'inline-block'});
			$('.addDateLigne').css({display:'inline-block'});
			console.log("Mode consultation commencé");
		}
	});
	
	document.getElementById("dateFront-add-button").addEventListener("click", function(e){
		var maDate = Object.create(DateFront);
		maDate.setModifEnCours(true);
		$('.addDateLigne').css({display:'inline-block'});
		$('.dateFront-save-button').css({display:'inline-block'});
		sessionStorage['operationDate']='ajoutDate';
		console.log("Mode ajout commencé");
	});
	document.getElementById("dateFront-update-button").addEventListener("click", function(e){
		var maDate = Object.create(DateFront);
		maDate.setModifEnCours(true);
		$('.addDateLigne').css({display:'inline-block'});
		$('.dateFront-save-button').css({display:'inline-block'});
		sessionStorage['operationDate']='modifDate';
		console.log("Mode modif commencé");
	});
	document.getElementById("dateFront-save-button").addEventListener("click", function(e){
		$('.addDateLigne').css({display:'none'});
		$('.dateFront-save-button').css({display:'none'});
		console.log("Mode ajout et modif terminés");
		var maDate = Object.create(DateFront);
		var iddate=0;
		sessionStorage['operationDate']=='ajoutDate' ? iddate=0 : iddate= sessionStorage['idDate'];
		maDate.init(iddate,$('#addDescriptionLigne').val(),false,0,$('#addDateLigne').val(),sessionStorage['idFront']);
		sessionStorage['operationDate']=='ajoutDate' ? maDate.addDateFront() :  maDate.updateDateFront(sessionStorage['idDate']);
		maDate.setModifEnCours(false);
	});
	
	document.getElementById("dateFront-delete-button").addEventListener("click", function(e){
		alert("Mode suppression engagé");
		var maDate = Object.create(DateFront);
		maDate.deleteDateFront(sessionStorage['idDate']);
	});
	
	document.getElementById("detailFront-save-button").addEventListener("click", function(e){
		$('.detailFront').css({display:'none'});
		$('#btnCommande').css({display:'none'});
		console.log("Mode modif terminé");
		var monFront = Object.create(Front);
		var idfront=0;
		var monCentre=donneCarte().getCenter();
		sessionStorage['operationFront']=='update' ? idfront=sessionStorage['idfront'] : idfront= 0;
		monFront.init(idfront,$('#nomDetailFront').val(),donneCarte().getZoom(),String(monCentre.lat),String(monCentre.lng),false,'',$('#descriptionDetailFront').val());
		sessionStorage['operationFront']=='update' ? monFront.updateFront(sessionStorage['idfront']) : monFront.updateFront() ;
		monFront.setModifEnCours(false);
	});	
	document.getElementById("btnOuiFront").addEventListener("click", function(e){
		console.log("front oui ");
		$('#addFront').css({display:'none'});
		var newFront= Object.create(Front);
		var monCentre=donneCarte().getCenter();
		console.log("centre carte "+donneCarte().getZoom());
		newFront.init(0,$('#nomFront').val(),donneCarte().getZoom(),String(monCentre.lat),String(monCentre.lng),false,'',$('#descriptionFront').val());
		newFront.addFront();
	});
	document.getElementById("btnAnnulerFront").addEventListener("click", function(e){
		
		console.log("front action  annulée ");
		$('#addFront').css({display:'none'});
		
	});
}


// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++




