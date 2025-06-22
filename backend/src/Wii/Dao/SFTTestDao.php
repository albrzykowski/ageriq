<?php
namespace Wii\Dao;

class SFTTestDao
{
    private $pdo;
    
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function fetch($testCode, $age, $sex, $result)
    {
        $query = <<<EOT
            SELECT
                test_name, test_code,
                sex, min_age, max_age,
            CASE
                WHEN test_code IN('arm_curl', 'chair_stand', 'two_min_step') THEN CAST(min_ref AS INTEGER)
                ELSE min_ref
            END as min_ref,
            CASE
                WHEN test_code IN('arm_curl', 'chair_stand', 'two_min_step') THEN CAST(max_ref AS INTEGER)
                ELSE max_ref
            END as max_ref,
            CASE
                WHEN min_ref < max_ref AND :result < min_ref THEN 'below normal'
                WHEN min_ref < max_ref AND :result > max_ref THEN 'above normal'
                WHEN min_ref > max_ref AND :result > min_ref THEN 'below normal'
                WHEN min_ref > max_ref AND :result < max_ref THEN 'above normal'
                ELSE 'normal'
            END as evaluation
            FROM public.fullerton_test WHERE
                test_code = :test_code AND 
                :age <= min_age and :age <= max_age AND
                sex = :sex
            LIMIT 1
        EOT;
        
        $sth = $this->pdo->prepare($query);
        $sth->execute(['test_code' => $testCode, ':age' => $age, ':sex' => $sex, ':result' => $result]);
        
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }
}