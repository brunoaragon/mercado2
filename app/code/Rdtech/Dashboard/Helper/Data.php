<?php

namespace Rdtech\Dashboard\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ResourceConnection;

class Data extends AbstractHelper
{
    protected $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function maisVendidos()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
            SELECT ite.name, ite.product_id, sum(ite.qty_ordered) as qtd
            FROM sales_order_item ite 
            INNER JOIN catalog_product_entity pro on pro.entity_id = ite.product_id
            INNER JOIN sales_order ord on ord.entity_id = ite.order_id
            WHERE ord.created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day)) AND NOW()
            GROUP BY ite.name, ite.product_id
            ORDER BY sum(ite.qty_ordered) DESC
            LIMIT 10;
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function metodoEntrega()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
            SELECT count(entity_id) as qtd, shipping_description description
            FROM sales_order
            WHERE created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day)) AND NOW()
            GROUP BY shipping_description
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function metodoPagamento()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
            SELECT count(ord.entity_id) as qtd, pay.additional_information as description FROM sales_order ord 
            INNER JOIN sales_order_payment pay ON pay.parent_id = ord.entity_id
            WHERE ord.created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day)) AND NOW()
            GROUP BY pay.additional_information;
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function diaSemana()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
            SELECT count(ord.entity_id) as qtd,WEEKDAY(ord.created_at) as description FROM sales_order ord 
            WHERE ord.created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day)) AND NOW()
            GROUP BY WEEKDAY(ord.created_at)
            ORDER BY count(ord.entity_id) DESC;
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function pedidoRecente()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
        SELECT CONCAT(customer_firstname, ' ', SUBSTRING(customer_lastname, 1, 1),'.') as name, grand_total as total, created_at as date FROM sales_order ord 
        ORDER BY entity_id DESC LIMIT 10
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function clienteRecente()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
        SELECT CONCAT(ent.firstname, ' ', SUBSTRING(ent.lastname, 1, 1),'.') as name, ent.created_at as date, (select count(entity_id) as total from sales_order where customer_id = ent.entity_id) as qtd FROM customer_entity ent
        ORDER BY ent.entity_id DESC LIMIT 10
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function semEstoque()
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
            SELECT qtd.product_id, qtd.qty, ite.name as name, ite.sku 
            FROM sales_order ord 
            INNER JOIN sales_order_item ite on ite.order_id = ord.entity_id
            INNER JOIN cataloginventory_stock_item qtd ON qtd.product_id  = ite.product_id
            WHERE ord.created_at BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day)) AND NOW()
            AND qtd.qty = 0
            GROUP BY qtd.product_id, qtd.qty, ite.name;
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }

    public function produtoRelacionado($_product_id)
    {
        $connection = $this->resourceConnection->getConnection();

        $query = "
            select cpe1.entity_id as product_id, (select count(qty_ordered) from sales_order_item where product_id = cpe1.entity_id) as qtd from catalog_product_entity cpe1
            inner join catalog_category_product ccp1 on cpe1.entity_id  = ccp1.product_id 
            inner join catalog_category_entity cce1 on cce1.entity_id = ccp1.category_id 
            where cce1.entity_id in (select cce2.entity_id from catalog_product_entity cpe2
                inner join catalog_category_product ccp2 on cpe2.entity_id  = ccp2.product_id 
                inner join catalog_category_entity cce2 on cce2.entity_id = ccp2.category_id 
                where cpe2.entity_id = ".$_product_id."
                and cce2.level = 3)
            and cce1.entity_id != ".$_product_id."
            order by (select count(qty_ordered) from sales_order_item where product_id = cpe1.entity_id) desc
            limit 6
            ";
        $result = $connection->fetchAll($query);

        return $result;
    }
}
