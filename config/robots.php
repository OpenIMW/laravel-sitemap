<?php

return
[
	[
		'name' => '*',
		'rules' =>
		[
			'Disallow: /excluded',
			'Allow: /excluded/allowed',
			'Disallow: /excluded/allowed/exclude_sub_dir'
		]
	],

	[
		'name' => 'Googlebot',
		'rules' =>
		[
			'Disallow: /somepath/*'
		]
	]
];
