DB profiler
===========

Instead of regular `CProfileLogRoute` DB profiler displays database queries and
query-related info only. Also it have an ability to highligt possibly slow queries
and queries repeated many times.

Installation
------------

Unpack to `protected/extensions/`. Add the following to your `protected/config/main.php`:

~~~
<?php
return array(
	// …
	'components' => array(
		// …
		'db' => array(
			// …
			'enableProfiling'=>true,
			'enableParamLogging' => true,
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
					// …
            	    array(
                	    'class'=>'ext.db_profiler.DbProfileLogRoute',
						'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
						'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                	),
			),
		),
	),
);
~~~