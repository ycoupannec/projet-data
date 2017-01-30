function geneImage(idLieu,commentaire){
	//console.log($image,$type,$sizeTop,$sizeBot,$clrTop,$clrBot,$textTop,textBot);
	$.get('include/addCommentaire.php',{

		idLieu:idLieu,
		commentaire:commentaire,

	})
    .done(function(data) {
    	// $("#content-image").empty();
    	// $("#content-image").html('<img id="image" src="data:image/jpeg;base64,'+data+'" alt="" class="img-responsive">');    	
    	/*$('#image').attr('src', 'data:image/jpeg;base64,'+data+'');*/
    })
    .fail(function(data) {
        alert('Error: ' + data);
    });
    console.log('ok');


}
