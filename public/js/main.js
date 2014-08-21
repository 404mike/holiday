$('document').ready(function(){

	facebookalbum = {
		getAlbum : function( id ){

			console.log('calling ' + "/upload/facebookalbums/next/"+id)

			$.get("/upload/facebookalbums/next/"+id,function(result){
			  var obj = jQuery.parseJSON( result );

			  if(obj.next == '') {
			  	return;
			  }

			  facebookalbum.getAlbum(obj.next);
			  
			  
			  facebookalbum.createAlbumCover(obj);
			}).fail(function(){

			});
		},
		createAlbumCover : function( obj ) {
			$('#facebookalbum').append('<div class="facebookalbum"><img width="200" src="'+obj.picture+'"/></div>')
		}
	};


	// Get facebook albums
	if ($('#facebookalbum').length > 0) { 
		facebookalbum.getAlbum('');
	}

});