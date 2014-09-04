$('document').ready(function(){

  /**
   *
   */
	facebookalbum = {
		getAlbum : function( id ){

			$.get("/newstory/facebookalbums/next/"+id,function(result){
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

				$('#facebookalbum_'+obj.id).html('<a href="/create/facebook/'+obj.id+'">'
					+ '<img width="200" src="' + obj.picture + '"/></a>');
			}
		}
	};

	// Get facebook albums
	if ($('#facebookalbum').length > 0) { 
		facebookalbum.getAlbum('');
	}

	/*************************************************************************************************************************************************/

	/**
	 *
	 */
	if ($("#create_new_story").length > 0){

	}

	$('#create_new_story').click(function(){


		$('#upload').hide();

	   $.ajax({
        url: '/funk',
        type: 'POST',
       	data: { images: imageData },
        async: true,
        cache: false,
        timeout: 30000,
        error: function(){
            return true;
        },
        success: function(msg){ 
        	console.log(msg);

        	$('#upload_response').append(msg)
        }
    });	
	});

});