<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribuidora Estrela Real</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
    <link rel="stylesheet" href="assets/css/acessibilidade.css">
</head>
<body>

<!-- BARRA DE ACESSIBILIDADE -->
<div class="barra-acessibilidade">
    <div class="barra-acessibilidade-conteudo">
        <button id="btn-dark-mode" class="btn-acessibilidade" aria-label="Ativar modo escuro">
            🌙 Modo Escuro
        </button>
        
        <span class="separador-acessibilidade"></span>
        
        <button id="btn-diminuir-fonte" class="btn-acessibilidade" aria-label="Diminuir tamanho da fonte">
            A-
        </button>
        <button id="btn-resetar-fonte" class="btn-acessibilidade" aria-label="Resetar tamanho da fonte">
            A
        </button>
        <button id="btn-aumentar-fonte" class="btn-acessibilidade" aria-label="Aumentar tamanho da fonte">
            A+
        </button>
    </div>
</div>

<div class="topo">
    <div class="topo-conteudo">
        <div class="topo-esquerda">
            <span class="titulo">Distribuidora Estrela Real</span>
            <div class="menu">
                <a href="index.php">Home</a>
                <a href="dashboard.php">Dashboard</a>
                <a href="cadastrar.php">Cadastrar Produto</a>
                <a href="categorias.php">Gerenciar Categorias</a>
                <a href="catalogo.php">Catálogo de Produtos</a>
            </div>
        </div>
        <div class="usuario">
            <span>Olá, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
            <a class="sair" href="logout.php">Sair</a>
        </div>
    </div>
</div>

