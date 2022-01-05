<?php

namespace JobSearch\Controllers;

use JobSearch\Abstracts\Controller;
use JobSearch\Models\JobsModel;
use JobSearch\Models\SkillsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class JobsController extends Controller
{
    private JobsModel $jobsModel;
    private SkillsModel $skillsModel;

    public function __construct(JobsModel $jobsModel, SkillsModel $skillsModel)
    {
        $this->jobsModel = $jobsModel;
        $this->skillsModel = $skillsModel;
    }

    public function jobSearch(Request $request, Response $response): Response
    {
        $searchTerm = $request->getQueryParams()['search'] ?? null;
        $typeFilter = $request->getQueryParams()['type'] ?? null;
        $skillFilter = $request->getQueryParams()['skill'] ?? null;

        $jobs = $this->jobsModel->searchAllJobs($searchTerm, $typeFilter, $skillFilter);

        $jobs = $this->combineSkillsWithJobs($jobs);
        return $this->respondWithJson($response, $jobs);
    }

    public function recentJobs(Request $request, Response $response): Response
    {
        $jobs = $this->jobsModel->getRecentJobs();
        $jobs = $this->combineSkillsWithJobs($jobs);
        return $this->respondWithJson($response, $jobs);
    }

    public function singleJob(Request $request, Response $response, array $urlParams): Response
    {
        if (!empty($urlParams['id']) && is_numeric($urlParams['id'])) {
            $job = $this->jobsModel->getJobById($urlParams['id']);
            $job['skills'] = $this->skillsModel->getSkillsByJobId($job['id']);
            return $this->respondWithJson($response, $job);
        }
        return $this->respondWithJson($response, ['message' => 'Invalid job ID'], 400);
    }

    public function similarJobs(Request $request, Response $response, array $urlParams): Response
    {
        if (!empty($urlParams['id']) && is_numeric($urlParams['id'])) {
            $jobs = $this->jobsModel->getSimilarJobs($urlParams['id']);
            $jobs = $this->combineSkillsWithJobs($jobs);
            return $this->respondWithJson($response, $jobs);
        }
        return $this->respondWithJson($response, ['message' => 'Invalid job ID'], 400);
    }

    private function combineSkillsWithJobs(array $jobs): array
    {
        return array_map(function($job) {
            $job['skills'] = $this->skillsModel->getSkillsByJobId($job['id']);
            return $job;
        }, $jobs);
    }

}