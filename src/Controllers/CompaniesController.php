<?php

namespace JobSearch\Controllers;

use JobSearch\Abstracts\Controller;
use JobSearch\Models\CompaniesModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CompaniesController extends Controller
{
    private CompaniesModel $companiesModel;

    public function __construct(CompaniesModel $companiesModel)
    {
        $this->companiesModel = $companiesModel;
    }

    public function getAllCompanies(Request $request, Response $response): Response
    {
        $companies = $this->companiesModel->getAllCompanies();
        return $this->respondWithJson($response, $companies);
    }

    public function getRecentCompanies(Request $request, Response $response): Response
    {
        $companies = $this->companiesModel->getRecentCompanies();
        return $this->respondWithJson($response, $companies);
    }


}