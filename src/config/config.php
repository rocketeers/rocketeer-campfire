<?php

return array(

	// Campfire room credentials
	'subdomain'     => '',
	'room'          => '',
	'key'           => '',

	// Message
	// You can use the following variables :
	// 1: User deploying
	// 2: Branch
	// 3: Connection and stage
	// 4: Host
	'before_deploy' => '{1} started deploying branch "{2}" on "{3}" ({4})',
	'after_deploy'  => '{1} finished deploying branch "{2}" on "{3}" ({4})',

);
