<?php include __DIR__ . '/../src/cabecalho.php'; ?>
<?php include __DIR__ . '/../src/conexao.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $categoria_id = $_POST['categoria_id'];
    $estoque = $_POST['estoque'];
    $estoque_minimo = $_POST['estoque_minimo'];

    $imagem = null;
    if (!empty($_FILES['imagem']['name'])) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . "/assets/imagens/" . $imagem);
    }

    $sql = "INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque, estoque_minimo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsisii", $nome, $preco, $descricao, $categoria_id, $imagem, $estoque, $estoque_minimo);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<div class="conteudo">
    <h1>Cadastrar Novo Produto</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
        </div>

        <div class="form-row">
            <label for="preco">Preço:</label>
            <input type="number" name="preco" id="preco" step="0.01" required>
        </div>

        <div class="form-row">
            <label for="categoria_id">Categoria:</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="">Selecione</option>
                <?php
                $cats = $conn->query("SELECT * FROM categorias ORDER BY nome ASC");
                while ($c = $cats->fetch_assoc()) {
                    echo "<option value='{$c['id']}'>{$c['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-row">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required></textarea>
        </div>

        <div class="form-row">
            <label for="imagem">Imagem:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*">
        </div>

        <div class="form-row">
            <label for="estoque">Estoque:</label>
            <input type="number" name="estoque" id="estoque" min="0" required>
        </div>

        <div class="form-row">
            <label for="estoque_minimo">Estoque Mínimo:</label>
            <input type="number" name="estoque_minimo" id="estoque_minimo" min="0" value="10" required>
        </div>

        <div class="form-buttons-row">
            <input type="submit" value="Cadastrar Produto">
        </div>
    </form>
</div>

<?php include __DIR__ . '/../src/rodape.php'; ?>