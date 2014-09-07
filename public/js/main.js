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

	$('#create_new_story').click(function(){

		$('#upload,#create_new_story').hide();

		$.ajax({
			url: '/fileinfo',
			type: 'POST',
			data: { images: imageData },
			async: true,
			cache: false,
			timeout: 30000,
			error: function(){
			    return true;
			},
			success: function(data){ 
				console.log(data)
				$.each(data, function (key, data) {
					console.log(data.type)

					if(data.type == 'image') create_story.photo(data);
					else if(data.type == 'tweet') create_story.tweet(data);
					else if(data.type == 'facebookfeed') create_story.fbFeed(data);
				});
			}
		});	
	});

	create_story = {

		photo : function (data) {
			console.log('Photo ' + data.created_at)
			$('#final_data').append(
				'<div class="story_image"><img src="/photos/'+data.picture+'" /></div>'
			);
		},

		tweet : function (data) {
			console.log('tweet ' + data)
			$('#final_data').append('<div class="story_tweet">'+data.tweet+'</div>');
		},

		fbFeed : function (data) {
			console.log('facebook ' + data)

			var feed = '';
			if(data.picture) {
				feed += '<img src="'+data.picture+'" />';
			}
			if(data.message) {
				feed += '<p>'+data.message+'</p>';
			}
			if(data.place) {
				feed += '<p>'+data.place.name+'</p>';
				feed += '<p>'+data.place.location.city+'</p>';
				feed += '<p>'+data.place.location.country+'</p>';
			}

			$('#final_data').append('<div class="story_fbfeed">'+feed+'</div>');
		}
	};

});