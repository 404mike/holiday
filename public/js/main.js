$('document').ready(function(){

	facebookalbum = {
		getAlbum : function( id ){

			// console.log('calling ' + "/upload/facebookalbums/next/"+id)

			$.get("/upload/facebookalbums/next/"+id,function(result){
			  var obj = jQuery.parseJSON( result );

			  if(obj.next == '') {
			  	return;
			  }



			  facebookalbum.getAlbum(obj.next);

			  
			  facebookalbum.createAlbumCover(obj);
			});
		},
		createAlbumCover : function( obj ) {
			if(obj.picture) {
				$('#facebookalbum').append('<div id="facebookalbum_'+obj.id+'" class="facebookalbum"><i class="fa fa-refresh fa-spin"></i></div>');

				$('#facebookalbum_'+obj.id).html('<a href="/upload/facebookalbums/album/'+obj.id+'">'
					+ '<img width="200" src="' + obj.picture + '"/></a>');
			}
		}
	};


	// Get facebook albums
	if ($('#facebookalbum').length > 0) { 
		facebookalbum.getAlbum('');
	}

});