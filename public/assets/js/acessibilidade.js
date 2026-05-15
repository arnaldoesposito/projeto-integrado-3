/**
 * SISTEMA DE ACESSIBILIDADE
 * Controla Dark Mode e Tamanho de Fonte
 * Salva preferências no localStorage
 */

// Executar assim que o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    
    console.log('Sistema de acessibilidade carregado');
    
    // ============================================
    // VARIÁVEIS GLOBAIS
    // ============================================
    
    // Tamanhos disponíveis (na ordem)
    const tamanhos = ['pequeno', 'normal', 'grande', 'extragrande'];
    
    
    // ============================================
    // FUNÇÕES AUXILIARES
    // ============================================
    
    function atualizarIconeDarkMode(isDark) {
        const btnDarkMode = document.getElementById('btn-dark-mode');
        if (btnDarkMode) {
            if (isDark) {
                btnDarkMode.innerHTML = '☀️ Modo Claro';
                btnDarkMode.setAttribute('aria-label', 'Ativar modo claro');
            } else {
                btnDarkMode.innerHTML = '🌙 Modo Escuro';
                btnDarkMode.setAttribute('aria-label', 'Ativar modo escuro');
            }
        }
    }
    
    function obterTamanhoAtual() {
        // Verifica qual classe de tamanho está ativa
        for (let tamanho of tamanhos) {
            if (document.body.classList.contains('font-' + tamanho)) {
                return tamanho;
            }
        }
        return 'normal'; // Padrão
    }
    
    function aplicarTamanho(novoTamanho) {
        console.log('Aplicando tamanho:', novoTamanho);
        
        // Remove todas as classes de tamanho
        tamanhos.forEach(tamanho => {
            document.body.classList.remove('font-' + tamanho);
        });
        
        // Adiciona a nova classe (se não for normal)
        if (novoTamanho !== 'normal') {
            document.body.classList.add('font-' + novoTamanho);
        }
        
        // Salva no localStorage
        localStorage.setItem('fontSize', novoTamanho);
        
        // Atualiza estado dos botões
        atualizarBotoesFonte(novoTamanho);
        
        console.log('Tamanho aplicado. Classes do body:', document.body.className);
    }
    
    function atualizarBotoesFonte(tamanhoAtual) {
        const btnDiminuir = document.getElementById('btn-diminuir-fonte');
        const btnAumentar = document.getElementById('btn-aumentar-fonte');
        
        const indiceAtual = tamanhos.indexOf(tamanhoAtual);
        
        console.log('Atualizando botões. Tamanho atual:', tamanhoAtual, 'Índice:', indiceAtual);
        
        // Desabilita botão de diminuir se estiver no mínimo
        if (btnDiminuir) {
            if (indiceAtual === 0) {
                btnDiminuir.classList.add('disabled');
                btnDiminuir.setAttribute('disabled', 'true');
            } else {
                btnDiminuir.classList.remove('disabled');
                btnDiminuir.removeAttribute('disabled');
            }
        }
        
        // Desabilita botão de aumentar se estiver no máximo
        if (btnAumentar) {
            if (indiceAtual === tamanhos.length - 1) {
                btnAumentar.classList.add('disabled');
                btnAumentar.setAttribute('disabled', 'true');
            } else {
                btnAumentar.classList.remove('disabled');
                btnAumentar.removeAttribute('disabled');
            }
        }
    }
    
    
    // ============================================
    // INICIALIZAÇÃO - Carregar preferências salvas
    // ============================================
    
    const darkMode = localStorage.getItem('darkMode') === 'true';
    const fontSize = localStorage.getItem('fontSize') || 'normal';
    
    console.log('Preferências carregadas - Dark Mode:', darkMode, 'Font Size:', fontSize);
    
    // Aplicar preferências salvas
    if (darkMode) {
        document.body.classList.add('dark-mode');
        atualizarIconeDarkMode(true);
    }
    
    if (fontSize !== 'normal') {
        document.body.classList.add('font-' + fontSize);
    }
    
    atualizarBotoesFonte(fontSize);
    
    
    // ============================================
    // DARK MODE - Toggle
    // ============================================
    
    const btnDarkMode = document.getElementById('btn-dark-mode');
    
    if (btnDarkMode) {
        btnDarkMode.addEventListener('click', function() {
            const isDark = document.body.classList.toggle('dark-mode');
            
            console.log('Dark mode toggled:', isDark);
            
            // Salvar preferência
            localStorage.setItem('darkMode', isDark);
            
            // Atualizar ícone do botão
            atualizarIconeDarkMode(isDark);
        });
    } else {
        console.error('Botão de dark mode não encontrado!');
    }
    
    
    // ============================================
    // TAMANHO DE FONTE - Controles
    // ============================================
    
    const btnDiminuir = document.getElementById('btn-diminuir-fonte');
    const btnAumentar = document.getElementById('btn-aumentar-fonte');
    const btnResetar = document.getElementById('btn-resetar-fonte');
    
    if (btnDiminuir) {
        btnDiminuir.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botão diminuir clicado');
            
            const tamanhoAtual = obterTamanhoAtual();
            const indiceAtual = tamanhos.indexOf(tamanhoAtual);
            
            console.log('Tamanho atual:', tamanhoAtual, 'Índice:', indiceAtual);
            
            // Só diminui se não estiver no menor
            if (indiceAtual > 0) {
                const novoTamanho = tamanhos[indiceAtual - 1];
                console.log('Diminuindo para:', novoTamanho);
                aplicarTamanho(novoTamanho);
            } else {
                console.log('Já está no tamanho mínimo');
            }
        });
    } else {
        console.error('Botão diminuir não encontrado!');
    }
    
    if (btnAumentar) {
        btnAumentar.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botão aumentar clicado');
            
            const tamanhoAtual = obterTamanhoAtual();
            const indiceAtual = tamanhos.indexOf(tamanhoAtual);
            
            console.log('Tamanho atual:', tamanhoAtual, 'Índice:', indiceAtual);
            
            // Só aumenta se não estiver no maior
            if (indiceAtual < tamanhos.length - 1) {
                const novoTamanho = tamanhos[indiceAtual + 1];
                console.log('Aumentando para:', novoTamanho);
                aplicarTamanho(novoTamanho);
            } else {
                console.log('Já está no tamanho máximo');
            }
        });
    } else {
        console.error('Botão aumentar não encontrado!');
    }
    
    if (btnResetar) {
        btnResetar.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botão resetar clicado');
            aplicarTamanho('normal');
        });
    } else {
        console.error('Botão resetar não encontrado!');
    }
    
    console.log('Event listeners registrados com sucesso');
    
});