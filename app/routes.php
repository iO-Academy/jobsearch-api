<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();

//    $app->get('/', function ($request, $response, $args) use ($container) {
//        $renderer = $container->get('renderer');
//        return $renderer->render($response, "index.php", $args);
//    });

    // can use optional filters with this route
    // /jobs?search=developer&type=Full time&skill=2
    $app->get('/jobs', '\JobSearch\Controllers\JobsController:jobSearch');
    $app->get('/jobs/recent', '\JobSearch\Controllers\JobsController:recentJobs');
    $app->get('/jobs/{id}', '\JobSearch\Controllers\JobsController:singleJob');
    $app->get('/jobs/{id}/similar', '\JobSearch\Controllers\JobsController:similarJobs');

    $app->get('/skills', '\JobSearch\Controllers\SkillsController:getAllSkills');

    $app->get('/companies', '\JobSearch\Controllers\CompaniesController:getAllCompanies');
    $app->get('/companies/recent', '\JobSearch\Controllers\CompaniesController:getRecentCompanies');

    $app->get('/[{wildcard}]', function ($request, $response) {
        $errorData = ['message' => 'Invalid route'];
        $json = json_encode($errorData);
        $response->getBody()->write($json);
        return $response->withHeader('Content-type', 'application/json')->withStatus(404);
    });

};
