<?php
/**
 * Created by IntelliJ IDEA.
 * User: m.dykhalkin
 * Date: 23.03.2017
 * Time: 17:48
 */

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app['debug'] = true;

$app->get('/', function() use ($app) {
    return $app['twig']->render('hellow.html.twig', array(
    ));
});

$app->post('/application', function(Request $request) {

	$application  = array(
		$request->get('name'),
		$request->get('email'),
		$request->get('message')
	);

	$filename = __DIR__.'\mss.csv';
	$file = fopen($filename, 'a');
	fputcsv($file, $application, ';');
	fclose($file);
	return new Response(json_encode($application));
});

$app->post('/telegram/message', function(Request $request) {

	$application  = array($request->getMethod());

	$filename = __DIR__.'\mss.csv';
	$file = fopen($filename, 'a');
	fputcsv($file, $application, ';');
	fclose($file);

	return new Response(json_encode('ok'), 200);

});

$app->run();

