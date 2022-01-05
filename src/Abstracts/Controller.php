<?php
declare(strict_types=1);

namespace JobSearch\Abstracts;

use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    /**
     * @param Response $response a PSR-7 HTTP Response for the JSON and status code to be added
     * @param array $data an array of data to be JSON encoded and added to the response
     * @param int $statusCode an optional status code for the response, defaults to 200
     * @return Response a PSR-7 HTTP Response object with JSON data and a custom status code
     */
    protected function respondWithJson(Response $response, array $data, int $statusCode = 200): Response
    {
        $json = json_encode($data);
        if (false === $json) {
            $errorData = ['message' => 'Unexpected error while encoding JSON data'];
            $json = json_encode($errorData);
            $response->getBody()->write($json);
            return $response->withHeader('Content-type', 'application/json')->withStatus(500);
        }
        $response->getBody()->write($json);
        return $response->withHeader('Content-type', 'application/json')->withStatus($statusCode);
    }

}