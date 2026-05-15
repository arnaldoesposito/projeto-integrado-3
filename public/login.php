<?php
session_start();
include __DIR__ . '/../src/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario['nome'];
            header("Location: index.php");
            exit;
        } else {
            $erro = "E-mail ou senha incorretos!";
        }
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Distribuidora Estrela Real</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
    <link rel="stylesheet" href="assets/css/acessibilidade.css">
</head>
<body class="login">

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

<div class="login-box">
    <h1>Distribuidora Estrela Real</h1>
    <p class="login-subtitulo">Acesso Administrativo</p>
    
    <?php if (!empty($erro)): ?>
        <div class="login-erro">
            ⚠️ <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="" class="login-form">
        <label for="email">E-mail</label>
        <input type="email" 
               id="email"
               name="email" 
               placeholder="Digite seu e-mail" 
               required
               autocomplete="email">
        
        <label for="senha">Senha</label>
        <input type="password" 
               id="senha"
               name="senha" 
               placeholder="Digite sua senha" 
               required
               autocomplete="current-password">
        
        <button type="submit" class="btn-entrar">Entrar no Sistema</button>
    </form>
    
    <a href="catalogo.php" class="link-voltar">← Voltar para o Catálogo</a>
</div>

<?php include __DIR__ . '/../src/rodape.php'; ?>