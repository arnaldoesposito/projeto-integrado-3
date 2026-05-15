<?php
include __DIR__ . '/../src/conexao.php';

// Inicia a sessão se necessário (pode vir do cabeçalho se for incluído)
// session_start(); // Remova se cabecalho.php já inicia

// Preparar filtros dinâmicos com prepared statement
$condicoes = ["d.estoque > 0"]; // Exibir apenas produtos com estoque > 0 por padrão
$params = [];
$types = "";

if (!empty($_GET['busca'])) {
    $condicoes[] = "d.nome LIKE ?";
    $params[] = "%" . $_GET['busca'] . "%";
    $types .= "s";
}

if (!empty($_GET['categoria'])) {
    $categoria = (int) $_GET['categoria'];
    if ($categoria > 0) {
        $condicoes[] = "d.categoria_id = ?";
        $params[] = $categoria;
        $types .= "i";
    }
}

if (!empty($_GET['preco_min'])) {
    $preco_min_str = str_replace(',', '.', $_GET['preco_min']);
    if (is_numeric($preco_min_str)) {
        $condicoes[] = "d.preco >= ?";
        $params[] = (float) $preco_min_str;
        $types .= "d";
    }
}

if (!empty($_GET['preco_max'])) {
    $preco_max_str = str_replace(',', '.', $_GET['preco_max']);
    if (is_numeric($preco_max_str)) {
        $condicoes[] = "d.preco <= ?";
        $params[] = (float) $preco_max_str;
        $types .= "d";
    }
}

$condicaoFinal = implode(' AND ', $condicoes);

// Definir ordenação (valores fixos via whitelist — seguro contra SQL injection)
$ordem = "d.nome ASC"; // padrão
if (!empty($_GET['ordenar'])) {
    switch ($_GET['ordenar']) {
        case 'nome_az':
            $ordem = "d.nome ASC";
            break;
        case 'nome_za':
            $ordem = "d.nome DESC";
            break;
        case 'preco_menor':
            $ordem = "d.preco ASC";
            break;
        case 'preco_maior':
            $ordem = "d.preco DESC";
            break;
        default:
            $ordem = "d.nome ASC";
            break;
    }
}

$sql = "SELECT d.id, d.nome, c.nome AS categoria, d.preco, d.descricao, d.imagem, d.estoque
        FROM doces d
        LEFT JOIN categorias c ON d.categoria_id = c.id
        WHERE $condicaoFinal
        ORDER BY $ordem";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();


// Inclui o cabeçalho público (sem autenticação)
include __DIR__ . '/../src/cabecalho_publico.php';
?>
<div class="conteudo">
    <h1>Catálogo de Produtos</h1>

    <!-- FORMULÁRIO DE FILTROS -->
    <form method="GET" action="catalogo.php" class="catalogo-filter-form">
        
        <div class="form-row">
            <label for="busca">Buscar produto:</label>
            <input type="text" 
                   name="busca" 
                   id="busca"
                   placeholder="Digite o nome do produto..." 
                   value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
        </div>

        <div class="form-row">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria">
                <option value="">Todas as Categorias</option>
                <?php
                $queryCategorias = mysqli_query($conn, "SELECT id, nome FROM categorias WHERE ativo = 1 ORDER BY nome ASC");
                if ($queryCategorias) {
                     while($cat = mysqli_fetch_assoc($queryCategorias)):
                        $selected = (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id']) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($cat['nome']); ?>
                        </option>
                    <?php endwhile;
                } else {
                     echo "<option value=''>Erro ao carregar categorias</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-row linha-horizontal">
            <div>
                <label for="preco_min">Preço mínimo:</label>
                <input type="number" 
                       name="preco_min" 
                       id="preco_min"
                       step="0.01"
                       placeholder="R$ 0,00" 
                       value="<?php echo isset($_GET['preco_min']) ? htmlspecialchars($_GET['preco_min']) : ''; ?>">
            </div>
            <div>
                <label for="preco_max">Preço máximo:</label>
                <input type="number" 
                       name="preco_max" 
                       id="preco_max"
                       step="0.01"
                       placeholder="R$ 999,99" 
                       value="<?php echo isset($_GET['preco_max']) ? htmlspecialchars($_GET['preco_max']) : ''; ?>">
            </div>
        </div>

        <div class="form-row">
            <label for="ordenar">Ordenar por:</label>
            <select name="ordenar" id="ordenar">
                <option value="">Padrão</option>
                <option value="nome_az" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'nome_az') ? 'selected' : ''; ?>>Nome (A → Z)</option>
                <option value="nome_za" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'nome_za') ? 'selected' : ''; ?>>Nome (Z → A)</option>
                <option value="preco_menor" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'preco_menor') ? 'selected' : ''; ?>>Menor Preço</option>
                <option value="preco_maior" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'preco_maior') ? 'selected' : ''; ?>>Maior Preço</option>
            </select>
        </div>

        <div class="form-row form-buttons-row">
            <input type="submit" value="Filtrar Produtos">
            <a href="catalogo.php">Limpar Filtros</a>
        </div>
    </form>

    <!-- CONTADOR DE RESULTADOS -->
    <?php 
    $total_produtos = mysqli_num_rows($resultado);
    $tem_filtros = !empty($_GET['busca']) || !empty($_GET['categoria']) || !empty($_GET['preco_min']) || !empty($_GET['preco_max']) || !empty($_GET['ordenar']);
    ?>
    <div class="contador-resultados">
        <?php if ($tem_filtros): ?>
            <p>📦 <strong><?php echo $total_produtos; ?></strong> produto(s) encontrado(s) com os filtros aplicados</p>
        <?php else: ?>
            <p>📦 Exibindo <strong><?php echo $total_produtos; ?></strong> produto(s) disponíveis</p>
        <?php endif; ?>
    </div>

    <!-- GRID DE PRODUTOS -->
    <div class="produtos">
    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <?php while($produto = mysqli_fetch_assoc($resultado)): ?>
            <div class="produto">
                <?php
                    $caminho_imagem = "assets/imagens/categorias/default.png";

                    if (!empty($produto['imagem'])) {
                        $img_web = "assets/imagens/" . htmlspecialchars($produto['imagem']);
                        if (file_exists(__DIR__ . "/assets/imagens/" . $produto['imagem'])) {
                            $caminho_imagem = $img_web;
                        }
                    } elseif (!empty($produto['categoria'])) {
                        $categoria_slug = strtolower(trim($produto['categoria']));
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
                ?>
                <img src="<?php echo $caminho_imagem; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                <h2><?php echo htmlspecialchars($produto['nome']); ?></h2>
                <p class="card-categoria"><?php echo htmlspecialchars($produto['categoria'] ?? 'Sem categoria'); ?></p>
                <p class="card-descricao"><?php echo htmlspecialchars(substr($produto['descricao'], 0, 60)) . (strlen($produto['descricao']) > 60 ? '...' : ''); ?></p>
                <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nenhum produto encontrado com os filtros aplicados.</p>
    <?php endif; ?>
    </div> <!-- Fecha .produtos -->

</div> <!-- Fecha .conteudo -->

<?php include __DIR__ . '/../src/rodape.php'; ?>