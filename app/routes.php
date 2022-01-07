<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    // enable options requests
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    // enable CORS
    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    $app->get('/', function($request, $response) {
        $html = '<h1>JobSearch API</h1>
                    <p>To use this API please check the 
                        <a href="https://github.com/iO-Academy/jobsearch-api#api-documentation" target="_blank">documentation</a>.
                    </p>';
        $response->getBody()->write($html);
        return $response->withHeader('Content-type', 'text/html')->withStatus(200);
    });

    // can use optional filters with this route
    // /jobs?search=developer&type=Full time&skill=2
    $app->get('/jobs', '\JobSearch\Controllers\JobsController:jobSearch');
    $app->get('/jobs/recent', '\JobSearch\Controllers\JobsController:recentJobs');
    $app->get('/jobs/{id}', '\JobSearch\Controllers\JobsController:singleJob');
    $app->get('/jobs/{id}/similar', '\JobSearch\Controllers\JobsController:similarJobs');

    $app->get('/skills', '\JobSearch\Controllers\SkillsController:getAllSkills');

    $app->get('/companies', '\JobSearch\Controllers\CompaniesController:getAllCompanies');
    $app->get('/companies/recent', '\JobSearch\Controllers\CompaniesController:getRecentCompanies');

    $app->get('/{wildcard}', function ($request, $response) {
        $errorData = ['message' => 'Invalid route'];
        $json = json_encode($errorData);
        $response->getBody()->write($json);
        return $response->withHeader('Content-type', 'application/json')->withStatus(404);
    });

};
