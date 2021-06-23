#!/bin/bash

echo "Informe o nome do banco de dados"
read dbname

echo "Informe o usuário do banco de dados"
read dbuser

echo "Informe a senha do banco de dados"
read dbpass

mysqldump -u $dbuser --password=$dbpass $dbname > dump_general.sql
chmod -R 777 dump_general.sql
echo "Backup do banco de dados finalizado"

echo "Iniciando importação das tabelas..."

mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_category_entity.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_category_entity_datetime.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_category_entity_int.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_category_entity_text.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_category_entity_varchar.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_category_product.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_category_product_cl.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_url_rewrite_product_category.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/url_rewrite.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_attribute_cl.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_bundle_option.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_bundle_option_value.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_bundle_price_index.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_bundle_selection.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_bundle_selection_price.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_bundle_stock_index.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_category_cl.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity_datetime.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity_decimal.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity_gallery.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity_int.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity_media_gallery.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity_media_gallery_value.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_entity_media_gallery_value_to_entity.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_entity_media_gallery_value_video.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_entity_text.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_entity_tier_price.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_entity_varchar.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_frontend_action.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_index_eav_decimal.sql
mysql -u $dbuser --password=$dbpass $dbname	< dump/catalog_product_index_eav_decimal_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_decimal_replica.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_decimal_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_replica.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_bundle_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_bundle_opt_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_bundle_opt_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_bundle_sel_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_bundle_sel_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_bundle_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_cfg_opt_agr_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_cfg_opt_agr_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_cfg_opt_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_cfg_opt_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_downlod_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_downlod_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_final_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_final_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_opt_agr_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_opt_agr_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_opt_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_opt_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_replica.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_price_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_tier_price.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_website.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_link.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_link_attribute.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_link_attribute_decimal.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_link_attribute_int.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_link_attribute_varchar.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_link_type.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_option.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_option_price.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_option_title.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_option_type_price.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_option_type_title.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_option_type_value.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_price_cl.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_relation.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_super_attribute.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_super_attribute_label.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_super_link.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_website.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/cataloginventory_stock.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/cataloginventory_stock_cl.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/cataloginventory_stock_item.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/cataloginventory_stock_status.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/cataloginventory_stock_status_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/cataloginventory_stock_status_replica.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/cataloginventory_stock_status_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_eav_attribute.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_decimal.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_decimal_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_decimal_replica.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_decimal_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_idx.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_replica.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/catalog_product_index_eav_tmp.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_attribute.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_attribute_group.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_attribute_label.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_attribute_option.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_attribute_option_swatch.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_attribute_option_value.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_attribute_set.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_attribute.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_datetime.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_decimal.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_int.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_store.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_text.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_type.sql
mysql -u $dbuser --password=$dbpass $dbname < dump/eav_entity_varchar.sql

echo "Importação finalizada"

service elasticsearch restart

(cd .. && bin/magento setup:upgrade)
(cd .. && bin/magento indexer:reindex)
(cd .. && bin/magento setup:di:compile)