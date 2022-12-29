# SELECT da view devedores que trás todos os devedores no sistema
SELECT * FROM (SELECT cliente.id_cliente,
					  cliente.nome_cliente,
					  cliente.situacao,
					  cliente.descricao,
					  cliente.data_cliente,
					  cliente.status_cliente,
					  cliente.tipo_cliente,
	    			  SUM(pedido.valor) AS divida
  				 FROM cliente 
 				 LEFT JOIN contas ON cliente.id_cliente = contas.cliente_id_cliente
 				 LEFT JOIN pedido ON contas.pedido_id_pedido = pedido.id_pedido
 				GROUP BY cliente.id_cliente) AS clientes_dev WHERE clientes_dev.divida > 0 
 
 SELECT * FROM devedores WHERE divida > 0 AND devedores.id_cliente = 7
 
 
 # Agrupa as vendas pelo seu tipo de pagamento
 SELECT pedido.tipo,
        SUM(pedido.valor) AS total_de_vendas 
   FROM pedido
  GROUP BY pedido.tipo
  
# -------------
SELECT pedido.id_pedido
  FROM pedido
  WHERE 

UPDATE devedores SET devedores.divida = 0 WHERE devedores.divida = NULL
  
  SELECT id_cliente,
  			nome_cliente,
			situacao, 
			divida,
			tipo_cliente, 
			`status_cliente`, 
			DATE_FORMAT(data_cliente, '%d/%m/%Y') as data_cliente,
			descricao
	 FROM devedores
	 
# Para encontrar os clientes Em Aberto
SELECT contas.cliente_id_cliente
  FROM pedido
 INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido 
 WHERE CURRENT_TIMESTAMP()
       BETWEEN pedido.`data` 
	   AND DATE_ADD(pedido.`data`,INTERVAL 1 MONTH)
	   

# Para encontrar os clientes Em divida
SELECT contas.cliente_id_cliente
  FROM pedido
 INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido 
 WHERE CURRENT_TIMESTAMP() > DATE_ADD(pedido.`data`,INTERVAL 2 Day)
	   
# Para encontar os clientes Em Dia
SELECT devedores.id_cliente FROM devedores WHERE devedores.divida = 0

  
SELECT DATE_ADD(CAST(pedido.`data` AS DATE),INTERVAL 10 DAY),
		 CAST(pedido.`data` AS DATE)
  FROM pedido

SELECT MIN(pedido.`data`) FROM pedido
  

  
  
 UPDATE cliente SET situacao = "Em aberto" 
  WHERE cliente.id_cliente in (
        SELECT contas.cliente_id_cliente
          FROM pedido
 		 INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido 
 		 WHERE CURRENT_TIMESTAMP()
               BETWEEN pedido.`data` 
           		   AND DATE_ADD(pedido.`data`,INTERVAL 1 MONTH)
	 );
	 
# ------------------------------------------------
 UPDATE cliente SET situacao = "Em débito" 
  WHERE cliente.id_cliente in (
		SELECT contas.cliente_id_cliente
 		  FROM pedido
 		 INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido 
 		 WHERE CURRENT_TIMESTAMP() > DATE_ADD(pedido.`data`,INTERVAL 1 MONTH)
	 );

# ------------------------------------------------
 UPDATE cliente SET situacao = "Em dia" 
  WHERE cliente.id_cliente in (
        SELECT devedores.id_cliente 
		  FROM devedores
		 WHERE devedores.divida = 0
	 );
  
# ------------------------------------------------

SELECT pedido.valor
  FROM pedido
  WHERE pedido.id_pedido 
        IN(SELECT contas.pedido_id_pedido 
             FROM contas WHERE contas.cliente_id_cliente = 7)
             
             
             
             
SELECT pedido.id_pedido,
	   pedido.valor,
       cliente.credito,
	   cliente.credito - pedido.valor AS sobra
  FROM cliente
 INNER JOIN contas ON cliente.id_cliente = contas.cliente_id_cliente
 INNER JOIN pedido ON contas.pedido_id_pedido = pedido.id_pedido
 WHERE cliente.credito >= pedido.valor
  
  
  
SELECT * FROM (SELECT cliente.id_cliente,
					  cliente.nome_cliente,
					  cliente.situacao,
					  cliente.descricao,
					  cliente.data_cliente,
					  cliente.status_cliente,
					  cliente.tipo_cliente,
	    			  IFNULL(SUM(pedido.valor) - cliente.credito, 0) AS divida
  				 FROM cliente 
 				 LEFT JOIN contas ON cliente.id_cliente = contas.cliente_id_cliente
 				 LEFT JOIN pedido ON contas.pedido_id_pedido = pedido.id_pedido
 				GROUP BY cliente.id_cliente) AS clientes_dev 
  
  
  
  
  
