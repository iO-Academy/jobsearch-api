<?php

namespace JobSearch\Models;

class CompaniesModel
{
    private \PDO $db;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllCompanies(): array
    {
        $sql = 'SELECT `company` from `jobs` GROUP BY `company`';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getRecentCompanies(): array
    {
        $sql = 'SELECT DISTINCT `company`, `logo`, `posted` as "last_job_posted" FROM `jobs` ORDER BY `posted` DESC LIMIT 5';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}