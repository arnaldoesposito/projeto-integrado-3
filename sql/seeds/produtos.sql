-- ============================================================
-- Produtos da Distribuidora Estrela Real
-- Execute APÓS categorias.sql
-- Categorias: 1=Balas, 2=Chocolates, 3=Pirulitos, 4=Gomas e Gelatinas
--             5=Caramelos, 6=Bombons, 7=Biscoitos e Bolachas
--             8=Marshmallows, 9=Drágeas e Confeitos
-- ============================================================

-- ======================== FASE 1 ========================

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque) VALUES
('Bala de Morango', 1.50, 'Deliciosa bala sabor morango', 1, NULL, 150),
('Bala de Hortelã', 1.80, 'Bala refrescante de hortelã', 1, NULL, 100),
('Caramelo Macio', 1.70, 'Caramelo derrete na boca', 1, NULL, 200),
('Bala de Gelatina', 1.60, 'Bala de gelatina sortida', 1, NULL, 180),
('Bala de Canela', 1.90, 'Sabor intenso de canela', 1, NULL, 0),
('Bala de Caramelo Salgado', 2.50, 'Mistura de doce e salgado', 1, NULL, 12),
('Bala Azedinha de Limão', 1.70, 'Explosão cítrica', 1, NULL, 0),
('Chocolate ao Leite', 6.99, 'Tablete de chocolate cremoso', 2, NULL, 80),
('Chocolate Meio Amargo', 7.99, 'Chocolate com 50% cacau', 2, NULL, 60),
('Chocolate Branco', 6.50, 'Chocolate branco com baunilha', 2, NULL, 40),
('Trufa de Maracujá', 3.99, 'Trufa artesanal sabor maracujá', 2, NULL, 30),
('Trufa de Limão', 3.99, 'Trufa artesanal com toque cítrico', 2, NULL, 25),
('Chocolate Crocante', 8.50, 'Chocolate com pedaços de castanha', 2, NULL, 50),
('Caixa Surpresa de Doces', 12.99, 'Seleção sortida de doces da casa', 2, NULL, 5),
('Chocolate com Pimenta', 7.20, 'Chocolate picante para os ousados', 2, NULL, 10),
('Trufa de Coco', 3.80, 'Trufa recheada com coco fresco', 2, NULL, 0),
('Chocolate com Avelã', 9.90, 'Chocolate cremoso com pedaços de avelã', 2, NULL, 0),
('Tablete de Chocolate Branco com Frutas', 8.70, 'Com pedaços de morango e banana', 2, NULL, 25),
('Trufa de Frutas Vermelhas', 4.20, 'Recheio com morango, framboesa e amora', 2, NULL, 80),
('Mini Chocolates Sortidos', 5.50, 'Pacote com sabores variados', 2, NULL, 60),
('Pirulito de Coração', 2.00, 'Pirulito doce e divertido', 3, NULL, 120),
('Pirulito Recheado', 2.50, 'Pirulito com recheio de morango', 3, NULL, 90),
('Pirulito Gigante', 4.20, 'Pirulito grande para presentear', 3, NULL, 15),
('Pirulito Arco-Íris', 3.10, 'Pirulito colorido em espiral', 3, NULL, 60),
('Pirulito de Leite Condensado', 2.10, 'Doce cremoso em formato de pirulito', 3, NULL, 5),
('Pirulito com Glitter Comestível', 4.90, 'Brilho divertido e saboroso', 3, NULL, 0),
('Pirulito de Café', 3.00, 'Energia em forma de doce', 3, NULL, 0);

-- ======================== FASE 2 ========================
-- Descomente abaixo para inserir mais produtos (requer categorias 1–9)

