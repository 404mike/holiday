<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
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
            'scope'         => array('email','read_friendlists','user_online_presence' , 'user_photos'),
        ),

        'Twitter' => array(
		    'client_id'     => 'QFlSVjRdHo7mSUyiCpQKmtUD6',
		    'client_secret' => 'vJ0n9d8q5pZRzV165ypYtbTpOTNoTNgVplKOkQ2NwjHET3SoiS',
		    // No scope - oauth1 doesn't need scope
		),	

	)

);