SELECT devedores.id_cliente 
		  FROM devedores
		 WHERE devedores.divida = 0
  
  
  SELECT pedido.id_pedido,
  	        cliente.id_cliente,
  			pedido.valor
	   FROM pedido
	  INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido
	  INNER JOIN cliente ON cliente.id_cliente = contas.cliente_id_cliente
	  INNER JOIN devedores ON devedores.id_cliente = cliente.id_cliente
	  WHERE pedido.valor <= cliente.credito AND cliente.id_cliente = 7;

SELECT pedido.valor FROM pedido WHERE pedido.id_pedido = 7
CALL pagamento(7);

CALL Up_devedores_pagamento();

INSERT INTO cozinha (cozinha_id_pedido, cozinha_id_produto) SELECT pedido.id_pedido,
	   itens_vendidos.produto_id_produto
  FROM pedido
  INNER JOIN itens_vendidos ON pedido.id_pedido = itens_vendidos.pedido_id_pedido
  INNER JOIN produto ON itens_vendidos.produto_id_produto = produto.id_produto
  WHERE produto.tipo = 'Preparo' AND pedido.id_pedido = 9
  
SELECT cozinha.cozinha_id_pedido,
	   produto.nome,
	   itens_vendidos.quantia,
	   produto.imagem
  FROM cozinha
 INNER JOIN itens_vendidos ON itens_vendidos.pedido_id_pedido = cozinha.cozinha_id_pedido
 INNER JOIN produto ON cozinha.cozinha_id_produto =  produto.id_produto
 WHERE cozinha.`status` = 'Preparo'
 
 
  SELECT itens_vendidos.pedido_id_pedido,
	 	   itens_vendidos.produto_id_produto
  	  FROM itens_vendidos
 
 SELECT produto.id_produto
   FROM produto
  WHERE produto.quantia <= produto.quantia_minima
  
CALL Up_Cliente_Situacao;

SELECT cliente.credito,
	   devedores.divida
  FROM cliente
 INNER JOIN devedores ON devedores.id_cliente = cliente.id_cliente
 WHERE devedores.divida 
	
 SELECT pedido.id_pedido
	   FROM pedido
	  INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido
	  INNER JOIN cliente ON cliente.id_cliente = contas.cliente_id_cliente
	  INNER JOIN devedores ON devedores.id_cliente = cliente.id_cliente
	  WHERE pedido.valor <= cliente.credito
 
 SELECT pedido.id_pedido
	   FROM pedido
	  INNER JOIN contas ON pedido.id_pedido = contas.pedido_id_pedido
	  INNER JOIN cliente ON cliente.id_cliente = contas.cliente_id_cliente
	  INNER JOIN devedores ON devedores.id_cliente = cliente.id_cliente
	  WHERE pedido.valor <= cliente.credito AND cliente.id_cliente = 22
	  
	  
SELECT * FROM pratos_cozinha ORDER BY `status` = 'Pronto' AND id_cozinha DESC
 
 
 
 
 
 
 
SELECT id_cozinha AS id, nome AS nome_pedido, quantia AS quantia_pedido, `status` AS status_pedido FROM pratos_cozinha WHERE `status` = 'Pronto'

SELECT cozinha.id_cozinha,
	   cozinha.`status`,
	   produto.nome,
	   produto.imagem AS path_img_produto,
	   pedido.id_pedido,
	   produto_quantia_pedido.quantia
  FROM produto
 INNER JOIN cozinha ON produto.id_produto = cozinha.cozinha_id_produto
 INNER JOIN pedido ON pedido.id_pedido = cozinha.cozinha_id_pedido
 INNER JOIN (
		SELECT itens_vendidos.pedido_id_pedido,

	   		   SUM(itens_vendidos.quantia) AS quantia
  		  FROM itens_vendidos
 		 INNER JOIN produto ON itens_vendidos.produto_id_produto = produto.id_produto
 	     INNER JOIN cozinha ON produto.id_produto = cozinha.cozinha_id_produto
 		 WHERE produto.tipo = 'Preparo' AND itens_vendidos.pedido_id_pedido = itens_vendidos.pedido_id_pedido
 		 GROUP BY itens_vendidos.pedido_id_pedido) 
    AS produto_quantia_pedido ON produto.id_produto = produto_quantia_pedido.produto_id_produto 


