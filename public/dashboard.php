<?php
include __DIR__ . '/../src/cabecalho.php';
include __DIR__ . '/../src/conexao.php';

// === KPI CARDS ===
$r = $conn->query("SELECT COUNT(*) as total FROM doces");
$total_produtos = (int) $r->fetch_assoc()['total'];

$r = $conn->query("SELECT COALESCE(SUM(estoque), 0) as total FROM doces");
$total_estoque = (int) $r->fetch_assoc()['total'];

$r = $conn->query("SELECT COALESCE(SUM(preco * estoque), 0) as valor FROM doces");
$valor_inventario = (float) $r->fetch_assoc()['valor'];

$r = $conn->query("SELECT COUNT(*) as total FROM doces WHERE estoque <= estoque_minimo");
$produtos_alerta = (int) $r->fetch_assoc()['total'];

// === PRODUTOS POR CATEGORIA ===
$r = $conn->query("
    SELECT c.nome, COUNT(d.id) as total
    FROM categorias c
    LEFT JOIN doces d ON c.id = d.categoria_id
    GROUP BY c.id, c.nome
    ORDER BY total DESC
");
$cat_labels = []; $cat_data = [];
while ($row = $r->fetch_assoc()) {
    $cat_labels[] = $row['nome'];
    $cat_data[]   = (int) $row['total'];
}

// === ESTOQUE POR CATEGORIA ===
$r = $conn->query("
    SELECT c.nome, COALESCE(SUM(d.estoque), 0) as total
    FROM categorias c
    LEFT JOIN doces d ON c.id = d.categoria_id
    GROUP BY c.id, c.nome
    ORDER BY total DESC
");
$est_labels = []; $est_data = [];
while ($row = $r->fetch_assoc()) {
    $est_labels[] = $row['nome'];
    $est_data[]   = (int) $row['total'];
}

// === VALOR EM ESTOQUE POR CATEGORIA ===
$r = $conn->query("
    SELECT c.nome, COALESCE(SUM(d.preco * d.estoque), 0) as valor
    FROM categorias c
    LEFT JOIN doces d ON c.id = d.categoria_id
    GROUP BY c.id, c.nome
    ORDER BY valor DESC
");
$val_labels = []; $val_data = [];
while ($row = $r->fetch_assoc()) {
    $val_labels[] = $row['nome'];
    $val_data[]   = round((float) $row['valor'], 2);
}

// === STATUS DO ESTOQUE ===
$r = $conn->query("
    SELECT
        SUM(CASE WHEN estoque = 0                          THEN 1 ELSE 0 END) as zerado,
        SUM(CASE WHEN estoque > 0 AND estoque <= estoque_minimo THEN 1 ELSE 0 END) as baixo,
        SUM(CASE WHEN estoque > estoque_minimo             THEN 1 ELSE 0 END) as ok
    FROM doces
");
$status = $r->fetch_assoc();

// === COMPARATIVO DE ESTOQUE POR PRODUTO ===
$r = $conn->query("
    SELECT d.nome, d.estoque, d.estoque_minimo, c.nome as categoria
    FROM doces d
    LEFT JOIN categorias c ON d.categoria_id = c.id
    ORDER BY d.estoque ASC
");
$produtos_comp = [];
$max_estoque_comp = 1;
while ($row = $r->fetch_assoc()) {
    $produtos_comp[] = $row;
    if ((int)$row['estoque'] > $max_estoque_comp) {
        $max_estoque_comp = (int)$row['estoque'];
    }
}

// === ALERTAS DE ESTOQUE ===
$r = $conn->query("
    SELECT d.nome, d.estoque, d.estoque_minimo, d.preco, c.nome as categoria
    FROM doces d
    LEFT JOIN categorias c ON d.categoria_id = c.id
    WHERE d.estoque <= d.estoque_minimo
    ORDER BY d.estoque ASC
    LIMIT 20
");
$alertas = [];
while ($row = $r->fetch_assoc()) {
    $alertas[] = $row;
}
?>

<style>
.dashboard { padding: 24px; max-width: 1400px; margin: 0 auto; }
.dashboard-titulo { font-size: 1.6rem; margin-bottom: 24px; color: #333; }

/* Cards */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.db-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px 22px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    border-left: 5px solid #4361EE;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.db-card.amarelo { border-left-color: #FFD93D; }
.db-card.verde   { border-left-color: #6BCB77; }
.db-card.vermelho { border-left-color: #FF6B6B; }
.db-card-icone { font-size: 1.6rem; }
.db-card-valor { font-size: 1.9rem; font-weight: 700; color: #222; line-height: 1.1; }
.db-card-label { font-size: 0.78rem; color: #777; text-transform: uppercase; letter-spacing: 0.5px; }

/* Gráficos */
.dashboard-graficos {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.grafico-box {
    background: #fff;
    border-radius: 12px;
    padding: 20px 22px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
}
.grafico-box h2 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #555;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}
.grafico-box canvas { max-height: 280px; }

/* Tabela de alertas */
.dashboard-alertas {
    background: #fff;
    border-radius: 12px;
    padding: 20px 22px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    margin-bottom: 24px;
}
.dashboard-alertas h2 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #555;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}
.tabela-alertas { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
.tabela-alertas th {
    background: #f8f8f8;
    padding: 10px 14px;
    text-align: left;
    font-weight: 600;
    color: #555;
    border-bottom: 2px solid #eee;
}
.tabela-alertas td { padding: 10px 14px; border-bottom: 1px solid #f2f2f2; color: #333; }
.tabela-alertas tr:last-child td { border-bottom: none; }
.tabela-alertas tr:hover td { background: #fafafa; }
.badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 0.78rem;
    font-weight: 600;
}
.badge-zerado { background: #FF6B6B; color: #fff; }
.badge-baixo  { background: #FFD93D; color: #444; }
.badge-ok     { background: #6BCB77; color: #fff; }

/* Tabela comparativo por produto */
.tabela-comp { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.tabela-comp th {
    background: #f8f8f8;
    padding: 9px 12px;
    text-align: left;
    font-weight: 600;
    color: #555;
    border-bottom: 2px solid #eee;
    white-space: nowrap;
}
.tabela-comp td { padding: 8px 12px; border-bottom: 1px solid #f2f2f2; color: #333; vertical-align: middle; }
.tabela-comp tr:last-child td { border-bottom: none; }
.tabela-comp tr:hover td { background: #fafafa; }
.barra-wrap { display: flex; align-items: center; gap: 10px; }
.barra-track {
    flex: 1;
    height: 10px;
    background: #eee;
    border-radius: 6px;
    overflow: visible;
    position: relative;
    min-width: 80px;
}
.barra-fill {
    height: 100%;
    border-radius: 6px;
    transition: width 0.3s ease;
}
.barra-minimo-linha {
    position: absolute;
    top: -3px;
    height: 16px;
    width: 2px;
    background: #888;
    border-radius: 1px;
}
.barra-numero { font-weight: 600; font-size: 0.88rem; min-width: 28px; text-align: right; }

/* Responsivo */
@media (max-width: 960px) {
    .dashboard-cards   { grid-template-columns: repeat(2, 1fr); }
    .dashboard-graficos { grid-template-columns: 1fr; }
}
@media (max-width: 520px) {
    .dashboard-cards { grid-template-columns: 1fr; }
}
</style>

<div class="conteudo dashboard">

    <h1 class="dashboard-titulo">📊 Dashboard Analítico</h1>

    <!-- KPI CARDS -->
    <section aria-label="Métricas gerais do inventário">
        <div class="dashboard-cards">
            <div class="db-card" role="region" aria-label="Total de produtos cadastrados">
                <span class="db-card-icone" aria-hidden="true">🍬</span>
                <span class="db-card-valor"><?php echo $total_produtos; ?></span>
                <span class="db-card-label">Produtos Cadastrados</span>
            </div>
            <div class="db-card amarelo" role="region" aria-label="Total de unidades em estoque">
                <span class="db-card-icone" aria-hidden="true">📦</span>
                <span class="db-card-valor"><?php echo number_format($total_estoque, 0, ',', '.'); ?></span>
                <span class="db-card-label">Unidades em Estoque</span>
            </div>
            <div class="db-card verde" role="region" aria-label="Valor total do inventário">
                <span class="db-card-icone" aria-hidden="true">💰</span>
                <span class="db-card-valor">R$ <?php echo number_format($valor_inventario, 0, ',', '.'); ?></span>
                <span class="db-card-label">Valor do Inventário</span>
            </div>
            <div class="db-card vermelho" role="region" aria-label="Produtos em alerta de estoque">
                <span class="db-card-icone" aria-hidden="true">⚠️</span>
                <span class="db-card-valor"><?php echo $produtos_alerta; ?></span>
                <span class="db-card-label">Produtos em Alerta</span>
            </div>
        </div>
    </section>

    <!-- GRÁFICOS LINHA 1 -->
    <div class="dashboard-graficos">
        <div class="grafico-box">
            <h2>🍭 Produtos por Categoria</h2>
            <canvas id="graficoProdutosCat"
                    aria-label="Gráfico de rosca mostrando a distribuição de produtos por categoria"
                    role="img"></canvas>
        </div>
        <div class="grafico-box">
            <h2>📦 Estoque por Categoria (unidades)</h2>
            <canvas id="graficoEstoqueCat"
                    aria-label="Gráfico de barras horizontais mostrando o total de unidades em estoque por categoria"
                    role="img"></canvas>
        </div>
    </div>

    <!-- GRÁFICOS LINHA 2 -->
    <div class="dashboard-graficos">
        <div class="grafico-box">
            <h2>💰 Valor em Estoque por Categoria (R$)</h2>
            <canvas id="graficoValorCat"
                    aria-label="Gráfico de barras mostrando o valor financeiro do estoque por categoria"
                    role="img"></canvas>
        </div>
        <div class="grafico-box">
            <h2>🚦 Status Geral do Estoque</h2>
            <canvas id="graficoStatus"
                    aria-label="Gráfico de rosca mostrando a proporção de produtos por status de estoque: ok, baixo ou zerado"
                    role="img"></canvas>
        </div>
    </div>

    <!-- COMPARATIVO POR PRODUTO -->
    <div class="grafico-box" style="margin-bottom: 20px;">
        <h2>📊 Comparativo de Estoque por Produto — do menor para o maior</h2>
        <p style="font-size:0.8rem; color:#888; margin: -8px 0 14px;">
            A linha vertical cinza indica o estoque mínimo de cada produto.
        </p>
        <div style="overflow-y: auto; max-height: 480px;">
        <table class="tabela-comp" aria-label="Comparativo de estoque por produto ordenado do menor para o maior">
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col" style="min-width:220px;">Estoque Atual</th>
                    <th scope="col">Mínimo</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($produtos_comp as $p):
                $est   = (int)$p['estoque'];
                $min   = (int)$p['estoque_minimo'];
                $pct   = $max_estoque_comp > 0 ? round($est / $max_estoque_comp * 100) : 0;
                $pct_min = $max_estoque_comp > 0 ? round($min / $max_estoque_comp * 100) : 0;

                if ($est === 0) {
                    $cor = '#FF6B6B'; $badge_cls = 'badge-zerado'; $status_txt = 'Sem estoque';
                } elseif ($est <= $min) {
                    $cor = '#FFD93D'; $badge_cls = 'badge-baixo';  $status_txt = 'Estoque baixo';
                } else {
                    $cor = '#6BCB77'; $badge_cls = 'badge-ok';     $status_txt = 'Ok';
                }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['nome']); ?></td>
                    <td style="color:#777;"><?php echo htmlspecialchars($p['categoria'] ?? '—'); ?></td>
                    <td>
                        <div class="barra-wrap">
                            <div class="barra-track">
                                <div class="barra-fill" style="width:<?php echo $pct; ?>%; background:<?php echo $cor; ?>;"></div>
                                <div class="barra-minimo-linha" style="left:<?php echo $pct_min; ?>%;" title="Mínimo: <?php echo $min; ?>"></div>
                            </div>
                            <span class="barra-numero"><?php echo $est; ?></span>
                        </div>
                    </td>
                    <td style="color:#888;"><?php echo $min; ?></td>
                    <td><span class="badge <?php echo $badge_cls; ?>"><?php echo $status_txt; ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>

    <!-- TABELA DE ALERTAS -->
    <div class="dashboard-alertas">
        <h2>⚠️ Produtos com Estoque em Alerta (abaixo do mínimo configurado)</h2>
        <?php if (empty($alertas)): ?>
            <p>Nenhum produto em alerta de estoque. 🎉</p>
        <?php else: ?>
        <table class="tabela-alertas" aria-label="Lista de produtos com estoque crítico ou zerado">
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Preço Unit.</th>
                    <th scope="col">Estoque Atual</th>
                    <th scope="col">Estoque Mínimo</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alertas as $a): ?>
                <tr>
                    <td><?php echo htmlspecialchars($a['nome']); ?></td>
                    <td><?php echo htmlspecialchars($a['categoria'] ?? 'Sem categoria'); ?></td>
                    <td>R$ <?php echo number_format((float)$a['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo (int)$a['estoque']; ?></td>
                    <td><?php echo (int)$a['estoque_minimo']; ?></td>
                    <td>
                        <?php if ($a['estoque'] == 0): ?>
                            <span class="badge badge-zerado">Sem estoque</span>
                        <?php else: ?>
                            <span class="badge badge-baixo">Estoque baixo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="index.php?busca=<?php echo urlencode($a['nome']); ?>">Ver produto</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const CORES = [
    '#4361EE','#FF6B6B','#FFD93D','#6BCB77','#C77DFF',
    '#FF9F43','#54A0FF','#1DD1A1','#F368E0','#576574'
];

// 1. Produtos por categoria — Rosca
new Chart(document.getElementById('graficoProdutosCat'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($cat_labels, JSON_UNESCAPED_UNICODE); ?>,
        datasets: [{
            data: <?php echo json_encode($cat_data); ?>,
            backgroundColor: CORES,
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { padding: 14, font: { size: 12 } } }
        }
    }
});

// 2. Estoque por categoria — Barras horizontal
new Chart(document.getElementById('graficoEstoqueCat'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($est_labels, JSON_UNESCAPED_UNICODE); ?>,
        datasets: [{
            label: 'Unidades',
            data: <?php echo json_encode($est_data); ?>,
            backgroundColor: CORES,
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});

// 3. Valor em estoque por categoria — Barras verticais
new Chart(document.getElementById('graficoValorCat'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($val_labels, JSON_UNESCAPED_UNICODE); ?>,
        datasets: [{
            label: 'Valor (R$)',
            data: <?php echo json_encode($val_data); ?>,
            backgroundColor: '#4361EE',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'R$ ' + v.toLocaleString('pt-BR', { minimumFractionDigits: 0 })
                }
            }
        }
    }
});

// 4. Status do estoque — Rosca
new Chart(document.getElementById('graficoStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Sem Estoque', 'Estoque Baixo', 'Estoque Ok'],
        datasets: [{
            data: [
                <?php echo (int)$status['zerado']; ?>,
                <?php echo (int)$status['baixo']; ?>,
                <?php echo (int)$status['ok']; ?>
            ],
            backgroundColor: ['#FF6B6B', '#FFD93D', '#6BCB77'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { padding: 14, font: { size: 12 } } }
        }
    }
});
</script>

<?php include __DIR__ . '/../src/rodape.php'; ?>
