<?php

namespace JobSearch\Models;

class JobsModel
{
    private \PDO $db;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function searchAllJobs(
        string $searchTerm = null,
        array $typeFilter = null,
        int $skillFilter = null
    ): array
    {
        $params = [];
        $sql = 'SELECT `jobs`.`id`, `job_title`, `company`, `logo`, `salary`, `type` FROM `jobs`';

        if (!empty($searchTerm) || !empty($skillFilter)) {
            $sql .= ' LEFT JOIN `jobs_skills` ON `jobs`.`id` = `jobs_skills`.`job_id` 
            LEFT JOIN `skills` ON `jobs_skills`.`skill_id` = `skills`.`id`';
        }

        if (!empty($skillFilter)) {
            $sql .= ' WHERE `skills`.`id` = :skillFilter';
            $params['skillFilter'] = $skillFilter;
        } else if (!empty($searchTerm)) {
            $sql .= ' WHERE `skills`.`skill` LIKE :searchTerm 
                OR `job_title` LIKE :searchTerm 
                OR `company` LIKE :searchTerm';
            $params['searchTerm'] = '%' . $searchTerm . '%';
        } else if (!empty($typeFilter)) {
            $sql .= ' WHERE 1 = 1';
        }

        if (!empty($searchTerm) && !empty($skillFilter)) {
            $sql .= ' AND (`job_title` LIKE :searchTerm 
                OR `company` LIKE :searchTerm)';
            $params['searchTerm'] = '%' . $searchTerm . '%';
        }

        if (!empty($typeFilter)) {

            $in = "";
            foreach ($typeFilter as $i => $type) {
                $key = ":type".$i;
                $in .= "$key,";
                $params[$key] = $type;
            }
            $in = rtrim($in,",");

            $sql .= " AND `type` IN ($in)";
        }

        $sql .= ' GROUP BY `jobs`.`id` ORDER BY `posted`';

        $query = $this->db->prepare($sql);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function getRecentJobs(): array
    {
        $sql = 'SELECT `id`, `job_title`, `company`, `logo`, `salary`, `type` FROM `jobs` ORDER BY `posted` ASC limit 10';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getJobById(int $id): array
    {
        $sql = 'SELECT `id`, `job_title`, `company`, `logo`, `job_description`, `salary`, `type`, `posted` FROM `jobs` WHERE `id` = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
        return $query->fetch();
    }

    public function getSimilarJobs(int $id): array
    {
        $sql = 'SELECT `id`, `job_title`, `company`, `logo`, `salary`, `type` FROM `jobs` WHERE `id` > ? AND `salary` IS NOT NULL ORDER BY `salary` LIMIT 4';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
        $jobs = $query->fetchAll();
        if (count($jobs) < 4) {
            $sql = 'SELECT `id`, `job_title`, `company`, `logo`, `salary`, `type` FROM `jobs` WHERE `id` < ? AND `salary` IS NOT NULL ORDER BY `salary` LIMIT 4';
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            $jobs = $query->fetchAll();
        }
        return $jobs;
    }
}