SELECT cozinha.id_cozinha,
	   cozinha.`status`,
	   produto.nome,
	   produto.imagem AS path_img_produto,
	   SUM(pedido_quantia.pedido_id),
	   pedido_quantia.quantia
  FROM produto
 INNER JOIN itens_vendidos ON produto.id_produto = itens_vendidos.produto_id_produto
 INNER JOIN cozinha ON cozinha.cozinha_id_produto = produto.id_produto
 INNER JOIN (SELECT itens_vendidos.pedido_id_pedido AS pedido_id,
	   			    SUM(itens_vendidos.quantia) AS quantia
  			   FROM itens_vendidos
  			  INNER JOIN cozinha ON cozinha.cozinha_id_pedido = itens_vendidos.pedido_id_pedido 
                AND cozinha.cozinha_id_produto = itens_vendidos.produto_id_produto
  			  INNER JOIN produto ON itens_vendidos.produto_id_produto = produto.id_produto
  			  GROUP BY itens_vendidos.pedido_id_pedido) 
    AS pedido_quantia ON  itens_vendidos.pedido_id_pedido = pedido_quantia.pedido_id
 WHERE produto.tipo = 'Preparo'
 GROUP BY cozinha.id_cozinha,
	   cozinha.`status`,
	   produto.nome,
	   produto.imagem,
	   pedido_quantia.pedido_id

SELECT itens_vendidos.pedido_id_pedido AS pedido_id,
	   SUM(itens_vendidos.quantia) AS quantia
  FROM itens_vendidos
  INNER JOIN cozinha ON cozinha.cozinha_id_pedido = itens_vendidos.pedido_id_pedido 
    AND cozinha.cozinha_id_produto = itens_vendidos.produto_id_produto
  INNER JOIN produto ON itens_vendidos.produto_id_produto = produto.id_produto
  GROUP BY itens_vendidos.pedido_id_pedido


SELECT cozinha.id_cozinha,
	   cozinha.`status`,
	   produto.nome,
	   produto.imagem AS path_img_produto,
	   cozinha.cozinha_id_pedido,
	   cozinha.quantia
  FROM cozinha
  INNER JOIN produto ON produto.id_produto = cozinha.cozinha_id_produto

DELETE FROM cozinha
 
 SELECT itens_vendidos.pedido_id_pedido,
		   itens_vendidos.produto_id_produto,
		   itens_vendidos.quantia
	  FROM itens_vendidos
	 INNER JOIN produto ON produto.id_produto = itens_vendidos.produto_id_produto
	 WHERE itens_vendidos.pedido_id_pedido = 39 AND produto.tipo = 'Preparo'
 
 
 
 
 
 SELECT id_cozinha AS id,
 		nome AS nome_pedido,
		quantia AS quantia_pedido,
		`status` AS status_pedido 
   FROM pratos_cozinha
   ORDER BY `status` DESC, id_cozinha ASC
 
 
 SELECT produto.id_produto AS id,
 		produto.nome,
		produto.quantia AS quantidade, 
		produto.quantia_minima AS quantidade_minima
   FROM produto
  WHERE produto.quantia <= produto.quantia_minima 
    AND produto.tipo != 'Preparo'
 
 
 
SELECT SUM(pedido.valor)
  FROM pedido
 WHERE DATE(pedido.`data`) BETWEEN '20190101' AND '20190201' 
 
SELECT SUM(pedido.valor)
  FROM pedido
 WHERE DATE(pedido.`data`) BETWEEN '20190202' AND '20190301'
 
 SELECT SUM(pedido.valor)
  FROM pedido
 WHERE DATE(pedido.`data`) BETWEEN '20190302' AND '20190401'
 
 SELECT SUM(pedido.valor)
  FROM pedido
 WHERE DATE(pedido.`data`) BETWEEN '20190402' AND '20190501'
 
 SELECT IFNULL(SUM(pedido.valor), 0)
  FROM pedido
 WHERE DATE(pedido.`data`) BETWEEN '20190502' AND '20190601'
 
 SELECT IFNULL(SUM(pedido.valor), 0)
  FROM pedido
 WHERE DATE(pedido.`data`) BETWEEN '20190602' AND '20190701'
 `data`
 
 SELECT SUM(pedido.valor)
  FROM pedido
 WHERE DATE(pedido.`data`) BETWEEN '20190502' AND '20190601'
 
