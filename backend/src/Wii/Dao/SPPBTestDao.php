<?php
namespace Wii\Dao;

class SPPBTestDao
{
    private $pdo;
    
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function fetch($testCode, $age, $sex, $result)
    {
        $query = <<<EOT
            
        EOT;
        
        $sth = $this->pdo->prepare($query);
        $sth->execute(['test_code' => $testCode, ':result' => $result]);
        
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }
}