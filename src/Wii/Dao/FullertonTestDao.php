<?php
namespace Wii\Dao;

class FullertonTestDao
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
                min_ref, max_ref,
            CASE
                WHEN min_ref < max_ref AND :result < min_ref THEN 'below normal'
                WHEN min_ref < max_ref AND :result > max_ref THEN 'above normal'
                WHEN min_ref > max_ref AND :result > min_ref THEN 'below normal'
                WHEN min_ref > max_ref AND :result < max_ref THEN 'above normal'
                ELSE 'normal'
            END as assessment
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