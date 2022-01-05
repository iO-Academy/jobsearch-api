<?php

namespace JobSearch\Controllers;

use JobSearch\Abstracts\Controller;
use JobSearch\Models\SkillsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SkillsController extends Controller
{
    private SkillsModel $skillsModel;

    public function __construct(SkillsModel $skillsModel)
    {
        $this->skillsModel = $skillsModel;
    }

    public function getAllSkills(Request $request, Response $response): Response
    {
        $skills = $this->skillsModel->getAllSkills();
        return $this->respondWithJson($response, $skills);
    }


}