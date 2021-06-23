#!/bin/bash

echo "Informe o nome do banco de dados"
read dbname

echo "Informe o usuário do banco de dados"
read dbuser

echo "Informe a senha do banco de dados"
read dbpass

mkdir dump

echo "Iniciando exportação das tabelas..."

mysqldump -u $dbuser --password=$dbpass $dbname catalog_category_entity > dump/catalog_category_entity.sql
mysqldump -u $dbuser --password=$dbpass $dbname catalog_category_entity_datetime > dump/catalog_category_entity_datetime.sql
mysqldump -u $dbuser --password=$dbpass $dbname catalog_category_entity_int > dump/catalog_category_entity_int.sql
mysqldump -u $dbuser --password=$dbpass $dbname catalog_category_entity_text > dump/catalog_category_entity_text.sql
mysqldump -u $dbuser --password=$dbpass $dbname catalog_category_entity_varchar > dump/catalog_category_entity_varchar.sql
mysqldump -u $dbuser --password=$dbpass $dbname catalog_category_product > dump/catalog_category_product.sql
mysqldump -u $dbuser --password=$dbpass $dbname catalog_category_product_cl > dump/catalog_category_product_cl.sql
mysqldump -u $dbuser --password=$dbpass $dbname catalog_url_rewrite_product_category > dump/catalog_url_rewrite_product_category.sql
mysqldump -u $dbuser --password=$dbpass $dbname url_rewrite > dump/url_rewrite.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_attribute_cl > dump/catalog_product_attribute_cl.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_bundle_option > dump/catalog_product_bundle_option.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_bundle_option_value > dump/catalog_product_bundle_option_value.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_bundle_price_index > dump/catalog_product_bundle_price_index.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_bundle_selection > dump/catalog_product_bundle_selection.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_bundle_selection_price > dump/catalog_product_bundle_selection_price.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_bundle_stock_index > dump/catalog_product_bundle_stock_index.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_category_cl > dump/catalog_product_category_cl.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity > dump/catalog_product_entity.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_datetime > dump/catalog_product_entity_datetime.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_decimal > dump/catalog_product_entity_decimal.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_gallery > dump/catalog_product_entity_gallery.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_int > dump/catalog_product_entity_int.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_media_gallery > dump/catalog_product_entity_media_gallery.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_media_gallery_value > dump/catalog_product_entity_media_gallery_value.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_media_gallery_value_to_entity > dump/catalog_product_entity_media_gallery_value_to_entity.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_media_gallery_value_video > dump/catalog_product_entity_media_gallery_value_video.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_text > dump/catalog_product_entity_text.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_tier_price > dump/catalog_product_entity_tier_price.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_entity_varchar > dump/catalog_product_entity_varchar.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_frontend_action > dump/catalog_product_frontend_action.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav > dump/catalog_product_index_eav.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal > dump/catalog_product_index_eav_decimal.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal_idx > dump/catalog_product_index_eav_decimal_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal_replica > dump/catalog_product_index_eav_decimal_replica.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal_tmp > dump/catalog_product_index_eav_decimal_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_idx > dump/catalog_product_index_eav_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_replica > dump/catalog_product_index_eav_replica.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_tmp > dump/catalog_product_index_eav_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price > dump/catalog_product_index_price.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_bundle_idx > dump/catalog_product_index_price_bundle_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_bundle_opt_idx > dump/catalog_product_index_price_bundle_opt_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_bundle_opt_tmp > dump/catalog_product_index_price_bundle_opt_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_bundle_sel_idx > dump/catalog_product_index_price_bundle_sel_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_bundle_sel_tmp > dump/catalog_product_index_price_bundle_sel_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_bundle_tmp > dump/catalog_product_index_price_bundle_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_cfg_opt_agr_idx > dump/catalog_product_index_price_cfg_opt_agr_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_cfg_opt_agr_tmp > dump/catalog_product_index_price_cfg_opt_agr_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_cfg_opt_idx > dump/catalog_product_index_price_cfg_opt_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_cfg_opt_tmp > dump/catalog_product_index_price_cfg_opt_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_downlod_idx > dump/catalog_product_index_price_downlod_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_downlod_tmp > dump/catalog_product_index_price_downlod_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_final_idx > dump/catalog_product_index_price_final_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_final_tmp > dump/catalog_product_index_price_final_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_idx > dump/catalog_product_index_price_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_opt_agr_idx > dump/catalog_product_index_price_opt_agr_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_opt_agr_tmp > dump/catalog_product_index_price_opt_agr_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_opt_idx > dump/catalog_product_index_price_opt_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_opt_tmp > dump/catalog_product_index_price_opt_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_replica > dump/catalog_product_index_price_replica.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_price_tmp > dump/catalog_product_index_price_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_tier_price > dump/catalog_product_index_tier_price.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_website > dump/catalog_product_index_website.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_link > dump/catalog_product_link.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_link_attribute > dump/catalog_product_link_attribute.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_link_attribute_decimal > dump/catalog_product_link_attribute_decimal.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_link_attribute_int > dump/catalog_product_link_attribute_int.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_link_attribute_varchar > dump/catalog_product_link_attribute_varchar.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_link_type > dump/catalog_product_link_type.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_option > dump/catalog_product_option.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_option_price > dump/catalog_product_option_price.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_option_title > dump/catalog_product_option_title.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_option_type_price > dump/catalog_product_option_type_price.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_option_type_title > dump/catalog_product_option_type_title.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_option_type_value > dump/catalog_product_option_type_value.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_price_cl > dump/catalog_product_price_cl.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_relation > dump/catalog_product_relation.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_super_attribute > dump/catalog_product_super_attribute.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_super_attribute_label > dump/catalog_product_super_attribute_label.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_super_link > dump/catalog_product_super_link.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_website > dump/catalog_product_website.sql
mysqldump -u $dbuser --password=$dbpass $dbname	cataloginventory_stock > dump/cataloginventory_stock.sql
mysqldump -u $dbuser --password=$dbpass $dbname	cataloginventory_stock_cl > dump/cataloginventory_stock_cl.sql
mysqldump -u $dbuser --password=$dbpass $dbname	cataloginventory_stock_item > dump/cataloginventory_stock_item.sql
mysqldump -u $dbuser --password=$dbpass $dbname	cataloginventory_stock_status > dump/cataloginventory_stock_status.sql
mysqldump -u $dbuser --password=$dbpass $dbname	cataloginventory_stock_status_idx > dump/cataloginventory_stock_status_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	cataloginventory_stock_status_replica > dump/cataloginventory_stock_status_replica.sql
mysqldump -u $dbuser --password=$dbpass $dbname	cataloginventory_stock_status_tmp > dump/cataloginventory_stock_status_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_eav_attribute > dump/catalog_eav_attribute.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav > dump/catalog_product_index_eav.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal > dump/catalog_product_index_eav_decimal.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal_idx > dump/catalog_product_index_eav_decimal_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal_replica > dump/catalog_product_index_eav_decimal_replica.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_decimal_tmp > dump/catalog_product_index_eav_decimal_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_idx > dump/catalog_product_index_eav_idx.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_replica > dump/catalog_product_index_eav_replica.sql
mysqldump -u $dbuser --password=$dbpass $dbname	catalog_product_index_eav_tmp > dump/catalog_product_index_eav_tmp.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_attribute > dump/eav_attribute.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_attribute_group > dump/eav_attribute_group.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_attribute_label > dump/eav_attribute_label.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_attribute_option > dump/eav_attribute_option.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_attribute_option_swatch > dump/eav_attribute_option_swatch.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_attribute_option_value > dump/eav_attribute_option_value.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_attribute_set > dump/eav_attribute_set.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity > dump/eav_entity.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_attribute > dump/eav_entity_attribute.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_datetime > dump/eav_entity_datetime.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_decimal > dump/eav_entity_decimal.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_int > dump/eav_entity_int.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_store > dump/eav_entity_store.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_text > dump/eav_entity_text.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_type > dump/eav_entity_type.sql
mysqldump -u $dbuser --password=$dbpass $dbname	eav_entity_varchar > dump/eav_entity_varchar.sql

echo "Exportação finalizada"