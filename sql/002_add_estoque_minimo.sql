-- Adiciona a coluna estoque_minimo na tabela doces
-- Execute este arquivo no phpMyAdmin antes de usar o dashboard atualizado

ALTER TABLE doces ADD COLUMN estoque_minimo INT NOT NULL DEFAULT 10;
