/* COLETA */
CREATE INDEX index_coleta_idcoleta ON coleta (idcoleta);
CREATE INDEX index_coleta_idstatus ON coleta (idstatus);
CREATE INDEX index_coleta_idveiculo ON coleta (idveiculo);
CREATE INDEX index_coleta_versao ON coleta (versao);
CREATE INDEX index_coleta_hora ON coleta (hora);
CREATE INDEX index_coleta_data ON coleta (data);

/* CLIENTE */
CREATE INDEX index_cliente_idcliente ON cliente (idcliente);
CREATE INDEX index_cliente_nome ON cliente (nome);

/* PESSOA */
CREATE INDEX index_pessoa_idpessoa ON pessoa (idpessoa);
CREATE INDEX index_pessoa_cidade ON pessoa (cidade);