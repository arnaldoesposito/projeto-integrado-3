-- Produtos extras para a Distribuidora Estrela Real
-- Execute APÓS categorias_extras.sql
-- Categorias: 1=Balas, 2=Chocolates, 3=Pirulitos, 4=Gomas e Gelatinas,
--             5=Caramelos, 6=Bombons, 7=Biscoitos e Bolachas, 8=Marshmallows, 9=Drágeas e Confeitos

-- BALAS (categoria_id = 1)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bala de Morango Recheada', 1.99, 'Bala macia com recheio cremoso sabor morango. Embalagem com 50 unidades.', 1, NULL, 320);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bala de Mel com Propólis', 3.50, 'Bala dura com mel puro e extrato de propólis. Ótima para a garganta.', 1, NULL, 180);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bala de Uva Preta', 2.10, 'Bala com intenso sabor de uva preta. Embalagem com 30 unidades.', 1, NULL, 0);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bala de Coco com Leite Condensado', 2.80, 'Bala macia e cremosa feita com coco e leite condensado.', 1, NULL, 14);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bala Azeda de Frutas Mistas', 1.75, 'Mix de balas azedas com sabores de laranja, limão e framboesa.', 1, NULL, 410);

-- CHOCOLATES (categoria_id = 2)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Chocolate ao Leite 70g', 6.90, 'Tablete de chocolate ao leite suave e cremoso. 70g.', 2, NULL, 95);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Chocolate Meio Amargo 80% Cacau', 8.50, 'Tablete intenso com 80% de cacau. Para os apreciadores de chocolate amargo.', 2, NULL, 60);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Chocolate com Avelã e Crocante', 9.99, 'Tablete de chocolate ao leite com pedaços de avelã e flocos crocantes.', 2, NULL, 45);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Chocolate Branco com Morango', 7.80, 'Tablete de chocolate branco com gotas de morango desidratado.', 2, NULL, 0);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Chocolate Amargo com Laranja', 10.50, 'Combinação refinada de chocolate amargo com raspas de laranja.', 2, NULL, 28);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Chocolate ao Leite com Amendoim', 7.20, 'Tablete recheado com amendoim torrado e caramelizado.', 2, NULL, 110);

-- PIRULITOS (categoria_id = 3)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Pirulito de Melancia', 1.50, 'Pirulito grande sabor melancia com toque azedo na borda.', 3, NULL, 250);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Pirulito Recheado de Chocolate', 2.20, 'Pirulito de baunilha com recheio cremoso de chocolate ao leite.', 3, NULL, 190);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Pirulito de Algodão Doce', 1.80, 'Pirulito com sabor autêntico de algodão doce. Cor rosa vibrante.', 3, NULL, 8);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Pirulito Gigante Colorido', 5.50, 'Pirulito gigante em espiral com 5 sabores de frutas. Perfeito para festas.', 3, NULL, 75);

-- GOMAS E GELATINAS (categoria_id = 4)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Gelatina de Morango em Cubos', 3.90, 'Cubinhos de gelatina sabor morango com açúcar cristal. Pacote com 200g.', 4, NULL, 130);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Ursinhos de Goma Coloridos', 4.50, 'Mix de ursinhos de goma com 6 sabores de frutas. Pacote com 250g.', 4, NULL, 220);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Minhocas de Goma Ácidas', 3.80, 'Minhocas de goma com camada ácida de açúcar cristalizado. Pacote com 150g.', 4, NULL, 0);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Dentes e Dentaduras de Goma', 4.20, 'Formato divertido de dentes em goma sabor framboesa. Pacote com 180g.', 4, NULL, 95);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Anel de Goma Sabor Melancia', 2.90, 'Anéis de goma com sabor melancia e borda de açúcar colorido.', 4, NULL, 17);

-- CARAMELOS (categoria_id = 5)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Caramelo de Manteiga com Sal', 4.80, 'Caramelo macio com manteiga de qualidade e um toque de sal marinho.', 5, NULL, 140);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Caramelo de Doce de Leite', 3.60, 'Caramelo cremoso com intenso sabor de doce de leite. Pacote com 20 unidades.', 5, NULL, 200);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Caramelo de Baunilha Cremoso', 3.90, 'Caramelo suave sabor baunilha, macio e envolvente.', 5, NULL, 5);

-- BOMBONS (categoria_id = 6)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bombom de Trufa ao Leite', 5.50, 'Bombom com casca de chocolate ao leite e recheio de trufa cremosa.', 6, NULL, 85);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bombom de Amendoim com Caramelo', 4.90, 'Bombom recheado com pasta de amendoim e caramelo derretido.', 6, NULL, 120);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bombom de Menta com Chocolate Amargo', 6.20, 'Bombom refrescante com recheio de menta envolto em chocolate amargo.', 6, NULL, 0);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Caixa de Bombons Sortidos 12un', 22.90, 'Caixa elegante com 12 bombons sortidos: trufa, caramelo, avelã e menta.', 6, NULL, 40);

-- BISCOITOS E BOLACHAS (categoria_id = 7)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Biscoito Wafer de Chocolate', 4.50, 'Biscoito wafer crocante com recheio triplo de chocolate. Pacote com 140g.', 7, NULL, 175);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Bolacha Recheada de Baunilha', 3.80, 'Bolacha crocante com recheio de baunilha. Pacote com 120g.', 7, NULL, 300);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Cookie com Gotas de Chocolate', 6.90, 'Cookie americano artesanal com generosas gotas de chocolate. Unidade 80g.', 7, NULL, 12);

-- MARSHMALLOWS (categoria_id = 8)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Marshmallow Torrado Sabor Baunilha', 5.20, 'Marshmallow macio com sabor baunilha, perfeito para derreter na fogueira.', 8, NULL, 90);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Marshmallow Colorido para Festa', 4.70, 'Pacote com marshmallows coloridos sortidos, ideal para decoração de festas.', 8, NULL, 160);

-- DRÁGEAS E CONFEITOS (categoria_id = 9)
INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Drágea de Chocolate Colorida', 5.90, 'Confeitos de chocolate ao leite com casca colorida crocante. Pote com 200g.', 9, NULL, 135);

INSERT INTO doces (nome, preco, descricao, categoria_id, imagem, estoque)
VALUES ('Confete de Açúcar para Bolo', 3.20, 'Drágeas de açúcar coloridas para decoração de bolos e doces. Pote com 100g.', 9, NULL, 0);
