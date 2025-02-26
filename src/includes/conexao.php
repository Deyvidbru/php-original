<?php
try {
    $conexaoDefault = new PDO("pgsql:host=127.0.0.1;dbname=postgres", "postgres", "pabd");
    $conexaoDefault->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conexaoDefault->exec("CREATE DATABASE \"pomodor\"");
} catch (PDOException $erro) {
    if ($erro->getCode() != '42P04') {
        echo "Erro ao criar o banco de dados: " . $erro->getMessage();
        exit;
    } 
}

try {
    $conexao = new PDO("pgsql:host=127.0.0.1;dbname=pomodoro", "postgres", "pabd");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    echo "Erro na conexão: " . $erro->getMessage();
    exit;
}

$tabelas_sql = [
    "CREATE TABLE IF NOT EXISTS Administrador (
        id_adm SERIAL PRIMARY KEY,
        email VARCHAR(255) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS Usuario (
        id_usuario SERIAL PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL,
        aprovado BOOLEAN DEFAULT FALSE
    )",
    "CREATE TABLE IF NOT EXISTS Tarefa (
        id SERIAL PRIMARY KEY,
        descricao VARCHAR(255),
        concluida BOOLEAN DEFAULT FALSE,
        id_usuario INT NOT NULL,
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario) 
    )",
    "CREATE TABLE IF NOT EXISTS Pomodoro (
        id SERIAL PRIMARY KEY,
        duracao INT NOT NULL,
        duracao_pausa INT NOT NULL,
        duracao_pausalonga INT NOT NULL,
        ciclos INT NOT NULL,
        id_usuario INT NOT NULL,
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario) 
    )"
];

foreach ($tabelas_sql as $sql) {
    try {
        $conexao->exec($sql);
    } catch (PDOException $erro) {
        echo "Erro ao criar tabela: " . $erro->getMessage();
        exit;
    }
}

try {
    $email = 'adm@gmail.com';
    $senha = 'adm';
    
    $checkAdmin = $conexao->prepare("SELECT COUNT(*) FROM Administrador WHERE email = :email");
    $checkAdmin->bindParam(':email', $email);
    $checkAdmin->execute();
    $count = $checkAdmin->fetchColumn();
    
    if ($count == 0) {
        $comando = $conexao->prepare("INSERT INTO Administrador (email, senha) VALUES (:email, :senha)");
        $comando->bindParam(':email', $email);
        $comando->bindParam(':senha', $senha);
        $comando->execute();
        echo "Administrador inserido com sucesso!<br>";
    } 
} catch (PDOException $erro) {
    echo "Erro ao inserir dados do administrador: " . $erro->getMessage();
    exit;
}

return $conexao;
?>