/*
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque) VALUES
('Bala de Morango Recheada', 1.99, 'Bala macia com recheio cremoso sabor morango. Embalagem com 50 unidades.', 1, NULL, 320),
('Bala de Mel com Propólis', 3.50, 'Bala dura com mel puro e extrato de propólis. Ótima para a garganta.', 1, NULL, 180),
('Bala de Uva Preta', 2.10, 'Bala com intenso sabor de uva preta. Embalagem com 30 unidades.', 1, NULL, 0),
('Bala de Coco com Leite Condensado', 2.80, 'Bala macia e cremosa feita com coco e leite condensado.', 1, NULL, 14),
('Bala Azeda de Frutas Mistas', 1.75, 'Mix de balas azedas com sabores de laranja, limão e framboesa.', 1, NULL, 410),
('Chocolate ao Leite 70g', 6.90, 'Tablete de chocolate ao leite suave e cremoso. 70g.', 2, NULL, 95),
('Chocolate Meio Amargo 80% Cacau', 8.50, 'Tablete intenso com 80% de cacau. Para os apreciadores de chocolate amargo.', 2, NULL, 60),
('Chocolate com Avelã e Crocante', 9.99, 'Tablete de chocolate ao leite com pedaços de avelã e flocos crocantes.', 2, NULL, 45),
('Chocolate Branco com Morango', 7.80, 'Tablete de chocolate branco com gotas de morango desidratado.', 2, NULL, 0),
('Chocolate Amargo com Laranja', 10.50, 'Combinação refinada de chocolate amargo com raspas de laranja.', 2, NULL, 28),
('Chocolate ao Leite com Amendoim', 7.20, 'Tablete recheado com amendoim torrado e caramelizado.', 2, NULL, 110),
('Pirulito de Melancia', 1.50, 'Pirulito grande sabor melancia com toque azedo na borda.', 3, NULL, 250),
('Pirulito Recheado de Chocolate', 2.20, 'Pirulito de baunilha com recheio cremoso de chocolate ao leite.', 3, NULL, 190),
('Pirulito de Algodão Doce', 1.80, 'Pirulito com sabor autêntico de algodão doce. Cor rosa vibrante.', 3, NULL, 8),
('Pirulito Gigante Colorido', 5.50, 'Pirulito gigante em espiral com 5 sabores de frutas. Perfeito para festas.', 3, NULL, 75),
('Gelatina de Morango em Cubos', 3.90, 'Cubinhos de gelatina sabor morango com açúcar cristal. Pacote com 200g.', 4, NULL, 130),
('Ursinhos de Goma Coloridos', 4.50, 'Mix de ursinhos de goma com 6 sabores de frutas. Pacote com 250g.', 4, NULL, 220),
('Minhocas de Goma Ácidas', 3.80, 'Minhocas de goma com camada ácida de açúcar cristalizado. Pacote com 150g.', 4, NULL, 0),
('Dentes e Dentaduras de Goma', 4.20, 'Formato divertido de dentes em goma sabor framboesa. Pacote com 180g.', 4, NULL, 95),
('Anel de Goma Sabor Melancia', 2.90, 'Anéis de goma com sabor melancia e borda de açúcar colorido.', 4, NULL, 17),
('Caramelo de Manteiga com Sal', 4.80, 'Caramelo macio com manteiga de qualidade e um toque de sal marinho.', 5, NULL, 140),
('Caramelo de Doce de Leite', 3.60, 'Caramelo cremoso com intenso sabor de doce de leite. Pacote com 20 unidades.', 5, NULL, 200),
('Caramelo de Baunilha Cremoso', 3.90, 'Caramelo suave sabor baunilha, macio e envolvente.', 5, NULL, 5),
('Bombom de Trufa ao Leite', 5.50, 'Bombom com casca de chocolate ao leite e recheio de trufa cremosa.', 6, NULL, 85),
('Bombom de Amendoim com Caramelo', 4.90, 'Bombom recheado com pasta de amendoim e caramelo derretido.', 6, NULL, 120),
('Bombom de Menta com Chocolate Amargo', 6.20, 'Bombom refrescante com recheio de menta envolto em chocolate amargo.', 6, NULL, 0),
('Caixa de Bombons Sortidos 12un', 22.90, 'Caixa elegante com 12 bombons sortidos: trufa, caramelo, avelã e menta.', 6, NULL, 40),
('Biscoito Wafer de Chocolate', 4.50, 'Biscoito wafer crocante com recheio triplo de chocolate. Pacote com 140g.', 7, NULL, 175),
('Bolacha Recheada de Baunilha', 3.80, 'Bolacha crocante com recheio de baunilha. Pacote com 120g.', 7, NULL, 300),
('Cookie com Gotas de Chocolate', 6.90, 'Cookie americano artesanal com generosas gotas de chocolate. Unidade 80g.', 7, NULL, 12),
('Marshmallow Torrado Sabor Baunilha', 5.20, 'Marshmallow macio com sabor baunilha, perfeito para derreter na fogueira.', 8, NULL, 90),
('Marshmallow Colorido para Festa', 4.70, 'Pacote com marshmallows coloridos sortidos, ideal para decoração de festas.', 8, NULL, 160),
('Drágea de Chocolate Colorida', 5.90, 'Confeitos de chocolate ao leite com casca colorida crocante. Pote com 200g.', 9, NULL, 135),
('Confete de Açúcar para Bolo', 3.20, 'Drágeas de açúcar coloridas para decoração de bolos e doces. Pote com 100g.', 9, NULL, 0);
*/
