<?php

return array(
		'modules' => array(
				'Application',
				'Core',
				'ZendDeveloperTools',
				'DoctrineModule',
				'DoctrineORMModule',

		),
		'module_listener_options' => array(
				'config_glob_paths'    => array(
						'config/autoload/{,*.}{global,local,phpunit}.php',
				),
				'module_paths' => array(
						'./module',
						'./vendor',
				),
		),
		'cache' => array(
				'adapter'=> 'filesystem'
		),
    
);
