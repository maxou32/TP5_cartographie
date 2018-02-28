/*******************************************
		globales
********************************************/
	/*******************************************
		variables
	********************************************/
var mymap;
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

function ouvrirCarte(){
	appelAjax('paramGenerauxCarte','');
	
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
	//return mymap;
}

function appelAjax(action, param){
	if(param.length>0){
		madata='action='+action+'/'+param;
		console.log ('action = '+madata);
	}else{
		madata='action='+action
	}
	$.ajax({
       url : 'index.php',
       type : 'GET',
	   async: false,
	   data : madata, 			
       dataType : 'json',
       success : function(resultat, statut){
		    //alert('réussite');
			console.debug(resultat);
		},

       error : function(resultat, statut, erreur){
			//alert ('erreur : '+action);
			console.log('erreur deb : '+erreur);
			
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
						resultat.responseJSON[i].zoom,
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
			}else if(action==="listeDate.html"){
				console.log('nb dates  avt :'+listeDates.length);
				listeDates.splice(0,listeDates.length);
				console.log('nb dates  apr :'+listeDates.length);
				console.log('date');
				console.debug(resultat);
				//console.log('nb dates prévues :'+resultat.responseJSON.length);
				for (i=0;i<resultat.responseJSON.length;i++){
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
				listeDates.forEach(function(madate){
					//alert('clic date'+madate.getIddate());
					var newOption = new Option(madate.getDate(), madate.getIddate(), false, false);
					$('#dateLigne').append(newOption).trigger('change');
					$('#btnCommande').css({display:'inline-block'});
				});
				console.debug('nb date =' +listeDates.length);
			}else if(action==='listeLigneDate.html'){
				console.log('nb ligne avt :'+listeLigneFront.length);
				listeLigneFront.splice(0,listeLigneFront.length);
				listePoint.splice(0,listePoint.length);
				console.log('nb dates  apr :'+listeLigneFront.length);
				console.log('ligne date');
				console.debug(resultat);
				//console.log('nb dates prévues :'+resultat.responseJSON.length);
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
				}
				listeLigneFront[uneLigneFront['idlignefront']].montreMoi();
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
	init:function(idFront, idCarte){ 
		this.idFront=idFront;
		this.idCarte=idCarte;
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
	/*******************************************
		liste de cartes
	********************************************/
var listeCartes=[];
var Carte={
	init:function(idcarte, zoom, idfront, lat, lng,layeroption, nom, projection){
		this.idcarte=idcarte;
		this.zoom=zoom;
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
	getZoom:function(){
		return this.zoom;
	},
	getParamCarteUnFront(){
		for(i=0;i<listeCartes.length;i++){
			console.log('getParamCarteUnFront 1 = '+this.idfront+'nb cartes ='+listeCartes.length);
			if( typeof  listeCartes[i]!=="undefined"){
				if (listeCartes[i].getIdFront()===this.idfront){
					console.log('getParamCarteUnFront 2 = '+listeCartes[i].getLat());
					var paramCarte=[];
					paramCarte['lat']=listeCartes[i].getLat();
					paramCarte['lng']=listeCartes[i].getLng();
					paramCarte['zoom']=listeCartes[i].getZoom();
					return paramCarte;
				}
			}
		}
	},
	montreMoi:function(formeligne){
		
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
		this.creePointeur(centreCarte);
		return centreCarte;
	},
	creePointeur:function(centreCarte){
		var newLeaflet= Object.create(Leaflet);
		
		newLeaflet.init(this.getIdFront(),this.getIdCarte());
		//listeLeaflet[this._leaflet_id]=newLeaflet;
		listeLeaflet[centreCarte._leaflet_id]=newLeaflet;
		console.log ('taille leaflet = '+listeLeaflet.length);
		console.debug(listeLeaflet);
		
		var monFront=Object.create(Front);
		var idFront=this.getIdFront();
		monFront=listeFronts[idFront];	
		
		centreCarte.bindPopup("<b>"+monFront.getNom()+" <i>"+this.getIdFront()+"</i></b><br />"+monFront.getDescription()+"<br />"+"<button class='date-show-button' title='affiche les dates'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-chronometre-32.png'></button>"+"<button class='ligne-update-button' title='modifie le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'></button>"+"<button class='ligne-delete-button' title='supprime le front'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> </button>").openPopup();
		
		centreCarte.on("popupopen", this.onPopupOpenCentreCarte);
		
	},
	onPopupOpenCentreCarte:function(){
		var tempCentreCarte=this;
		$(".date-show-button:visible").click(function () {
			console.log ('id leaflet = '+tempCentreCarte._leaflet_id);			
			appelAjax('listeDate.html','idfront/'+listeLeaflet[tempCentreCarte._leaflet_id].getIdFront(),'');
			
		});
		$(".ligne-show-button:visible").click(function () {
			
		});
		$(".ligne-update-button:visible").click(function () {
			
		});
		$(".ligne-delete-button:visible").click(function () {
			
		});
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
	},
	getIddate:function(){
		return this.iddate;
	},
	getDescription:function(){
		return this.description;
	},
	getDate:function(){
		return this.date;
	},
	getIdfront:function(){
		return this.idfront;
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
	montreMoi:function(){
		console.log('recherche des points de la ligne '+ this.idlignefront);
		listeLigneFront.forEach(function(monFront){
			appelAjax('listePoint.html', 'idlignefront/'+monFront.idlignefront);
			console.log('nombre de points '+listePoint.length);
			uneLigneFront =  L.polyline
				(monFront.donneCoordonneesMesPoints(monFront.idlignefront),			//coordonnees,
					{
					color: monFront.couleur,
					weight: 5,
					dashArray: '10,7',
					lineJoin:'round'
					}
				).addTo(mymap);
			console.log('id une ligne de front = '+uneLigneFront._leaflet_id);
			
			uneLigneFront.bindPopup("<b>"+" <i>"+uneLigneFront._leaflet_id+"</i></b><br />"+"<button class='ligne-update-button' title='modifie la lignet'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-modifier-32.png'></button>"+"<button class='ligne-delete-button' title='supprime la ligne'/> <img src='https://web-max.fr/gesFront/public/sdk-ol/img/icons8-poubelle-32.png'> </button>").openPopup();	
			uneLigneFront.on("popupopen", this.onPopupLigneFrontOpen);
		})	
			
		var monFrontMere=listeDates[this.iddatefront].getIdfront();
		//var maCarteMere=Object.create(Carte);
		console.log('id front mere '+monFrontMere);
		var paramCarte=[];
		paramCarte=listeCartes[monFrontMere].getParamCarteUnFront();
		console.debug("paramCarte = "+paramCarte);
		mymap.setView([paramCarte['lat'],paramCarte['lng']],paramCarte['zoom']);

		
	},
	onPopupLigneFrontOpen:function(){
		var tempCentreCarte=this;
		$(".date-show-button:visible").click(function () {
			
		});
		$(".ligne-show-button:visible").click(function () {
			
		});
		$(".ligne-update-button:visible").click(function () {
			
		});
		$(".ligne-delete-button:visible").click(function () {
			
		});
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
	}
};

/*******************************************
		Main
********************************************/


window.onload = function () {

	var mymap=ouvrirCarte();
	
	// chargement des fronts
	appelAjax('listeFront.html', '','');	
	console.log('fin chgt fronts');
	
	// chargement des cartes
	appelAjax('listeCarte.html', '','');
	console.log('fin chgt carte');

	
	//affichage carte
	console.log('nombre de cartes ='+listeCartes.length);
	
	//positionnement des combats
	for (var idCarte in listeCartes){
		centreMaCarte=listeCartes[idCarte].montreMoi( FormeLigne[4].icone);
	};
	
	
	
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
	document.getElementById("dateFront-show-ligne").addEventListener("click", function(e){
		console.log('id Date = '+sessionStorage['idDate']);
		appelAjax('listeLigneDate.html', 'iddatefront/'+sessionStorage['idDate'],'');
		$('#btnAjoutLigne').css({display:'inline-block'});
		console.log("Mode consultation commencé");
	});
	document.getElementById("dateFront-add-button").addEventListener("change", function(e){
		$('#btnAjoutLigne').css({display:'inline-block'});
		console.log("Mode ajout commencé");
	});
		
}