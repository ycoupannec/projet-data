		/*affichage de la map et définition du point d'arrivée sur la carte*/
		var mymap = L.map('mapid').setView([48.820514, 2.303955], 13);

		/*type de "tiles" pour la map, on peut en changer (skin)*/
		L.tileLayer('https://api.mapbox.com/styles/v1/benoitm/ciy5sprke005d2rpb6dxry2ah/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYmVub2l0bSIsImEiOiJjaXk1c24ycGYwMDJwMzNyamhmaXc2dTNnIn0.065FxCTP4WiqVfnlubCMmA', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="http://mapbox.com">Mapbox</a>',
		id: 'mapbox.streets'
		}).addTo(mymap);
		
		

		
		/*infos sur un film en "dur"*/
		var infoFilm = 
			[
				{
					titre: "UNE VIE A T'ATTENDRE",
					realisateur: "THIERRY KLIFA",
					date: "25/03/2003",
					adresse:"PLACE DE DUBLIN 75008 Paris France",
					coord: [48.728228, 2.359775],
					text: "Commentaires sur cette scène 01"
				},
				
				{
					titre: "UNE VIE A T'ATTENDRE",
					realisateur: "THIERRY KLIFA",
					date: "25/03/2003",
					adresse:"PARC MONTSOURIS 75014 Paris France",
					coord: [48.799388, 2.259861],
					text: "Commentaires sur cette scène 02"
				},
				
				{
					titre: "UNE VIE A T'ATTENDRE",
					realisateur: "THIERRY KLIFA",
					date: "25/03/2003",
					adresse:"AVENUE REILLE 75014 Paris France",
					coord: [48.820514, 2.303955],
					text: "Commentaires sur cette scène 03"
				},
				
				{
					titre: "UNE VIE A T'ATTENDRE",
					realisateur: "THIERRY KLIFA",
					date: "25/03/2003",
					adresse:"AVENUE DE CHOISY 75013 Paris France",
					coord: [48.820538, 2.342833],
					text: "Commentaires sur cette scène 04"
				},

				{
					titre: "UNE VIE A T'ATTENDRE",
					realisateur: "THIERRY KLIFA",
					date: "25/03/2003",
					adresse:"RUE DE TOLBIAC 75013 Paris France",
					coord: [48.823777, 2.364813],
					text: "Commentaires sur cette scène 05"
				}
			];
	

		for (var i = 0; i < infoFilm.length; i++) 
			{
				var numeroModal=[i];
				
				addMarker(infoFilm[i].titre, infoFilm[i].coord, infoFilm[i].adresse, infoFilm[i].realisateur, infoFilm[i].date, infoFilm[i].text, numeroModal);
				
				createButtonModal(infoFilm[i].titre, infoFilm[i].coord, infoFilm[i].adresse, infoFilm[i].realisateur, infoFilm[i].date, infoFilm[i].text, numeroModal);
				
				createModal(infoFilm[i].titre, infoFilm[i].coord, infoFilm[i].adresse, infoFilm[i].realisateur, infoFilm[i].date, infoFilm[i].text, numeroModal);
				
			}
		
		
		function addMarker(titre,coord,adresse,realisateur,date,text, numeroModal)
			{
				/*var popupContent = '<p>'+titre+'</p>'+'<p>'+realisateur+'</p>'+'<p>'+adresse+'</p>'+'<p>'+date+'</p>'+'<p>'+text+'</p>'+'<p>'+numeroModal+'</p>';
				var popup = L.popup().setContent(popupContent);*/
				var marker = L.marker(coord).addTo(mymap).on('click', function(e) 
					{
						alert(adresse);

					});
				console.log(marker);
				/*marker.bindPopup(popup);*/
			}




		function createButtonModal(titre, coord, adresse, realisateur, date, text, numeroModal)
			{
				
				/*creation du bouton*/
				var modalButton = document.createElement("button");
				modalButton.setAttribute("id",numeroModal);
				modalButton.setAttribute("class","btn btn-primary");
				modalButton.setAttribute("data-toggle","modal");
				modalButton.setAttribute("data-target","#modal"+numeroModal);
				
				/*texte du bouton*/
				var textButton = document.createTextNode("Boutton "+numeroModal);
				modalButton.appendChild(textButton);
				
				/*on ajoute le bouton à la div correspondante*/
				var divButton = document.getElementById("positionButtonModal");
				divButton.appendChild(modalButton);
				
			}
		

		function createModal(titre, coord, adresse, realisateur, date, text, numeroModal)
			{
				
				/*creation de la modal*/
				var modal = document.createElement("div");
				modal.setAttribute("id","modal"+numeroModal);
				modal.setAttribute("class","modal fade");
				modal.setAttribute("tabindex","-1");
				modal.setAttribute("role","dialog");
				modal.setAttribute("aria-labelledby","exampleModalLongTitle");
				modal.setAttribute("aria-hidden","true");
				
				
				/*premiere sous-div de dialog*/
				var modalDialog = document.createElement("div");
				modalDialog.setAttribute("class","modal-dialog");
				modalDialog.setAttribute("role","document");
				modal.appendChild(modalDialog);
				
				
				/*deuxième sous-div de contenu*/
				var modalContent = document.createElement("div");
				modalContent.setAttribute("class","modal-content");
				modalDialog.appendChild(modalContent);
				
				
				/*sous-div de modalContent pour le header*/
				var modalHeader = document.createElement("div");
				modalHeader.setAttribute("class","modal-header");
				modalContent.appendChild(modalHeader);
					/*titre du film dans le header*/
					var filmTitle = document.createElement("h5");
					var filmTitleText = document.createTextNode(titre);
					filmTitle.appendChild(filmTitleText);
					modalHeader.appendChild(filmTitle);
				
				
				/*sous-div de ModalContent pour le body*/
				var modalBody = document.createElement("div");
				modalBody.setAttribute("class","modal-body");
				modalContent.appendChild(modalBody);
					/*realisateur du film dans le body*/
					var filmReal = document.createElement("p");
					var filmRealText = document.createTextNode(realisateur);
					filmReal.appendChild(filmRealText);
					modalBody.appendChild(filmReal);
					/*adresse du film dans le body*/
					var filmAdress = document.createElement("p");
					var filmAdressText = document.createTextNode(adresse);
					filmAdress.appendChild(filmAdressText);
					modalBody.appendChild(filmAdress);
					/*date du film dans le body*/
					var filmDate = document.createElement("p");
					var filmDateText = document.createTextNode(date);
					filmDate.appendChild(filmDateText);
					modalBody.appendChild(filmDate);
				
				
				/*sous-div de ModalContent pour le footer*/
				var modalFooter = document.createElement("div");
				modalBody.setAttribute("class","modal-footer");
				modalContent.appendChild(modalFooter);
					/*bouton pour le footer*/
					var modalButtonFooter = document.createElement("button");
					modalButtonFooter.setAttribute("type","button");
					modalButtonFooter.setAttribute("class","btn btn-secondary");
					modalButtonFooter.setAttribute("data-dismiss","modal");
					var modalButtonText = document.createTextNode("Revenir à la carte");
					modalButtonFooter.appendChild(modalButtonText);
					modalFooter.appendChild(modalButtonFooter);
				
	
				/*on positionne la modale sur la div appropriée*/
				var divModal = document.getElementById("positionModal");
				divModal.appendChild(modal);
				
			}