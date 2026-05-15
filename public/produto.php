<?php include __DIR__ . '/../src/cabecalho.php'; ?>
<?php include __DIR__ . '/../src/conexao.php'; ?>

<?php
if (!isset($_GET['id'])) {
    die("Produto não informado.");
}

$id = $_GET['id'];

$sql = "SELECT d.*, c.nome AS categoria 
        FROM doces d 
        LEFT JOIN categorias c ON d.categoria_id = c.id 
        WHERE d.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$doce = $result->fetch_assoc();

if (!$doce) {
    die("Produto não encontrado.");
}

// Lógica para a imagem (igual ao catálogo)
$caminho_imagem = "assets/imagens/categorias/default.png";

if (!empty($doce['imagem'])) {
    $img_web = "assets/imagens/" . htmlspecialchars($doce['imagem']);
    if (file_exists(__DIR__ . "/assets/imagens/" . $doce['imagem'])) {
        $caminho_imagem = $img_web;
    }
} elseif (!empty($doce['categoria'])) {
    $categoria_slug = strtolower(trim($doce['categoria']));
    $categoria_slug = str_replace(
        ['á','à','â','ã','é','è','ê','í','ì','î','ó','ò','ô','õ','ú','ù','û','ç',' '],
        ['a','a','a','a','e','e','e','i','i','i','o','o','o','o','u','u','u','c','_'],
        $categoria_slug
    );
    $img_cat_web = "assets/imagens/categorias/{$categoria_slug}.png";
    if (file_exists(__DIR__ . "/assets/imagens/categorias/{$categoria_slug}.png")) {
        $caminho_imagem = $img_cat_web;
    }
}

// Status do estoque
$status_estoque = '';
$classe_estoque = '';
if ($doce['estoque'] == 0) {
    $status_estoque = '❌ Sem estoque';
    $classe_estoque = 'status-critico';
} elseif ($doce['estoque'] <= 20) {
    $status_estoque = '⚠️ Estoque baixo';
    $classe_estoque = 'status-alerta';
} else {
    $status_estoque = '✅ Disponível';
    $classe_estoque = 'status-ok';
}
?>

<div class="conteudo">
    <div class="produto-detalhes-container">
        
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="index.php">Home</a> 
            <span>›</span>
            <?php if ($doce['categoria']): ?>
                <span><?php echo htmlspecialchars($doce['categoria']); ?></span>
                <span>›</span>
            <?php endif; ?>
            <span class="atual"><?php echo htmlspecialchars($doce['nome']); ?></span>
        </div>

        <div class="produto-detalhes">
            
            <!-- Coluna da Imagem -->
            <div class="produto-imagem-grande">
                <img src="<?php echo $caminho_imagem; ?>" alt="<?php echo htmlspecialchars($doce['nome']); ?>">
            </div>

            <!-- Coluna das Informações -->
            <div class="produto-info">
                
                <h1 class="produto-titulo"><?php echo htmlspecialchars($doce['nome']); ?></h1>
                
                <?php if ($doce['categoria']): ?>
                    <div class="produto-categoria">
                        <span class="icone">🏷️</span>
                        <span><?php echo htmlspecialchars($doce['categoria']); ?></span>
                    </div>
                <?php endif; ?>

                <div class="produto-preco-destaque">
                    R$ <?php echo number_format($doce['preco'], 2, ',', '.'); ?>
                </div>

                <div class="produto-estoque">
                    <span class="<?php echo $classe_estoque; ?>">
                        <?php echo $status_estoque; ?>
                    </span>
                    <span class="estoque-quantidade">
                        (<?php echo $doce['estoque']; ?> unidades)
                    </span>
                </div>

                <?php if ($doce['descricao']): ?>
                    <div class="produto-descricao">
                        <h3>📝 Descrição</h3>
                        <p><?php echo nl2br(htmlspecialchars($doce['descricao'])); ?></p>
                    </div>
                <?php endif; ?>

                <div class="produto-acoes">
                    <a href="index.php" class="btn-voltar-produto">
                        ← Voltar para a Home
                    </a>
                    <a href="editar.php?id=<?php echo $doce['id']; ?>" class="btn-editar-produto">
                        ✏️ Editar Produto
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../src/rodape.php'; ?>