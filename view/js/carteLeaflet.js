﻿
/*******************************************
		globales
********************************************/
	/*******************************************
		variables
	********************************************/
var mymap=[];
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
		icone: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-canon-24.png'
	},
	5:{
		couleur:'gray',
		libelle :'Centre',
		icone: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-canon-gris.png'	
	}
};

	/*******************************************
		fonctions
	********************************************/
function afficheActionMaj(){
	var userLevel=0;
	var monUser=Object.create(User);	
	userLevel= listeUser[0].userLevel;
	console.log ("niveau user = "+ listeUser[0].userLevel);
	return userLevel  > 0 ? true : false;
};

function frontDraggable(){	
	var mesParamsGeneraux=Object.create(ParamGeneraux); 
	//return (afficheActionMaj()  > 0) && mesParamsGeneraux.getMajLigneEnCours() ? true : false;
	return (afficheActionMaj()  > 0) && ParamGeneraux[0].majLigneEnCours ? true : false;
};

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
	var monIdFront=listeLeaflet[idfront.relatedTarget._leaflet_id]['idFront'];
	sessionStorage['idFront']=monIdFront;
	sessionStorage['dateActive']=0;
	var maDate=Object.create(DateFront);
	listeDates.splice(0,listeDates.length);	
	listeLigneFront.splice(0,listeLigneFront.length);	
	listePoint.splice(0,listePoint.length);	

	maDate.effaceFronts();
	console.log('gesrerlesDates idfront = '+ monIdFront);
	maDate.setIdFront(monIdFront);	
	var nbDates=maDate.recoitListeDate();
	
	if(afficheActionMaj()){
		$('.dateLigne').css({display:'inline-block'});
		$('.detailFront').css({display:'none'});
		$('.infoligne').css({display:'none'});
		//$('#dateFront-show').css({display:'none'});
		$('.dateFront-save-cancel').css({display:'none'});
		$('#btnNavDate').css({display:'none'});
		$('#infoDateLigne').css({display:'inline-block'});

		$('#dateFront-show').css({display:'inline-block'});
		
	}else{
		var v = maDate.prev();
		$("#textDescriptifLigne").html(maDate.donneDescriptif());
		$('#btnNavDate').css({display:'flex'});
		$('#infoDateLigne').css({display:'none'});
		$('.textDescriptifLigne').css({display:'inline-block'});
	}
};

function ajoutConflit(e){
	$('#addFront').css({display:'inline-block'});
	
};

function modifierUnConflit(idfront){
	var unFront= Object.create(Front);
	var idfront=listeLeaflet[idfront.relatedTarget._leaflet_id]['idFront'];
	var monFront=Object.create(Front);
	monFront.zoomFront(idfront);
	$('.detailFront').css({display:'inline-block'});
	var monParam=Object.create(paramGeneraux);
	monParam.afficheBtnCommande(true);
	$('.addDateLigne').css({display:'none'});
	$('#btnNavDate').css({display:'none'});
	$('#dateFront-show').css({display:'none'});
	$('#infoDateLigne').css({display:'none'});
	$("#descriptionDetailFront").val(listeFronts[idfront].description);
	$("#nomDetailFront").val(listeFronts[idfront].nom);
	sessionStorage['operationFront']='update';
	sessionStorage['idfront']=idfront;
};
function supprimerUnConflit(idfront){
	if(confirm("Confirmez-vous la demande de suppression d'une zone de conflit ?")){
		var unFront= Object.create(Front);
		unFront.deleteFront(listeLeaflet[idfront.relatedTarget._leaflet_id]['idFront']);
	}
};
function donneCarte(){
	return mymap;
};


function ouvrirCarte(){
	appelAjax('paramGenerauxCarte','','json');
	console.log(donneMenuContext('gene'));
	
	mymap = L.map("mapid",{
		center : [ ParamGeneraux[0]['latCentre'],ParamGeneraux[0]['lngCentre'] ],
		zoom: ParamGeneraux[0]['zoom'],
		contextmenu: true,
		contextmenuWidth: 200,
		contextmenuItems: donneMenuContext('gene')
		}
	);

	var etatMajor =	L.tileLayer('https://wxs.ign.fr/hz2zuzccg4dyv6kacncfnbxj/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer='+ParamGeneraux[0]['layer1']+'&format=image/jpeg&style=normal',  //
		{
			minZoom : 0,
			maxZoom : ParamGeneraux[0]['maxZoom'] ,
			tileSize : ParamGeneraux[0]['tileSize'],
			boxZoom : ParamGeneraux[0]['boxZoom'],
			attribution : ParamGeneraux[0]['attribution']
		});
	etatMajor.addTo(mymap);	
	var photo =	L.tileLayer('https://wxs.ign.fr/hz2zuzccg4dyv6kacncfnbxj/geoportail/wmts?service=WMTS&request=GetTile&version=1.0.0&tilematrixset=PM&tilematrix={z}&tilecol={x}&tilerow={y}&layer='+ParamGeneraux[0]['layer2']+'&format=image/jpeg&style=normal',  //
		{
			minZoom : 0,
			maxZoom : ParamGeneraux[0]['maxZoom'] ,
			tileSize : ParamGeneraux[0]['tileSize'],
			boxZoom : ParamGeneraux[0]['boxZoom'],
			attribution : ParamGeneraux[0]['attribution']
		});
	etatMajor.addTo(mymap);	
	var baseMaps={
		"Etat-major" : etatMajor,
		"Photo" : photo
	}
	L.control.layers(baseMaps).addTo(mymap);
};

