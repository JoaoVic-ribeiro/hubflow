<?php
namespace Api\database\mysql\dao;

use Api\database\mysql\model\Funcionario;
use Api\database\mysql\MySqlPDO;
use PDO;

class FuncionarioDAO {
    public function getAll() {
        $pdo = MySqlPDO::getInstance();
        $sql = "SELECT * FROM Funcionarios";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function getById($id) {
        $pdo = MySqlPDO::getInstance();
        $sql = "SELECT * FROM Funcionarios WHERE FuncionarioID = :id";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function getByEmpresa($empresaId) {
        $pdo = MySqlPDO::getInstance();
        $sql = "SELECT * FROM Funcionarios WHERE EmpresaID = :empresaId";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([':empresaId' => $empresaId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function insert(Funcionario $funcionario) {
        $pdo = MySqlPDO::getInstance();

        $sql = "INSERT INTO Funcionarios (Nome, Cargo, Salario, DataContratacao, EmpresaID, Imagem, Descricao) 
                VALUES (:Nome, :Cargo, :Salario, :DataContratacao, :EmpresaID, :Imagem, :Descricao)";
        
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':Nome' => $funcionario->Nome,
                ':Cargo' => $funcionario->Cargo,
                ':Descricao' => $funcionario->Descricao,
                ':Salario' => $funcionario->Salario,
                ':DataContratacao' => $funcionario->DataContratacao,
                ':Imagem' => $funcionario->Imagem,
                ':EmpresaID' => $funcionario->EmpresaID          
            ]);
            return $pdo->lastInsertId();
        } catch(\PDOException $th) {
            var_dump($th->getMessage());
        }
    }

    public function update(Funcionario $funcionario) {
        $pdo = MySqlPDO::getInstance();
        
        $sql = "UPDATE Funcionarios 
                SET Nome = :Nome, 
                    Cargo = :Cargo, 
                    Salario = :Salario,
                    Imagem = :Imagem,
                    Descricao = :Descricao 
                WHERE FuncionarioID = :FuncionarioID";
        
        $stmt = $pdo->prepare($sql);

        try {
            return $stmt->execute([
                ':FuncionarioID' => $funcionario->FuncionarioID,
                ':Nome' => $funcionario->Nome,
                ':Cargo' => $funcionario->Cargo,
                ':Salario' => $funcionario->Salario,
                ':Imagem' => $funcionario->Imagem,
                ':Descricao' => $funcionario->Descricao
            ]);
        } catch(\PDOException $th) {
            var_dump($th->getMessage());
        }
    }

    public function delete($id) {
        $pdo = MySqlPDO::getInstance();
        $sql = "DELETE FROM Funcionarios WHERE FuncionarioID = :id";
        $stmt = $pdo->prepare($sql);

        try {
            return $stmt->execute([':id' => $id]);
        } catch(\PDOException $th) {
            var_dump($th->getMessage());
        }
    }
}