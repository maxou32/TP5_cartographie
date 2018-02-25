var listeLeaflet=[];
var Leaflet={
	init:function(idFront, idCarte){ 
		this.idFront=idFront;
		this.idCarte=idCarte;
	}
};

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

function integreParamGeneraux(){
	//var tempParam=Object.create(paramGeneraux);
	//var toto={};
	appelAjax('paramGenerauxCarte');
	/*
	console.debug('toto '+toto.length);	
	var tempParam = new paramGeneraux(toto);
	//var toto = new paramGeneraux('5','48.777006','6.354958','18','256','1','Web-Max &copy; https://web-max.fr','GEOGRAPHICALGRIDSYSTEMS.MAPS');

	//ParamGeneraux.push(new paramGeneraux.init());
	console.log(tempParam);	
	ParamGeneraux['zoom']=tempParam['zoom'];
	ParamGeneraux['latCentre']=tempParam['latCentre'];
	ParamGeneraux['lngCentre']=tempParam['lngCentre'];
	ParamGeneraux['maxZoom']=tempParam['maxZoom'];
	ParamGeneraux['tileSize']=tempParam['tileSize'];
	ParamGeneraux['boxZoom']=tempParam['boxZoom'];
	ParamGeneraux['attribution']=tempParam['attribution'];
	ParamGeneraux['layer']=tempParam['layer'];
	*/
};

var listeFronts=[];	
var Front={
	init:function(idfront,nom,valide,dateDebut,dateFin,idauteur,description){
		this.idfront=idfront;
		this.nom=nom;
		this.valide=valide;
		this.dateDebut=dateDebut;
		this.dateFin=dateFin;
		this.idauteur=idauteur;
		this.description=description;
	},
	getNom:function(){
		return this.nom;
	},
	getDescription:function(){
		return this.description;
	}
};
	
var listeCartes=[];
var Carte={
	init:function(idcarte, idfront, lat, lng,layeroption, nom, projection){
		this.idcarte=idcarte;
		this.idfront=idfront;
		this.lat=lat;
		this.lng=lng;
		this.layerOption=layeroption;
		this.nom=nom;
		this.projection=projection;
	},
	getLat:function(){
		return this.lat;
	},
	getLng:function(){
		return this.lng;
	},
	getIdFront:function(){
		return this.idfront;
	},
	getIdCarte:function(){
		return this.idcarte;
	},
	montreMoi:function(mymap, formeligne){
		console.log('lat = '+this.lat);
		var centreCarte = L.marker( 
			[this.lat,this.lng], 
			{
				draggable: true, 
				icon:  L.icon({
					iconUrl:formeligne,		//FormeLigne[4].icone
					iconSize: [24,24],
					iconAnchor: [12,12],
					popupAnchor:  [0,-24]
					}),
				riseOnHover:true,
				alt: 'Point central du front',
				title: 'monFront.getNom()'
			}
		).addTo(mymap);	
		return centreCarte;
	}
};

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

function ouvrirCarte(){
	integreParamGeneraux();
	mymap = L.map("mapid",{
	center : [ ParamGeneraux[0]['latCentre'],ParamGeneraux[0]['lngCentre'] ],
			zoom: ParamGeneraux[0]['zoom'] 
			}
		);  //
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
	return mymap;
}

function appelAjax(action){
	$.ajax({
       url : 'index.php',
       type : 'GET',
	   async: false,
	   data : 'action='+action, 			//paramGenerauxCarte',
       dataType : 'json',
       success : function(resultat, statut){
		    //alert('réussite');
			console.debug(resultat);
		},

       error : function(resultat, statut, erreur){
			//alert ('erreur : '+action);
			console.log('erreur deb : '+action);
			
			console.debug(resultat);
			//console.debug(erreur);
			console.log('erreur fin : '+action);
			
            return resultat; 
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
						resultat.responseJSON[i].valide,
						resultat.responseJSON[i].dateDebut,
						resultat.responseJSON[i].dateFin,
						resultat.responseJSON[i].idauteur,
						resultat.responseJSON[i].description
					);
					listeFronts[unFront['idfront']]=unFront;
					console.log('id front =' + unFront['idfront']);
				}
				console.log('nb front =' +listeFronts.length);
			}else if(action==="listeCarte.html"){
				console.log('carte');
				console.debug(resultat);
				console.log('nb cartes prévu :'+resultat.responseJSON.length);
				for (i=0;i<resultat.responseJSON.length;i++){
					console.log('Cartes JSON '+resultat.responseJSON[i].idcarte);
					var uneCarte=Object.create(Carte);
					uneCarte.init(
						resultat.responseJSON[i].idcarte,
						resultat.responseJSON[i].idfront,
						resultat.responseJSON[i].lat,
						resultat.responseJSON[i].lng,
						resultat.responseJSON[i].layeroption,
						resultat.responseJSON[i].nom,
						resultat.responseJSON[i].projection
					);
					listeCartes[uneCarte['idcarte']]=uneCarte;
					console.log('id carte =' + uneCarte['idcarte']);
				}
				console.log('nb cartes =' +listeCartes.length);
			}		
        }
    });
	
}


window.onload = function () {

	var mymap=ouvrirCarte();
	
	// chargement des fronts
	appelAjax('listeFront.html');	
	console.log('fin chgt fronts');
	
	// chargement des cartes
	appelAjax('listeCarte.html');
	console.log('fin chgt carte');

	
	//affichage carte
	console.log('nombre de cartes ='+listeCartes.length);
	console.debug('nombre de cartes ='+listeCartes[12]);
	
	//for (i=0; i< listeCartes.length;i++){
	for (var idCarte in listeCartes){
		console.log('itération ='+i);
		//var maCarte=Object.create(Carte);
		//maCarte=listeCartes[i];	
		//centreMaCarte=listeCartes['0'].maCarte.montreMoi(mymap, FormeLigne[4].icone);
		centreMaCarte=listeCartes[idCarte].montreMoi(mymap, FormeLigne[4].icone);
		
		var newLeaflet= Object.create(Leaflet);
		newLeaflet.init(listeCartes[idCarte].getIdFront(),listeCartes[idCarte].getIdCarte());
		listeLeaflet[this._leaflet_id]=newLeaflet;
		
		var monFront=Object.create(Front);
		var idFront=listeCartes[idCarte].getIdFront();
		monFront=listeFronts[idFront];	
		
		centreMaCarte.bindPopup("<b>"+monFront.getNom()+" <i>"+listeCartes[idCarte].getIdFront()+"</i></b><br />"+monFront.getDescription()+"<br />"+"<button class='point-show-button' title='affiche le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-visible-32.png'></button>"+"<button class='point-update-button' title='modifie le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'></button>"+"<button class='point-delete-button' title='supprime le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> </button>").openPopup();
		centreMaCarte.on("popupopen", onPopupOpenCentreCarte);
		
	};
	
	console.log('ENFIN FIN de FAIM');
	
	function onPopupOpenCentreCarte(){
		var tempCentreCarte=this;
		//alert ('id marqueur centreCarte = '+tempCentreCarte._leaflet_id+ 'idfront = '+ListeLeafLet(tempCentreCarte._leaflet_id).['idCarte']);
		console.log('id marqueur centreCarte = ');
		
	}
	
}