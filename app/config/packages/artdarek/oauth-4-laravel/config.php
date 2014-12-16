<?php 

// Check to see if we're running on a local machine or in production
if (App::environment('local'))
{
	return array( 
		
		/*
		|--------------------------------------------------------------------------
		| oAuth Config - Local
		|--------------------------------------------------------------------------
		*/

		/**
		 * Storage
		 */
		'storage' => 'Session', 

		/**
		 * Consumers
		 */
		'consumers' => array(

			/**
			 * Facebook
			 */
	        'Facebook' => array(
	            'client_id'     => '1437671129843796',
	            'client_secret' => 'ca609da430c33464a2c0d56ee60b864e',
	            'scope'         => array('email','read_friendlists','user_online_presence' , 'user_photos' , 'read_stream'),
	        ),

	        'Twitter' => array(
			    'client_id'     => 'QFlSVjRdHo7mSUyiCpQKmtUD6',
			    'client_secret' => 'vJ0n9d8q5pZRzV165ypYtbTpOTNoTNgVplKOkQ2NwjHET3SoiS',
			    // No scope - oauth1 doesn't need scope
			),	

		)

	);
}else{
	return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config - Production
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '671592782960070',
            'client_secret' => '35704352a29cf8cb54ea001b246c7849',
            'scope'         => array('email','read_friendlists','user_online_presence' , 'user_photos' , 'read_stream'),
        ),

        'Twitter' => array(
		    'client_id'     => 'QFlSVjRdHo7mSUyiCpQKmtUD6',
		    'client_secret' => 'vJ0n9d8q5pZRzV165ypYtbTpOTNoTNgVplKOkQ2NwjHET3SoiS',
		    // No scope - oauth1 doesn't need scope
		),	

	)

);
}