function donneMenuContext(menu){
	var menuGene=[];
	var menuFront=[];	
	var menuGeneAdmin=[
		{
			text: 'Créer une nouvelle zone de fronts',
			icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png',
			callback: ajoutConflit
		},{ 
			separator: true
		}
		];
	var menuGeneVisiteur=[{
			text: 'Centrer la carte ici',
			icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-centrer-32.png',
			callback: centerMap
		}, {
			text: 'Aggrandir',
			icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-add-new-32.png',
			callback: zoomIn
		}, {
			text: 'Réduire',
			icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-moins-32.png',
			callback: zoomOut
		}];

	var menuFrontAdmin=[{
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
			index: 2
		}
	];
	var menuFrontVisiteur=[{
			text: 'voir les dates du conflit',
			icon: 'https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png',
			callback: gererlesDates,
			index: 0
		},
		{ 
			separator: true,
			index :1
		}
	];
	console.log('affiche admin ? '+afficheActionMaj());
	if(afficheActionMaj()){
		menuGene=menuGeneAdmin.concat(menuGeneVisiteur);
		menuFront=menuFrontAdmin;
		console.log ('Menu Front = '+menuFront);
	}else{
		menuGene=menuGeneVisiteur;
		menuFront=menuFrontVisiteur;
	};
	if(menu==='gene'){
		return menuGene;
	}else{
		return menuFront;
	}
};
function appelAjax(action, param, monDataType){
	if(param.length>0){
		madata='action='+action+'/'+param;
		console.log ('action = '+madata);
	}else{
		madata='action='+action
	}
	monDataType===''? monDataType='json' : monDataType=monDataType;
	var monParamgeneral= Object.create(paramGeneraux);
	$.ajax({
	   url : 'index.php',
	   type : 'GET',
	   async: ParamGeneraux[0]['synchrone'],
	   data : madata, 			
       dataType : monDataType,
       success : function(resultat, statut){
		    if(action!=='listeDate.html'){
				if (resultat==="Success"){
					console.log('OK');
				}
				console.log('resultat = '+resultat.length+' '+resultat);
				return resultat;
			}
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
		    if(action==='listeDate.html'){
			   console.log('retour liste date = '+resultat.responseJSON);
				var nbDate=resultat.responseJSON.length;
				console.log('nb dates prévues :'+nbDate);
				for (var d=0;d<nbDate;d++){
					console.log('Dates JSON '+resultat.responseJSON[d].iddate);
					var uneDateFront=Object.create(DateFront);
					uneDateFront.init(
						resultat.responseJSON[d].iddate,
						resultat.responseJSON[d].description,
						resultat.responseJSON[d].valide,
						resultat.responseJSON[d].numordre,
						resultat.responseJSON[d].date,
						resultat.responseJSON[d].idfront
					);
					listeDates.push(uneDateFront);
				};
				console.debug(listeDates);
				removeOptions(document.getElementById("dateLigne"));
		    }else if(action==='addFront'){
				console.log(' demande de tout montrer ');
				var mesFronts=Object.create(Front);
					
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
	init:function(zoom, latCentre,lngCentre,maxZoom,tileSize,boxZoom,attribution,layer1,layer2,synchrone,majLigneEnCours){
	this.zoom=zoom;
	this.latCentre=latCentre;
	this.lngCentre=lngCentre;
	this.maxZoom=maxZoom;
	this.tileSize=tileSize;
	this.boxZoom=boxZoom;
	this.attribution=attribution;
	this.layer1=layer1;
	this.layer2=layer2;
	this.synchrone=synchrone;
	this.majLigneEnCours=false;
	this.actionEnCours=''
	},
	afficheBtnCommande: function(affiche){

		if(affiche){
			var positionTopCarte= $('#mapid').offset().top;
			$('#btnCommande').css({display:'inline-block', top:positionTopCarte+100});
			
		}else{
			$('#btnCommande').css({display:'none'});
		}
	},
	ajaxSynchrone:function(){
		return this.synchrone;
	},
	setModifEnCours:function(majLigneEnCours){
		ParamGeneraux[0].majLigneEnCours=majLigneEnCours;
	},
	getMajLigneEnCours:function(){
		return ParamGeneraux[0].majLigneEnCours;
	}
};
	/*******************************************
		Gestion des utilisateurs
	********************************************/
var listeUser=[];
var User={
	init:function(idUser, userLevel){
		this.idUser=idUser;
		this.userLevel=userLevel;
		console.log ('user niveau : '+this.userLevel);
	},
	getIdUser(){
		return this.idUser;
	},
	getUserLevel(){
		return this.userLevel;
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
	getEstValide:function(){
		return this.valide;
	},
	getModifEnCours:function(){
		return this.modifEnCours;
	},
	setModifEnCours:function(etat){
		this.modifEnCours=etat;
	},
	
	montreTout:function(){
		console.log('je montre tout');
		markerFrontGroup = new L.LayerGroup();
		mymap.addLayer(markerFrontGroup);
		listeFronts.forEach(function(unFront){
			console.log('je montre tout');
			this.centreMonFront=unFront.montreMoi();
		});
	},
	
	zoomFront:function(idFront){
		var paramFront=[];
		paramFront=listeFronts[idFront].getParamCarteUnFront();
		console.debug("paramFront = "+paramFront['lat']+' '+paramFront['lng']+' '+paramFront['zoom']);
		mymap.setView([paramFront['lat'],paramFront['lng']],paramFront['zoom']);
	},
	
	montreMoi:function(){
		console.log('pje me montre menu id '+this.idfront+ ' lat = '+this.lat+' lng = '+this.lng);
		sessionStorage['idFront']=this.idfront;
		var nomConflit=this.nom;
		var numIcone=4;
		if(!this.valide){
			numIcone= 5;
			nomConflit=nomConflit+', à valider';
		}
		var centreFront = L.marker( 
			[this.lat,this.lng], 
			{
				draggable: frontDraggable(), 
				contextmenu: true,
				icon:  L.icon({
					iconUrl:FormeLigne[numIcone].icone,		//FormeLigne[4].icone
					iconSize: [24,24],
					iconAnchor: [12,12],
					popupAnchor:  [0,-24]
					}),
				riseOnHover:true,
				alt: 'Point central du front',
				title: nomConflit,
				contextmenuItems: donneMenuContext('front')
			}
		).addTo(markerFrontGroup);	
		this.creePointeur(centreFront);
		return centreFront;
	},
	creePointeur:function(centreFront){
		var newLeaflet= Object.create(Leaflet);
		newLeaflet.init(this.idfront);
		listeLeaflet[centreFront._leaflet_id]=newLeaflet;
		!this.valide ? nomConflit='A valider' : nomConflit="";
		centreFront.bindPopup("<b>"+this.nom+"</b> <i>"+ nomConflit +"</i><br />"+this.description);
		
	}, 
	
	addFront:function(){
		//alert ('add front');
		var rep='';
		rep += 'zoom>' + this.zoom + '|';
		rep += 'lat>'+ this.lat +'|';  // 
		rep += 'lng>'+ this.lng +'|';  // 
		rep += 'nom>'+ this.nom +'|';
		rep += 'idauteur>'+ this.idauteur +'|';
		rep += 'description>'+this.description +'|';
		//rep += 'nbLignesFront>'+ mesFront.length +'|';
		appelAjax('addFront','nbFront/1/mesFronts/'+rep,'','text');
		
		
	},
	
	deleteFront:function(monFront){
		listeFronts.splice(monFront,1);
		markerFrontGroup.clearLayers();
		delete(listeFronts.monFront);
		this.montreTout();
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
		this.dateActive=0;
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
	getIdfront:function(){
		return this.idfront;
	},
	setIdFront:function(idfront){
		this.idfront = idfront;
	},
	getModifEnCours:function(){
		return this.modifEnCours;
	},
	setModifEnCours:function(etat){
		this.modifEnCours=etat;
	},
	getDateActive:function(){
		return this.dateActive;
	},
	
	prev:function(){
		this.dateActive=parseInt(sessionStorage['dateActive']);
		this.dateActive > 0 ? this.dateActive-- : this.dateActive=0;
		var d=this.dateActive;
		this.init(listeDates[d].iddate,listeDates[d].description,listeDates[d].valide,listeDates[d].numordre,listeDates[d].date,listeDates[d].idfront);
		sessionStorage['idDate']=listeDates[d].iddate;
		
		this.donneDateFront(listeDates[d].iddate);
		
		d === 0 ? $('#btnNavDatePrev').css({display:'none'}) :  $('#btnNavDatePrev').css({display:'inline-block'});
		d === listeDates.length  ? $('#btnNavDateNext').css({display:'none'}) :  $('#btnNavDateNext').css({display:'inline-block'});
		sessionStorage['dateActive']=d;
		return d;
	},
	next:function(){
		this.dateActive = parseInt(sessionStorage['dateActive']);
		this.dateActive < listeDates.length-1 ?	this.dateActive++ :	false;
		
		var d=this.dateActive;
		this.init(listeDates[d].iddate,listeDates[d].description,listeDates[d].valide,listeDates[d].numordre,listeDates[d].date,listeDates[d].idfront);
		sessionStorage['idDate']=listeDates[d].iddate;
		this.donneDateFront(listeDates[d].iddate);
		d === listeDates.length -1  ? $('#btnNavDateNext').css({display:'none'}) :  $('#btnNavDateNext').css({display:'inline-block'});
		d === 0  ? $('#btnNavDatePrev').css({display:'none'}) :  $('#btnNavDatePrev').css({display:'inline-block'});
		sessionStorage['dateActive']=d;
		console.log('nb dates '+listeDates.length+ ' Next '+sessionStorage['dateActive']);
		return d;
	},
	rechercheDate:function(idDate){
		for(var d=0;d< listeDates.length;d++){
			if (listeDates[d].iddate===idDate){
				this.init(listeDates[d].iddate,listeDates[d].description,listeDates[d].valide,listeDates[d].numordre,listeDates[d].date,listeDates[d].idfront);
				return d;
			}
		}
		
	},
	centreSurDate:function(idDate){
		this.rechercheDate(idDate);
		console.debug("centreSurDate id = "+this.idfront);
		var monFront=Object.create(Front);
		monFront.zoomFront(this.idfront);
	},
	recoitListeDate:function(){
		//alert('recoitListeDate idfront ='+this.idfront);
		console.log('nb dates  avt :'+listeDates.length);
		listeDates.splice(0,listeDates.length);
		console.log('nb dates  apr :'+listeDates.length);
		appelAjax('listeDate.html', 'idfront/'+this.idfront,'json');
		
		var nbDate=listeDates.length;
		if(nbDate>0){
			listeDates.forEach(function(madate){
				console.log('clic date = '+madate.getIddate());
				var newOption = new Option(madate.getDate(), madate.getIddate(), false, false);				
				afficheActionMaj() ? $('#btnNavDate').css({display:'none'}) : $('#btnNavDate').css({display:'flex'});
				$('.dateLigne').css({display:'inline-block'});
				$('#dateLigne').append(newOption).trigger('change');
				$('.addDateLigne').css({display:'none'});			
			});
			$('#btnNavDatePrev').css({display:'none'});
			$('#btnNavDateNext').css({display:'inline-block'});
			console.log(listeDates);	
		}else{
			console.log('clic date : pas de date');
			$('.dateLigne').css({display:'none'});
			$('.addDateLigne').css({display:'none'});
			$('.dateFront-save-cancel').css({display:'inline'});
		}
		var monParam=Object.create(paramGeneraux);
		monParam.afficheBtnCommande(true);
		if(afficheActionMaj()){
			console.log("admin montré");
			$('.admin').css({display:'inline'});
			$('#infoDateLigne').css({display:'inline-block'});
			$('#dateFront-show').css({display:'inline-block'});
		}else{
			console.log("admin caché");
			$('.admin').css({display:'none'});
			$('#infoDateLigne').css({display:'none'});
			$('#dateFront-show').css({display:'none'});
		}
		console.debug('nb date =' +listeDates.length);
		return listeDates.length;
				
	},
	donneDernierId:function(){
		console.log('donneDernier id 1');
		var monParamgeneral= Object.create(paramGeneraux);
		$.ajax({
		   url : 'index.php',
		   type : 'GET',
		   async: ParamGeneraux[0]['synchrone'],
		   data : 'action=NewIdDateFront/', 			
		   dataType : 'text',
		   success : function(resultat, statut){
				console.log('donneDernier id 2 '+ resultat);
				sessionStorage['idDate']=resultat.responseText;
				return resultat;
			},
		   error : function(resultat, statut, erreur){
			    sessionStorage['idDate']=resultat.responseText;
				console.log('donneDernier id 3 '+ resultat);
				console.log('erreur fin : '+action);
		   },
		   complete : function(resultat, statut){	
				sessionStorage['idDate']=resultat.responseText;
				console.log('donneDernier id 4 '+ resultat);
				return resultat;
		   }
		})
	},
	donneDescriptif:function(){
		var libelle= "Lignes de front du "+this.getDate()+" nommé : "+this.getDescription();
		return libelle;
	},
	effaceFronts:function(){
		console.log ('------------------------------------------');
		console.log ('liste des polylines');
		console.debug(mymap);
		var mesPolylines=[];
		mesPolylines=mymap._editablePolylines;
		console.log(mesPolylines);
		if(typeof mesPolylines !== "undefined"){
			console.log ('nombre de polylines 1 : '+mesPolylines.length);
			while( mesPolylines.length >0){
				console.log ('polylines supprimé : '+mesPolylines[0]._leaflet_id);
				mymap.removeLayer(mesPolylines[0]);
				console.log ('nombre de polylines 2 : '+mesPolylines.length);
			}
			
		}
		console.log('polylines restants');
		console.log(mesPolylines);
		console.log ('------------------------------------------');
	},
	addDateFront:function(){
		var rep='';
		rep += 'date>' + this.date + '|';
		rep += 'numordre>'+ this.numordre +'|';  // 
		rep += 'valide>'+ this.valide +'|';  // 
		rep += 'description>'+this.description +'|';
		rep += 'idfront>'+this.idfront +'|';		
		appelAjax('addDateFront','nbFront/1/maDate/'+rep,'','text');
		this.donneDernierId();
		this.ajoutePointInitiaux();
		this.recoitListeDate();
	},
	duppliqueDateFront:function(){
		var rep='';
		rep += 'date>' + this.date + '|';
		rep += 'numordre>'+ this.numordre +'|';  // 
		rep += 'valide>'+ this.valide +'|';  // 
		rep += 'description>'+this.description +'|';
		rep += 'idfront>'+this.idfront +'|';		
		appelAjax('addDateFront','nbFront/1/maDate/'+rep,'','text');
		//alert ('id date ancien = '+ this.iddate);
		this.donneDernierId();
		this.iddate=parseInt(sessionStorage['idDate']);

		//alert ('id date nouveau = '+ this.iddate);
		this.ajouteMesLignes(this.iddate);
		this.recoitListeDate();
	},
	donneDateFront:function(laDate){
		//alert('modif 2');
		//if(!this.getModifEnCours()){
			//alert('modif 3');
			console.log('Efface fronts');
			this.effaceFronts();
			var maLigneFront=Object.create(LigneFront);
			maLigneFront.appelAjax('listeLigneDate.html', 'iddatefront/'+sessionStorage['idDate'],'','json');
			this.centreSurDate(laDate);
			console.log("Mode consultation commencé");
		//}
	},
	deleteDateFront:function(maDate){
		if (confirm("Confirmez-vous la demande de suppression d'une date")){
			appelAjax('supprimeDateFront','iddate/'+maDate,'','text');
			maDate.recoitListeDate();
			console.log("Mode suppression terminé");		
		}
	},
	ajouteMesLignes:function(maDate){
		// Ajout des nouvelles lignes
		if(typeof mymap._editablePolylines !== "undefined"){
			mymap._editablePolylines.forEach(function(uneLigneFront) {
				var points = uneLigneFront.getPoints();
				
				var maLigneDate=Object.create(LigneFront); 
				var mesOptions=uneLigneFront._map._editablePolylines[uneLigneFront._map._editablePolylines.length-1]._options;
				
				var couleur=uneLigneFront._path.attributes[1].value;
				var type=mesOptions.formeLigne;
				
				maLigneDate.init(0,couleur,type,false,maDate,0);
				couleur='';
				type='';
				maLigneDate.addLigneDate();	
				maLigneDate.donneDernierId();
				
				var idLigneDate=sessionStorage['idLigneDate'];
				points.forEach(function(point) {
					var latLng = point.getLatLng();
					var monPoint=Object.create(Point);
					monPoint.init(0,latLng.lat,latLng.lng,'',idLigneDate);
					monPoint.addPoint();
				});
			});
		};
	},
	ajoutePointInitiaux:function(maDate){
		//Ami
		var maLigneDate=Object.create(LigneFront); 
		maLigneDate.init(0,'blue','Ami',false,sessionStorage['idDate'],0);
		maLigneDate.addLigneDate();	
		maLigneDate.donneDernierId();
		
		var idLigneDate=sessionStorage['idLigneDate'];		
		var lat = parseFloat(listeFronts[this.idfront]['lat'])+0.001;
		var lng = parseFloat(listeFronts[this.idfront]['lng'])+0.001;
		var monPoint=Object.create(Point);
		monPoint.init(0,lat,lng,1,parseInt(idLigneDate));
		monPoint.addPoint();
		
		//Ennemi
		var maLigneDate=Object.create(LigneFront); 
		maLigneDate.init(0,'red','Ennemi',false,sessionStorage['idDate'],0);
		maLigneDate.addLigneDate();	
		maLigneDate.donneDernierId();
		
		var idLigneDate=sessionStorage['idLigneDate'];		
		var lat = parseFloat(listeFronts[this.idfront]['lat'])-0.001;
		var lng = parseFloat(listeFronts[this.idfront]['lng'])-0.001;
		var monPoint=Object.create(Point);
		monPoint.init(0,lat,lng,1,parseInt(idLigneDate));
		monPoint.addPoint();
		
		//neutre
		var maLigneDate=Object.create(LigneFront); 
		maLigneDate.init(0,'green','Neutre',false,sessionStorage['idDate'],0);
		maLigneDate.addLigneDate();	
		maLigneDate.donneDernierId();
		
		var idLigneDate=sessionStorage['idLigneDate'];		
		var lat = parseFloat(listeFronts[this.idfront]['lat'])+0.001;
		var lng = parseFloat(listeFronts[this.idfront]['lng'])-0.001;
		var monPoint=Object.create(Point);
		monPoint.init(0,lat,lng,1,parseInt(idLigneDate));
		monPoint.addPoint();
	},
	supprimeMesLignes:function(maDate){
		var mesLignes=Object.create(LigneFront);
		mesLignes.supprimeLigne(maDate);
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
		var maDate=this.iddate;
		this.supprimeMesLignes(maDate);
		if(this.iddate=0){
			this.iddate=this.donneDernierId();
			console.log('uneLigneFront id = '+ this.iddate);
		};
		this.ajouteMesLignes(maDate);
		
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
    appelAjax:function(action, param, monDataType){
		if(param.length>0){
			madata='action='+action+'/'+param;
			console.log ('action = '+madata);
		}else{
			madata='action='+action
		}
		monDataType===''? monDataType='json' : monDataType=monDataType;
		listeLigneFront.splice(0,listeLigneFront.length);		
		var monParamgeneral= Object.create(paramGeneraux);
		
		$.ajax({
		   url : 'index.php',
		   type : 'GET',
		   async: ParamGeneraux[0]['synchrone'],
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
				console.log('nb ligne avt :'+listeLigneFront.length);
				listeLigneFront.splice(0,listeLigneFront.length);
				listePoint.splice(0,listePoint.length);
				console.log('nb dates  apr :'+listeLigneFront.length);
				console.log('ligne date');
				console.debug(resultat);
				console.log('nb lignes dates prévues :'+resultat.responseJSON.length);
				if(resultat.responseJSON.length>0){
					for (var i=0;i<resultat.responseJSON.length;i++){
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
						console.log('Fin de Ligne de front JSON '+resultat.responseJSON[i].idlignefront);						
					};
					listeLigneFront[uneLigneFront['idlignefront']].montreMoi();	
				};
			}
		});
	},
	donneCoordonneesMesPoints:function(maLigne){
		var listeCoordonneesUnFront=[];
		var uneCoordonnee;
		console.log('id front ='+maLigne+' nombre de points '+listePoint.length);
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
			newPolylines: frontDraggable(),
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
			console.log('recherche de la ligne '+monLigneFront.iddatefront+' ligne num = '+monLigneFront.idlignefront);
			var mesPoints=Object.create(Point);			
			mesPoints.appelAjax('listePoint.html', 'idlignefront/'+monLigneFront.idlignefront,'json');
			console.log('nombre de points '+listePoint.length);
			var monMaxMarkers=1;
			var newAutorise=false;
			var polylineOptions;
			if(frontDraggable()){
				var polylineOptions = {
					newPolylines: true,
					contextmenu: false,
					maxMarkers: 1000,
					color: monLigneFront.couleur,
					weight: 5,
					dashArray: '10,7',
					lineJoin:'round'				
				};
				console.log('front draggable = '+ frontDraggable());
			}else{
				var polylineOptions = {
					newPolylines: true,
					contextmenu: false,
					color: monLigneFront.couleur,
					weight: 5,
					dashArray: '10,7',
					lineJoin:'round'				
				};
			};
			console.log ('coordonnées de me points = '+monLigneFront.donneCoordonneesMesPoints(monLigneFront.idlignefront));
			uneLigneFront = L.Polyline.PolylineEditor(monLigneFront.donneCoordonneesMesPoints(monLigneFront.idlignefront), polylineOptions).addTo(mymap);
			console.log('id une ligne de front = '+uneLigneFront._leaflet_id);
		});
		
	},
	donneDernierId:function(){
		console.log('-------------------------------'); 
		console.log('donne dernier ID ligne date pour points ');
		console.log('-------------------------------'); 
					
		var monParamgeneral= Object.create(paramGeneraux);
		$.ajax({
		   url : 'index.php',
		   type : 'GET',
		   async: ParamGeneraux[0]['synchrone'],
		   data : 'action=NewIdLigneFront/', 			
		   dataType : 'text',
		   success : function(resultat, statut){
			},
		   error : function(resultat, statut, erreur){
				console.log('erreur fin : '+action);
				console.log('Resultat maxId '+resultat.responseText);
				var monResultat=resultat.responseText;
				sessionStorage['idLigneDate']=resultat.responseText;
				return monResultat;
		   },
		   complete : function(resultat, statut){	
			    console.log('Resultat maxId '+resultat.responseText);
				var monResultat=resultat.responseText;
				sessionStorage['idLigneDate']=resultat.responseText;
				return monResultat;
		   }
		})
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
		console.log('-------------------------------'); 
		console.log('Supprime ligne demandée'+iddate);
		console.log('-------------------------------'); 
		appelAjax('supprimeLigneDate', 'iddatefront/'+iddate,'json');
	}	
};
var modifieLaLigne= function(e){
	console.debug('modifie une ligne de front : '+e);
	
};
var  supprimeUneLigne = function(e){
	console.debug('supprime une ligne de front : '+e);
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
    appelAjax:function(action, param, monDataType){
		if(param.length>0){
			madata='action='+action+'/'+param;
			console.log ('action = '+madata);
		}else{
			madata='action='+action
		}
		monDataType===''? monDataType='json' : monDataType=monDataType;
		var monParamgeneral= Object.create(paramGeneraux);
		listePoint.splice(0,listePoint.length);
		$.ajax({
		   url : 'index.php',
		   type : 'GET',
		   async: ParamGeneraux[0]['synchrone'],
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
				console.log('liste des points');
				console.debug(resultat);
				
				for (var p=0;p<resultat.responseJSON.length;p++){
					console.log('Points JSON '+resultat.responseJSON[p].idlignefront);
					var unPoint=Object.create(Point);
					unPoint.init(
						resultat.responseJSON[p].idpoint,
						resultat.responseJSON[p].lat,
						resultat.responseJSON[p].lng,
						resultat.responseJSON[p].idmarqueur,
						resultat.responseJSON[p].idlignefront
					);
					listePoint[unPoint['idpoint']]=unPoint;
				}
				console.debug('nb point=' +listePoint.length);
			}
		});
	},
	addPoint:function(){
		var rep='';
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
	
	console.log('fin chgt fronts');
	
	//$('#mapid').css({height:'700px'});
	
	//positionnement des combats
	mesFronts=Object.create(Front);
	mesFronts.montreTout();
	//listeFronts.forEach(function(unFront){
	//	centreMonFront=unFront.montreMoi( FormeLigne[4].icone);
	//});
	
	
	
		/*******************************************
			gestion des evenements de la feuille
		********************************************/
		


	document.getElementById("dateLigne").addEventListener("change", function(e){
		
		// objet jQuery contenant l'option sélectionnée
		var jObj = $("option", this).filter(":selected"), 
			id = jObj.get(0).id, // id
			n = id.slice(1), // numéro
			v = jObj.val(), // value
			t = jObj.text(); // texte
			console.log('date ligne option value = '+v);
			console.log('date ligne option value = '+t);
		sessionStorage['idDate']=parseInt(v);
		console.log("Choix date ligne en cours");
		maDate=Object.create(DateFront);
		var indice=maDate.rechercheDate(parseInt(v));
		console.log('id Date = '+sessionStorage['idDate'] +'dans liste = '+maDate.description);
		console.log('id Date = '+sessionStorage['idDate'] +'dans liste = '+maDate.date);
		$('#dateFront-show').css({display:'inline-block'});
		$('.dateFrontAction ').css({display:'inline-block'});
		$('.dateFront-save-cancel').css({display:'none'});
		$('.detailFront').css({display:'none'});
		$("#addDescriptionLigne").val(maDate.description);
		$("#textDescriptifLigne").html(maDate.donneDescriptif());
		$('.textDescriptifLigne').css({display:'inline-block'});
		
		var maDateTexte= maDate.date.split("/");
		
		$("#addDateLigne").val(maDateTexte[2]+'-'+(maDateTexte[1])+'-'+maDateTexte[0]);
		console.log ('nouvelle date = '+maDateTexte[2]+'-'+(maDateTexte[1])+'-'+maDateTexte[0]);
		
		var maDate = Object.create(DateFront);
		maDate.donneDateFront(parseInt(sessionStorage['idDate']));

	});

	document.getElementById("btnNavDatePrev").addEventListener("click", function(e){
		var maDate= Object.create(DateFront);
		var v = maDate.prev();	
		var indice=maDate.rechercheDate(parseInt(v));
		$('.detailFront').css({display:'none'});
		$("#textDescriptifLigne").html(maDate.donneDescriptif());
		$('.textDescriptifLigne').css({display:'inline-block'});	
	});
	
	document.getElementById("btnNavDateNext").addEventListener("click", function(e){
		var maDate= Object.create(DateFront);
		var v = maDate.next();
		var indice=maDate.rechercheDate(parseInt(v));
		$('.detailFront').css({display:'none'});
		$("#textDescriptifLigne").html(maDate.donneDescriptif());
		$('.textDescriptifLigne').css({display:'inline-block'});			
	});
	
	document.getElementById("fermeCommande").addEventListener("click", function(e){
		var maDate= Object.create(DateFront);
		maDate.effaceFronts();
		maCarte=donneCarte();
		maCarte.setView([ParamGeneraux[0]['latCentre'],ParamGeneraux[0]['lngCentre'] ],ParamGeneraux[0]['zoom']);
		$('#btnCommande').css({display:'none'});
	});
	
	document.getElementById("dateFront-add-button").addEventListener("click", function(e){
		var maDate = Object.create(DateFront);
		maDate.setModifEnCours(true);
		$('.dateFrontAction').css({display:'none'});
		$('.dateLigne').css({display:'none'});
		$('.textDescriptifLigne').css({display:'none'});
		$('#infoDateLigne').css({display:'inline-block'});
		$('.dateFront-save-cancel').css({display:'inline'});
		$('#addDateLigne').css({display:'inline-block'});
		$('#addDescriptionLigne').css({display:'inline-block'});
		$('.addDateLigne').css({display:'inline-block !important'});
		//$('.dateFront-save-button').css({display:'inline-block'});
		var mesParamsGeneraux=Object.create(ParamGeneraux);
		ParamGeneraux[0].actionEnCours='ajoutDate'; 
		console.log("Mode ajout commencé");
	});
	document.getElementById("dateFront-dupplicate-button").addEventListener("click", function(e){		
		console.log("Mode dupplication terminé");
		var maDate = Object.create(DateFront);
		maDate.setModifEnCours(true);
		var mesParamsGeneraux=Object.create(ParamGeneraux);
		ParamGeneraux[0].majLigneEnCours=true;
		ParamGeneraux[0].actionEnCours='dupplicationDate'; 
		maDate.donneDateFront(parseInt(sessionStorage['idDate']));	
		var iddate=0;
		$('.dateFrontAction').css({display:'none'});
		$('.textDescriptifLigne').css({display:'none'});
		$('.dateLigne').css({display:'none'});
		$('.dateFront-save-cancel').css({display:'inline'});		
		$('#infoDateLigne').css({display:'inline-block'});
		//$('#dateFront-save-button').css({display:'inline-block'});		
		$('#addDateLigne').css({display:'inline-block'});
		$('#addDescriptionLigne').css({display:'inline-block'});
		$('.addDateLigne').css({display:'inline-block !important'});
	});
	
	document.getElementById("dateFront-update-button").addEventListener("click", function(e){
		var maDate = Object.create(DateFront);
		maDate.setModifEnCours(true);
		var mesParamsGeneraux=Object.create(ParamGeneraux);
		//mesParamsGeneraux.setMajLigneEnCours(true);
		ParamGeneraux[0].majLigneEnCours=true;
		ParamGeneraux[0].actionEnCours='modifDate'; 
		maDate.donneDateFront(parseInt(sessionStorage['idDate']));	
		$('.dateFrontAction').css({display:'none'});
		$('.addDateLigne').css({display:'inline-block !important'});
		$('.dateLigne').css({display:'none'});
		$('.dateFront-save-cancel').css({display:'inline'});
		$('#infoDateLigne').css({display:'inline-block'});
		$('#addDateLigne').css({display:'inline-block'});
		$('#addDescriptionLigne').css({display:'inline-block'});
		$('.textDescriptifLigne').css({display:'none'});
		console.log("Mode modif commencé");
		
	});
	
	document.getElementById("dateFront-delete-button").addEventListener("click", function(e){
		var maDate = Object.create(DateFront);
		maDate.deleteDateFront(sessionStorage['idDate']);
	});
	
	document.getElementById("dateFront-cancel-button").addEventListener("click", function(e){
		$('.dateFrontAction').css({display:'inline-block'});
		$('.dateLigne').css({display:'inline-block'});
		$('.addDateLigne').css({display:'none'});
		$('.dateFront-save-cancel').css({display:'none'});
		console.log("Mode ajout et modif annulés");
		var maDate = Object.create(DateFront);
		//var iddate=0;
		sessionStorage['operationDate']=='ajoutDate' ? iddate=0 : iddate= parseInt(sessionStorage['idDate']);
		maDate.init(iddate,$('#addDescriptionLigne').val(),false,0,$('#addDateLigne').val(),sessionStorage['idFront']);
		//var mesParamsGeneraux=Object.create(ParamGeneraux);
		maDate.setModifEnCours(false);		
		//mesParamsGeneraux.setMajLigneEnCours(false);
		ParamGeneraux[0].actionEnCours="";
		ParamGeneraux[0].majLigneEnCours=false;
		maDate.donneDateFront(parseInt(sessionStorage['idDate']));	
	});
	
	document.getElementById("dateFront-save-button").addEventListener("click", function(e){
		$('.dateFrontAction').css({display:'inline-block'});
		$('.dateLigne').css({display:'inline-block'});
		$('.addDateLigne').css({display:'none'});
		$('.dateFront-save-cancel').css({display:'none'});
			console.log("Mode ajout et modif terminés");
		var maDate = Object.create(DateFront);
		var iddate=0;
		sessionStorage['operationDate']=='ajoutDate' ? iddate=0 : iddate= parseInt(sessionStorage['idDate']);
		maDate.init(iddate,$('#addDescriptionLigne').val(),false,0,$('#addDateLigne').val(),sessionStorage['idFront']);
		var mesParamsGeneraux=Object.create(ParamGeneraux);
		if(ParamGeneraux[0].actionEnCours==='ajoutDate'){
			maDate.addDateFront() 
		}else if(ParamGeneraux[0].actionEnCours==='modifDate'){
     		maDate.updateDateFront(parseInt(sessionStorage['idDate']));
		}else{
			maDate.duppliqueDateFront() ;
		}
		maDate.setModifEnCours(false);
		
		//mesParamsGeneraux.setMajLigneEnCours(false);
		ParamGeneraux[0].actionEnCours="";
		ParamGeneraux[0].majLigneEnCours=false;
		maDate.donneDateFront(parseInt(sessionStorage['idDate']));	
	});

	document.getElementById("detailFront-save-button").addEventListener("click", function(e){
		$('.detailFront').css({display:'none'});
		var monParam=Object.create(paramGeneraux);
		monParam.afficheBtnCommande(false);
		console.log("Mode modif terminé");
		var monUser=Object.create(User);
		
		var monFront = Object.create(Front);
		var idfront=0;
		var monCentre=donneCarte().getCenter();
		sessionStorage['operationFront']=='update' ? idfront=sessionStorage['idfront'] : idfront= 0;
		monFront.init(idfront,$('#nomDetailFront').val(),donneCarte().getZoom(),String(monCentre.lat),String(monCentre.lng),false,listeUser[0].getIdUser(),$('#descriptionDetailFront').val());
		sessionStorage['operationFront']=='update' ? monFront.updateFront(sessionStorage['idfront']) : monFront.updateFront() ;
		monFront.setModifEnCours(false);
	});	
	
	document.getElementById("btnOuiFront").addEventListener("click", function(e){
		console.log("front oui ");
		$('#addFront').css({display:'none'});
		var newFront= Object.create(Front);
		var monCentre=donneCarte().getCenter();
		console.log("centre carte "+donneCarte().getZoom());
		newFront.init(0,$('#nomFront').val(),donneCarte().getZoom(),String(monCentre.lat),String(monCentre.lng),false,listeUser[0].getIdUser(),$('#descriptionFront').val());
		newFront.addFront();
		newFront.montreMoi();
	});
	document.getElementById("btnAnnulerFront").addEventListener("click", function(e){
		
		console.log("front action  annulée ");
		$('#addFront').css({display:'none'});
		
	});
}


