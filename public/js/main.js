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

				$.each(data.data, function (key, data) {

					if(data.type == 'image') create_story.photo(data);
					else if(data.type == 'tweet') create_story.tweet(data);
					else if(data.type == 'facebookfeed') create_story.fbFeed(data);
				});

				var geoLoc = data.singleLocation;
				var geo = geoLoc.split(",");
				var lat = geo[0];
				var lng = geo[1];

				reverseGeocoding.transformLatLong(lat , lng);
			}
		});	
	});

	create_story = {

		photo : function (data) {
			// console.log('Photo ' + data.created_at)
			$('#final_data').append(
				'<div class="story_image"><img src="/photos/'+data.picture+'" /></div>'
			);
		},

		tweet : function (data) {
			// console.log('tweet ' + data)
			$('#final_data').append('<div class="story_tweet">'+data.tweet+'</div>');
		},

		fbFeed : function (data) {
			// console.log('facebook ' + data)

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


	/*************************************************************************************************************************************************/

    reverseGeocoding = {

    	transformLatLong : function(lat , lng) {
			geocoder = new google.maps.Geocoder();
			var lat = parseFloat(lat);
			var lng = parseFloat(lng);
			var latlng = new google.maps.LatLng(lat, lng);
			geocoder.geocode({'latLng': latlng}, function(results, status) 
			{
				if (status == google.maps.GeocoderStatus.OK) 
				{
					if (results[1]) 
					{
						var loc = reverseGeocoding.getCityName(results[1]);
						console.log(loc)
					} 
					else 
					{
						console.log('No results found');
					}
				} 
				else 
				{
					console.log('Geocoder failed due to: ' + status);
				}
			});
    	},

    	getCityName : function( data ) {
				
			var locationInfo = {};

			$.each(data.address_components , function(i , data) {

				if(data.types[0] == 'administrative_area_level_1') {
					locationInfo.level1 = data.long_name;
				}

				if(data.types[0] == 'locality') {
					locationInfo.locality = data.long_name;
				}

				if(data.types[0] == 'country') {
					locationInfo.country = data.long_name;
				}

			});  

			 reverseGeocoding.getDbpediaEntry(locationInfo); 		
    	},

    	getDbpediaEntry : function( cityInfo ) {
			$.ajax({
				url: '/dbpedia',
				type: 'POST',
				data: { city: cityInfo },
				async: true,
				cache: false,
				timeout: 30000,
				error: function(){
				    return true;
				},
				success: function(data){ 
					var desc = data.description;

					$('#about_the_city').append('<p>'+desc+'</p>');

					$('#about_the_city').show();
				}
			});	
    	}

    };

	/*************************************************************************************************************************************************/


});