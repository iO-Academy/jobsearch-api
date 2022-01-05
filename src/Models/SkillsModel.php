<?php

namespace JobSearch\Models;

class SkillsModel
{
    private \PDO $db;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getSkillsByJobId(int $jobId): array
    {
        $sql = 'SELECT `skills`. `id`, `skill` FROM `skills` LEFT JOIN `jobs_skills` ON `skills`.`id` = `jobs_skills`.`skill_id` WHERE `job_id` = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$jobId]);
        return $query->fetchAll();
    }

    public function getAllSkills(): array
    {
        $sql = 'SELECT `skills`.`id`, `skill`, count(`skill`) AS "job_count" FROM `skills` LEFT JOIN `jobs_skills` ON `skills`.`id` = `jobs_skills`.`skill_id` GROUP BY `skills`.`id`';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

//    public function getSkillsById(array $ids): array
//    {
//        $sql = 'SELECT * FROM `skills` WHERE `id` IN (?)';
//        $query = $this->db->prepare($sql);
//        $query->execute([implode(',', $ids)]);
//        return $query->fetchAll();
//    }
}