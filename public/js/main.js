$('document').ready(function(){

  /**
   *
   */
	// facebookalbum = {
	// 	getAlbum : function( id ){

	// 		$.get("/newstory/facebookalbums/next/"+id,function(result){
	// 		  var obj = jQuery.parseJSON( result );

	// 		  if(obj.next == '') {
	// 		  	return;
	// 		  }

	// 		  facebookalbum.getAlbum(obj.next);
			  
	// 		  facebookalbum.createAlbumCover(obj);
	// 		});
	// 	},
	// 	createAlbumCover : function( obj ) {
	// 		if(obj.picture) {
	// 			$('#facebookalbum').append('<div id="facebookalbum_'+obj.id+'" class="facebookalbum"><i class="fa fa-refresh fa-spin"></i></div>');

	// 			$('#facebookalbum_'+obj.id).html('<a href="/create/facebook/'+obj.id+'">'
	// 				+ '<img width="200" src="' + obj.picture + '"/></a>');
	// 		}
	// 	}
	// };

	// // Get facebook albums
	// if ($('#facebookalbum').length > 0) { 
	// 	facebookalbum.getAlbum('');
	// }

	/*************************************************************************************************************************************************/

	/**
	 *
	 */

	$('#create_new_story').click(function(){

		$('#upload,#create_new_story,#total_upload_process').hide();

		$('#create_story_loading').show();

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

				var id = data.id;
				var geoLoc = data.singleLocation;
				var geo = geoLoc.split(",");
				var lat = geo[0];
				var lng = geo[1];

				// console.log(data)
				reverseGeocoding.transformLatLong(lat , lng , id);
			}
		});	
	});

	/*************************************************************************************************************************************************/

    reverseGeocoding = {

    	transformLatLong : function(lat , lng , id) {
			geocoder = new google.maps.Geocoder();
			var lat = parseFloat(lat);
			var lng = parseFloat(lng);
			var latlng = new google.maps.LatLng(lat, lng);
			// console.log('lats ' + lat + ' ' + lng)
			geocoder.geocode({'latLng': latlng}, function(results, status) 
			{
				if (status == google.maps.GeocoderStatus.OK) 
				{
					if (results[1]) 
					{
						var loc = reverseGeocoding.getCityName(results[1] , id);
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

    	getCityName : function( data , id) {
				
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

			reverseGeocoding.getDbpediaEntry(locationInfo , id); 		
    	},

    	getDbpediaEntry : function( cityInfo , id ) {
    		console.log(cityInfo + ' '  + id)
			$.ajax({
				url: '/dbpedia',
				type: 'POST',
				data: { city: cityInfo , story_id : id },
				async: true,
				cache: false,
				timeout: 30000,
				error: function(){
				    return true;
				},
				success: function(data){ 

					window.location.href = '/create/'+id;
				}
			});	
    	}
    };

	/*************************************************************************************************************************************************/
});


$('.hide_story').click(function(){
	id = this.id.replace('hide_item_' , '');
	$('#edit_item_'+id).hide();
	$('#hide_item_'+id).hide();
	$('#show_item_'+id).show();
});

$('.show_story').click(function(){
	id = this.id.replace('show_item_' , '');
	$('#edit_item_'+id).show();
	$('#hide_item_'+id).show();
	$('#show_item_'+id).hide();
});

$('#finish_edit').click(function(){

	var items = {
		'id' : $('#story_id_edit').val() ,
		'title' : $('#story_title_edit').val() ,
		'items' : {}
	};

	$('.story_item_container').each(function(i){

		var visible = '';
		if($(this).is(":visible")) {
			visible = true;
		}else{
			visible = false;
		}

		var details = {
			'display' : visible
		}

		var ta = '';
		if($(this).children().is('textarea')) {
			ta = $(this).children('textarea').val();

			var details = {
				'display' : visible ,
				'message' : ta
			}
		}

		var id = this.id.replace('edit_item_' , '');
		items['items'][id] = details;
	});

	$.ajax({
		url: '/update',
		type: 'POST',
		data: { info: items },
		async: true,
		cache: false,
		timeout: 30000,
		error: function(){
		    return true;
		},
		success: function(data){ 

			$( "#callout-stacked-modals" ).slideUp( 300 )
										  .delay( 300 )
										  .fadeIn( 400 )
										  .delay( 3000 )
										  .fadeOut();
		}
	});	
	// console.log(items);
});




