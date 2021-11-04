<?php

class Sql extends PDO { // extends foi usado para termos acesso a todos os recursos dessa biblioteca dentro da classe sem usar a variável $conn

    private $conn;
    
    // Conexão com o Banco de Dados.
    public function __construct() 
    {

        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");

    }
    //busca vários dados no bd
    private function setParams($statment, $parameters = array()) 
    { // Método que recebe uma query preparada e um array de dados para fazer o bind
        foreach ($parameters as $key => $value)
        {

            $this->setParam($statment, $key, $value);

        }

    }
    //busca somente um dado no bd.
    private function setParam($statment, $key, $value) 
    {

        $statment->bindParam($key, $value);

    }
    //método que aplica os comandos no bd.
    public function execQuery($rawQuery, $params = array())  
    {   // chamei o query. $rawQuery = query bruta. 
        //$params = dados que estarão na query(independente de qual query seja)   

        $stmt = $this->conn->prepare($rawQuery); // stmt recebe as querys.

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt; // aqui retorna o valor para o objeto.
    }
    
    public function select($rawQuery, $params = array()):array
    {
        $stmt = $this->execQuery($rawQuery, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
                        //é uma constante que retorna os dados sem o index, ele associa ao nome da coluna.

    }

}