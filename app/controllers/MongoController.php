<?php

class MongoController extends \BaseController {

	public function main()
	{
		$foo = DBLayer::main();

		echo $foo;
	}

}