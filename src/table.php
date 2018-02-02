<?php
class MyBotTable
{
    /**
     * @var \PDO
     */
    private $pdo;
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Pagine les article
     *
     * @return \stdClass[]
     */
    public function find()
    {
        return $this->pdo
            ->query('SELECT * FROM user')
            ->fetchAll();
    }