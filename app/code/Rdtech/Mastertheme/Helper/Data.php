<?php

namespace Rdtech\Mastertheme\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getTheme($attr)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Rdtech\Mastertheme\Model\Themecustom');

        $collection = $model->getCollection()
            ->addFieldToSelect('element')
            ->addFieldToSelect('value')
            ->addFieldToFilter('element', $attr)
            ->getFirstItem();

        if ($collection->getValue()) {
            return $collection->getValue();
        } else {
            return null;
        }
    }

    function hex2rgba($color, $opacity = false)
    {
        $default = 'rgb(0,0,0)';

        if (empty($color)) {
            return $default;
        }

        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        $rgb =  array_map('hexdec', $hex);

        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        return $output;
    }

    public function createCSS($path_dir)
    {
        $header = "        
        body,
        .abs-product-link > a, 
        .product-item-name > a, 
        .product.name a > a,
        .abs-product-link > a:visited, 
        .product-item-name > a:visited, 
        .product.name a > a:visited,        
        .opc-wrapper .step-title, 
        .opc-block-shipping-information .shipping-information-title, 
        .opc-block-summary > .title, 
        .checkout-agreements-items .checkout-agreements-item-title,
        .opc-progress-bar-item > span,
        .page-title-main > strong,
        .product-info-main .product.attribute.overview .value,
        .block-collapsible-nav .item.current > strong,
        .block-collapsible-nav .item a, 
        .block-collapsible-nav .item > strong {
            color: " . $this->getTheme('content_body_textcolor') . " !important;  
        }

        body .carousel-indicators li{
            border: 1px solid " . $this->getTheme('button_background') . " !important;
        }
        body .carousel-indicators .active{
            background: " . $this->getTheme('button_background') . " !important;
            border: none !important;
        }

        body #mnn-header{
            border-bottom: 1px solid " . $this->getTheme('header_border') . " !important;  
        }

        .opc-progress-bar-item > span:after {
            background: " . $this->getTheme('content_body_background') . " !important;  
            color: " . $this->getTheme('content_body_textcolor') . " !important; 
        }

        .cart.table-wrapper .col.subtotal .price-excluding-tax .price,
        .cart.table-wrapper .col.price .price-excluding-tax .price{
            color: " . $this->getTheme('content_body_textcolor') . " !important;  
            opacity: 0.85 !important;
        }

        .opc-block-summary,
        .cart-summary{
            background: " . $this->getTheme('content_body_background') . " !important;  
            filter: brightness(0.93);
        }
    
        .products-grid .product-item .product-item-info .product-img-main,
        .m2n-links-addtocart a {
            background: #fff !important;  
        }

        #wishlist-view-form .products-grid .product-item .product-item-info {
            background: #fff !important;
        }
        #wishlist-view-form .product-item-link{
            color: #555 !important;
        }

        .sidebar-additional .product-item {
            border: none !important;
        }

        .account .table-wrapper,
        .table > tbody > tr > th, 
        .table > tbody > tr > td,
        .abs-account-blocks .block-title, 
        .account .legend, 
        .form-giftregistry-search .legend, 
        .block-giftregistry-results .block-title, 
        .block-giftregistry-shared-items .block-title, 
        .block-wishlist-search-form .block-title, 
        .block-wishlist-search-results .block-title, 
        .multicheckout .block-title, 
        .multicheckout .block-content .title, 
        .customer-review .review-details .title, 
        .paypal-review .block .block-title, 
        .account .column.main .block:not(.widget) .block-title, 
        .multicheckout .block-title, 
        .magento-rma-guest-returns .column.main .block:not(.widget) .block-title, 
        [class^='sales-guest-'] .column.main .block:not(.widget) .block-title, 
        .sales-guest-view .column.main .block:not(.widget) .block-title,
        .block-collapsible-nav .item .delimiter,
        .product-info-main .product.attribute.overview,
        .product-info-main .product-info-price,
        .page-title-main > strong,
        .table-checkout-shipping-method tbody td,        
        .opc-wrapper .step-title{
            border-color: " . $this->getTheme('menu_submenu_background') . " !important;  
        }
    
        .page-products .products-grid .product-item-inner:before,
        .product-items .product-item,
        body .page-wrapper, 
        .products-grid.products, 
        .sidebar.sidebar-main .block .block-content.filter-content .filter-subtitle, 
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options {
            background: " . $this->getTheme('content_body_background') . " !important;  
        }

        .page-header {
            border-bottom: 1px solid " . $this->getTheme('header_border') . " !important;
            z-index: 999999;
        }
        #maincontent{
            z-index: 99999;
        }
        #store_menu {
            width: calc(100% + 34px);
            border: 1px solid " . $this->getTheme('submenu_border') . " !important;  
            border-top: 1px solid " . $this->getTheme('submenu_top_border') . " !important;              
            height: 38px;
            margin-left: -34px;
            display: flex;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            margin-top: -1px !important;
        }

        .block-collapsible-nav .item a:hover,
        .block-collapsible-nav .content,
        .product.data.items > .item.title > .switch,
        .product.data.items > .item.title.active > .switch,
        .product.data.items > .item.content{
            background: " . $this->getTheme('menu_submenu_background') . " !important;  
            border-color: " . $this->getTheme('menu_submenu_background') . " !important;  
        }

        .product.data.items > .item.title > .switch{
            filter: brightness(1.1);
        }

        .product.data.items > .item.title > .switch:visited,
        .product.data.items > .item.title.active > .switch{
            color: " . $this->getTheme('menu_submenu_text') . " !important;  
        }




        .product-item .action.towishlist{
            color: " . $this->getTheme('button_background') . " !important;
        }
        #my-orders-table{
            margin-top: 20px;
        }
        #info_header{
            background: " . $this->getTheme('top_header_background') . " !important;
            color: " . $this->getTheme('top_header_text') . " !important;
        }
        .m2n-social a{
            background: " . $this->getTheme('top_header_background') . " !important;
            color: " . $this->getTheme('top_header_text') . " !important;
        }
        #mini-cart .product-item-photo{
            display: none !important;
        }
        .minicart-items .product-item-details{
            padding-left: 0 !important;
        }
        .minicart-items .product-item-pricing{
            margin-top: -10px;
        }
        .minicart-items .product-item-details .details-qty {
            margin-top: 0px;
        }
        .minicart-items .item-qty {
            height: 33px;
        }
        .minicart-items .product-item {
            padding-bottom: 5px !important;
        }
       
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options .filter-options-item,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-subtitle{
            background: #ffffff !important;
        }
        .page-wrapper,
        .products-grid.products {
            /*background: #ffffff;*/
        }  
        .sidebar.sidebar-main .block .block-content.filter-content .filter-subtitle {
            background: #ffffff;
        }
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options {
            background: #ffffff;
        } 
        .page-wrapper,
        .products-grid.products, 
        .sidebar.sidebar-main .block .block-content.filter-content .filter-subtitle,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options {
            /*background: #ffffff;*/
        }
        .page-title-wrapper .page-title{
            color: " . $this->getTheme('content_text_color') . " !important;
        }
        .page-wrapper .page-header .panel.wrapper {
            border: none !important;
        }
        .page-header{
            background: " . $this->getTheme('header_background') . " !important;
        }
        .page-wrapper .page-header .panel.wrapper {
            border-bottom: none;
            background-color: " . $this->getTheme('header_background') . " !important;
            height: 0;
            z-index: 15;
            position: relative;
        }          
        
        .page-header {
            background: " . $this->getTheme('header_background') . " !important;
        }
        .checkout-icon{
            background: " . $this->getTheme('header_background') . " !important;
        }
        .checkout-icon i{
            color: " . $this->getTheme('header_text') . " !important;
        }
        .checkout-icon:hover{
            background: " . $this->getTheme('header_text') . " !important;
        }
        .checkout-icon:hover i{
            color: " . $this->getTheme('header_background') . " !important;
        }
      
        .details-qty label{
            color: #777 !important;
        }

        
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li.customer-welcome .action.switch:after,
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li > span,
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li > a {
            color: " . $this->getTheme('header_text') . " !important;
        }
        .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty .counter-number,
        .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart:before {
            color: " . $this->getTheme('header_cart_text') . " !important;
        }
        .page-wrapper .page-header .header.content .minicart-wrapper {
            background: " . $this->getTheme('header_cart_background') . " !important;
            z-index: 15;
        }      
        
        @media only screen and (max-width: 1360px) {  
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
                border: 1px solid " . $this->getTheme('header_cart_background') . " !important;
            }
        }

        .page-wrapper .page-header .header.content .block-search .field.search .control .input-text {
            border: none !important;
            background: " . $this->getTheme('header_search_background') . " !important;
            color: " . $this->getTheme('header_search_text') . " !important;
        }
        @media only screen and (min-width: 768px){
            .block-search .control {
                border: 1px solid " . $this->getTheme('header_search_border') . " !important;
                border-radius: 100px;
            }
        }
        .page-wrapper .page-header .header.content .block-search .field.search .control .input-text::placeholder {
            color: " . $this->getTheme('header_search_text') . " !important;
        }
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li .customer-menu .header.links {
            border: 1px solid " . $this->getTheme('header_account_background') . " !important;
            background: " . $this->getTheme('header_account_background') . " !important;
        }
        .page-wrapper .page-header .panel.wrapper .panel.header .header.links > li .customer-menu .header.links > li > a {
            color: " . $this->getTheme('header_account_text') . " !important;
        }
        .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
            padding: 0 17px 0 14px !important;
        }
        .creditlimit{
            width: 220px;
            background: " . $this->getTheme('header_cart_background') . " !important;
            display: table !important;
            padding: 2px 0;
            text-align: center;
        }
        .creditlimit + .authorization-link{
            display: none !important;    
        }
        .page-wrapper .page-header .header.content .block-search {
            margin-top: 12px;
        }
        .page-wrapper .page-header .header.content .minicart-wrapper {
            margin-top: 12px;
        }
        
        " . $this->getTheme('header_css');

        $menu = "
        [aria-controls='store.settings']{
            display:none !important;            
        }
        @media only screen and (max-width: 767px){
            .page-wrapper .nav-sections .navigation > ul li.level0 {
                padding-top: 0;
                padding-bottom: 0;
                border-color: transparent;
            }
        }
        .nav-sections {
            background: " . $this->getTheme('menu_submenu_background') . " !important;
        }        
        .navigation .level0.active > .level-top, 
        .navigation .level0.has-active > .level-top{
            background: " . $this->getTheme('menu_submenu_background') . " !important;
        }
        .nav-sections .navigation > ul > li.level0 > a.level-top.ui-state-active,
        .nav-sections .navigation > ul > li.level0 > a.level-top.ui-state-focus{
            background: " . $this->getTheme('menu_item_background_hover') . " !important;
        }
        .navigation .level0 .submenu a:hover,
        .navigation .level0 .submenu a.ui-state-focus,
        .navigation .level0 .submenu .active > a {
            color: " . $this->getTheme('menu_submenu_text') . " !important;
        }
        .nav-sections .navigation > ul > li.level0 .submenu {
            background: " . $this->getTheme('menu_submenu_background') . " !important;
            border: none;
            -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.3);
        }
        .navigation .level0 .submenu a {
            color: " . $this->getTheme('menu_submenu_text') . " !important;
        }
        .navigation .level0 .submenu a:hover {
            color: " . $this->getTheme('menu_submenu_text_hover') . " !important;
        }
        .nav-sections .navigation > ul > li.level0 .submenu {
            padding: 0 !important; 
        }

        #category_menu .category_title{
            color: " . $this->getTheme('menu_item_text') . " !important;
            background: transparent !important;
            margin-top: 1px;
            height: 38px !important;
            font-weight: 500;
        }
        
        .sidebar .product-items-names .product-item,
        .sidebar.sidebar-additional .block.block-compare, 
        .sidebar.sidebar-additional .block.block-wishlist, 
        .sidebar.sidebar-additional .block.block-reorder,
        #category_menu .category_title,
        #category_menu,
        #category_menu_more{
            background: " . $this->getTheme('menu_submenu_background') . " !important;
        }

        #store_menu{
            background: " . $this->getTheme('submenu_background') . " !important;
        }

        .sidebar.sidebar-additional .block.block-compare .block-title > strong, 
        .sidebar.sidebar-additional .block.block-wishlist .block-title > strong, 
        .sidebar.sidebar-additional .block.block-reorder .block-title > strong{
            color: " . $this->getTheme('menu_submenu_text') . " !important;
        }        

        #store_menu .menu_item,
        #store_menu .menu_item i,
        .menu_item_home,
        .menu_item_home i{
            color: " . $this->getTheme('submenu_text') . " !important;
        }

        #category_menu {
            border: 1px solid " . $this->getTheme('menu_submenu_border') . " !important;
        }
        #category_menu_more {
            border-top: 1px solid " . $this->getTheme('menu_submenu_border') . " !important;
        }
        .sidebar.sidebar-additional .block.block-compare .block-title, 
        .sidebar.sidebar-additional .block.block-wishlist .block-title, 
        .sidebar.sidebar-additional .block.block-reorder .block-title{
            border-color: 1px solid " . $this->getTheme('menu_submenu_border') . " !important;
        }

        #category_menu_more span,
        .menu_item,
        .menu_item a,
        .menu_item i,
        .m2n-category-parent a,
        .m2n-category-selected a,
        .m2n-category-parent i{
            color: " . $this->getTheme('menu_submenu_text') . " !important;
        }
       
        .menu_item:hover,
        .menu_item:hover a,
        .menu_item:hover i,
        .m2n-category-parent:hover span,
        .m2n-category-parent:hover span a,
        .m2n-category-parent:hover span i,
        .m2n-category-parent a:hover,
        .m2n-category-parent a:hover i{
            color: " . $this->getTheme('menu_submenu_text_hover') . " !important;
            cursor: pointer;
        }
        ";

        $button = "
        .sidebar-additional .action.primary,
        .action.primary {
            background: " . $this->getTheme('button_background') . " !important;
            border: 1px solid " . $this->getTheme('button_background') . " !important;
            color: " . $this->getTheme('button_text') . " !important;
        }
        #minicart-content-wrapper .viewcart{
            background: " . $this->getTheme('button_background') . " !important;
        }
        .sidebar-additional .action.primary:hover,
        .action.primary:hover {
            background: " . $this->getTheme('button_background_hover') . " !important;
            border: 1px solid " . $this->getTheme('button_background_hover') . " !important;
            color: " . $this->getTheme('button_text_hover') . " !important;
        }

        .sidebar-additional .action.primary span{
            color: " . $this->getTheme('button_text') . " !important;
        }
        .sidebar-additional .action.primary:hover span{
            color: " . $this->getTheme('button_text_hover') . " !important;
        }

        .m2n-links-addtocart a:last-child {
            background: " . $this->getTheme('button_background') . " !important;
            border: 1px solid " . $this->getTheme('button_background') . " !important;
            color: " . $this->getTheme('button_text') . " !important;
        }
        .m2n-links-addtocart a:last-child:hover {
            background: " . $this->getTheme('button_background_hover') . " !important;
            border: 1px solid " . $this->getTheme('button_background_hover') . " !important;
            color: " . $this->getTheme('button_text_hover') . " !important;
        }
        .cart-check{
            background: " . $this->getTheme('button_background') . " !important;
        }
        .m2n-added-cart i{
            color: " . $this->getTheme('button_background') . " !important;
        }
        .cart-check i,
        .cart-check span{
            color: " . $this->getTheme('button_text') . " !important;
        }
        ";


        $content = "   
        .products-grid .product-item .product-item-info .product-item-details .product-item-name .product-item-link { 
            color: " . $this->getTheme('content_card_name') . " !important;         
        }

        .products .product-item .product-item-sku {
            color: " . $this->getTheme('content_text_color') . " !important;    
            opacity: 0.7;
        }
        .products-grid .product-item .product-item-info .product-item-details .price-box .old-price .price{
            color: " . $this->getTheme('content_text_color') . " !important;    
            opacity: 0.8;
        }

        .products-grid .product-item .product-item-info .product-item-details .price-box .price,
        .rating-summary .rating-result > span:before {
            color: " . $this->getTheme('content_card_details') . " !important;    
        }

        .products-grid .product-item .product-item-info .product-img-main {
            border: 1px solid #e8e8e8;
            border-radius: 4px;
            transition: 0.3s;
        }
        
        .tag-discount{
            position: absolute;
            background: " . $this->getTheme('button_background_hover') . " !important;
            color: " . $this->getTheme('button_text_hover') . " !important;
            padding: 17px 9px 13px 16px;
            z-index: 99;
            top: -10px;
            left: -10px;
            border-radius: 100px;
            font-weight: 500;
        }
                
        .product-info-main .product-social-links a.action,
        .sidebar-additional .product-item-name > a,
        .sidebar-additional .product.name a > a,
        .sidebar-additional .abs-product-link > a:visited,
        .sidebar-additional .product-item-name > a:visited,
        .sidebar-additional .product.name a > a:visited,
        .sidebar-main .product-item-name > a,
        .sidebar-main .product.name a > a,
        .sidebar-main .abs-product-link > a:visited,
        .sidebar-main .product-item-name > a:visited,
        .sidebar-main .product.name a > a:visited,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options .filter-options-content .items .item > a,
        .sidebar-main .action span,
        .sidebar-additional .action span, 
        .breadcrumbs a:visited,
        .breadcrumbs a:hover,
        .breadcrumbs a:active,
        .breadcrumbs a {
            color: " . $this->getTheme('content_link_color') . " !important;
        }        

        #minicart-content-wrapper .actions .viewcart span:hover,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options .filter-options-content .items .item > a:hover,
        .sidebar-main .action span:hover,
        .sidebar-additional .action span:hover,        
        .minicart-items .product-item-name a:hover,
        .sidebar-additional .product-item-name > a:hover,
        .sidebar-additional .product.name a > a:hover,
        .sidebar-main .product-item-name > a:hover,
        .sidebar-main .product.name a > a:hover,
        .product-info-main .product-social-links a.action:hover {
            color: " . $this->getTheme('content_link_color_hover') . " !important;        
        }

        .discount-label,        
        .pages .action.next:hover,
        .catalog-category-view .toolbar.toolbar-products .modes .modes-mode.active {
            border-color: " . $this->getTheme('content_icon_color') . " !important;
            background: " . $this->getTheme('content_icon_color') . " !important;
            /*color: " . $this->getTheme('content_link_text') . " !important;*/
        }

        .qtyplus-input input{
            /*color: " . $this->getTheme('content_link_text') . " !important;*/
        }

        .nav-sections{
            z-index: 9999;
        }

        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.towishlist, 
        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.tocompare{
            background: " . $this->getTheme('button_background') . " !important;
            color: " . $this->getTheme('button_text') . " !important;
        }
        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.towishlist:hover, 
        .products-grid .product-item .product-item-info .product-img-main .product-item-inner .product-item-actions .actions-secondary a.action.tocompare:hover{
            background: " . $this->getTheme('content_icon_color') . " !important;
            color: " . $this->getTheme('content_icon_text') . " !important;
        }
        
        .m2n-qtyplus-input-value input {
            background: " . $this->hex2rgba($this->getTheme('content_icon_color'), 0.95) . " !important;
            color: " . $this->getTheme('content_icon_text') . " !important;
        }
        .m2n-qtyplus-input-value:hover input {
            background: " . $this->hex2rgba($this->getTheme('content_icon_color'), 1) . " !important;
        }
        
        .m2n-qtyplus-input-less,
        .m2n-qtyplus-input-plus {
            background: " . $this->hex2rgba($this->getTheme('content_icon_color'), 0.83) . " !important;
            color: " . $this->getTheme('content_icon_text') . " !important;
        }
   
        .m2n-qtyplus-input-less:hover,
        .m2n-qtyplus-input-plus:hover {
            background: " . $this->hex2rgba($this->getTheme('content_icon_color'), 0.9) . " !important;
        }

        .m2n-qtyplus-button{
            background: " . $this->getTheme('button_background') . " !important;
            color: " . $this->getTheme('button_text') . " !important;
        }

        .cart-check-icon{
            color: " . $this->getTheme('content_icon_color') . " !important;
        }       
        .pages strong.page {
            background-color: " . $this->getTheme('button_background') . " !important;
            border-color: " . $this->getTheme('button_background') . " !important;
        }

        .pages strong.page span {
            color: " . $this->getTheme('button_text') . " !important;
        }

        .pages a.page:hover{
            background-color: " . $this->getTheme('button_background') . " !important;
            border-color: " . $this->getTheme('button_background') . " !important;
            color: " . $this->getTheme('button_text') . " !important;
        }

        .toolbar-products .item:hover span,
        .pages strong.page a:hover span{
            color: " . $this->getTheme('button_text') . " !important;
        }

        .product-item {
            border: none !important;
        }       

        .toolbar-products .item span{
            color: #333333 !important;
        }

        .toolbar-products .item:hover span,
        .toolbar-products .current span{
            /*color: " . $this->getTheme('content_link_text') . " !important;*/
        }

        ";

        $fixed = "
        .stock-info{
            font-size: 13px;
            font-style: italic;
        }
        .out{
            color: #dc2323 !important;
        }

        .cart .product-image-container {
            width: 80px !important;
        }
        .cart.table-wrapper .item .col.item {
            padding: 15px 8px 10px 0 !important;
        }

        .product-info-main .product-info-price .product-info-stock-sku .stock.unavailable {
            background: #d61e1e;           
        }
        .out-of-stock{
            background: #333;
            color: #fff;
            width: calc(100% + 20px);
            text-align: center;
            padding: 5px 0px;
            font-size: 13px;
            position: relative;
            z-index: 2;
            top: -4px;
            border-bottom: 4px solid #ce1e1e;
            left: -10px;
        }
        .out-of-stock-alert{
            padding: 2px 6px;
            position: absolute;
            z-index: 2;
            font-size: 17px;
            opacity: 0.3;
            color: #333;
            transition: 0.3s;
        }  

        .arrival-forecast{
            color: #717171;
            margin-top: 32px;
            margin-bottom: 7px;
            padding: 1px 5px;
            font-weight: 500;
            float: right;
            margin-right: -115px;
            line-height: 17px;
        }
        .arrival-forecast span:last-child{
            font-weight: 600;
        }

        .available-quantity{
            color: #717171;
            margin-top: 32px;
            margin-bottom: 7px;
            padding: 1px 5px;
            font-weight: 500;
            float: right;
            margin-right: -104px;
            line-height: 17px;
        }
        .available-quantity span:last-child{
            font-weight: 600;
        }

        .product-info-main .product-info-price .product-info-stock-sku .stock.unavailable {
            background: #d63232 !important;
        }

        .low-stock{
            background: #333;
            color: #fff;
            width: calc(100% + 20px);
            text-align: center;
            padding: 5px 0px;
            font-size: 13px;
            position: relative;
            z-index: 2;
            top: -4px;
            border-bottom: 4px solid #ffc800;
            left: -10px;
        }

        .discount-product{
            display: inline;
            margin-right: 17px;
        }
        .products-grid .product-item .product-item-info .product-item-details .product-item-name {
            height: 38px;
        }
        .header-content-info{
            display: none;
        }
        .price-unavailable{
            opacity: 0;
        }
        .product-disable{
            filter: grayscale(1) !important;
            opacity: 0.6;
        }
        .product-item-actions button{
            width: 100%;
        }
        .page-wrapper .page-header .header.content {
            padding: 20px 15px 25px;
        }
        .products-grid .product-item .product-item-info .product-item-details .price-box {
            margin-top: -10px;
        }
        .page-wrapper .page-header .header.content .block-search {
            z-index: 15;
        }
        .product-item-inner-tags{
            width: max-content !important;
        }
        .tocart-mobile{
            display: none;
        }
        .discount-label .percentage{
            display: inline-block;
            position: relative;
            top: 9px;
            left: auto;
        }
        .discount-label .off{
            font-size: 11.5px;
            display: inline-block;
            font-style: italic;
            margin-left: -1px;
            font-weight: 400;
            position: relative;
            top: 9px;
            left: auto;
        }
        .products .product-item{
            border: 1px solid #ececec;
            border-bottom: none;
            border-radius: 3px;
            padding: 5px 0 !important;
            transition: 0.5s;
        }
        .product-slider{
            border: none !important;
        }
        .product-slider .product-item-info{
            border: none !important;
        }        
        .products .product-item:hover {
            border: 1px solid #d3d3d3;
            border-bottom: none;
            transition: 0.5s;
        }
        .main .carousel-container{
            margin-top: -5px;
        }        
        .main .carousel-container{
            width: 100vw;
            margin-left: calc(-50vw + 50% - 8px);
        }
        .main .owl-carousel .owl-stage{
            left: calc(50% - 4800px);
        }
        .opc-progress-bar {
            text-align: center;
            margin-top: 25px;
        }        
        @media only screen and (min-width : 768px) and (max-width : 1131px) {
            .page-wrapper .page-header .header.content .block-search {
                width: auto;
            }
        }        
        @media only screen and (max-width : 992px) {
            .header.panel > .header.links > li.welcome{
                display: none;
            }
        }        
        @media only screen and (min-width : 767px) and (max-width : 782px) {
            .page-wrapper .page-header .header.content .block-search {
                float: left;
                padding-left: 0;
                margin-left: 0;
                top: -45px;
            }
        }
        @media only screen and (min-width : 782px) and (max-width : 797px) {
            .page-wrapper .page-header .header.content .block-search {
                float: left;
                padding-left: 0;
                margin-left: 0;
                top: 0px;
            }
        }  
        @media only screen and (max-width: 480px) {
            .products .product-item{
                margin-bottom: 5px;
                border: 1px solid #ececec;
            }
            .tocart-mobile{
                position: absolute;
                bottom: 0;
                z-index: 99;
                left: 50%;
                display: block;
            }
            .tocart-mobile button{
                left: -50%;
                position: relative;
                padding: 7px 14px 8px 12px !important;
            }
            .tocart-mobile button i{
                font-size: 21px;
            } 
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty {
                background: transparent !important;
                top: 11px !important;
                border: 1px solid " . $this->getTheme('header_cart_text') . " !important;
                line-height: 22px;
            }
        }   
        
        @media only screen and (min-width : 972px) and (max-width : 1026px) {
            .page-wrapper .page-header .header.content .block-search {
                width: 320px;
            }
        }
        
        @media only screen and (min-width : 900px) and (max-width : 972px) {
            .page-wrapper .page-header .header.content .block-search {
                width: 248px;
            }
        }
        
        @media only screen and (min-width : 782px) and (max-width : 900px) {
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 8px;
                margin-bottom: -8px;
            }
        }
        
        @media only screen and (min-width : 769px) and (max-width : 781px) {
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 55px;
                margin-bottom: -55px;
            }
        }
        
        @media only screen and (min-width : 768px) and (max-width : 768px) {
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 50px;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
                margin-top: 0px;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper {
                margin-top: 30px;
            }
            .page-wrapper .page-header .header.content .block-search {
                margin-top: 12px;
                margin-bottom: -25px;
                width: 200px;
            }
            .page-wrapper .page-header .header.content .logo {
                width: 240px;
                margin-top: 20px;
                margin-bottom: -13px;
            }
            .nav-toggle {
                top: 2px;
            }
        }
        
        @media only screen and (min-width : 468px) and (max-width : 767px) {
            .page-wrapper .page-header .header.content {
                padding: 15px 10px 0px 10px !important;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart {
                margin-top: 0px;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty {
                background: transparent !important;
                top: 11px !important;
                border: 1px solid " . $this->getTheme('header_cart_text') . " !important;
                line-height: 22px;
            }
            .block-search .label {
                margin: -60px 85px 15px 0;
            }
            .nav-toggle {
                top: 25px;
            }
            .page-wrapper .page-header .header.content .logo {
                margin-top: -4px;
                margin-bottom: 12px;
            }
        }

        @media only screen and (min-width : 468px) and (max-width : 991px) {
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty {
                background: transparent !important;
                border: 1px solid " . $this->getTheme('header_cart_text') . " !important;
            }          
        }
        
        @media only screen and (min-width : 468px) and (max-width : 766px) {
            .block-search .label {
                margin: 12px 55px 15px 0;
            }
        }        
               .opc-wrapper .shipping-address-item.selected-item:after {
            background: " . $this->getTheme('menu_item_background') . " !important;
        }
        .opc-wrapper .shipping-address-item.selected-item{
            border: 1px solid " . $this->getTheme('menu_item_background') . " !important;
        }

        .opc-progress-bar-item._active > span:before,
        .opc-progress-bar-item._active:before {
            background: " . $this->getTheme('menu_item_background') . " !important;
            border-color: " . $this->getTheme('menu_item_background') . " !important;
        }

        .block-collapsible-nav .item.current a, 
        .block-collapsible-nav .item.current > strong,
        .opc-progress-bar-item._active > span:after{
            border-color: " . $this->getTheme('menu_item_background') . " !important;
        }

        a,
        .alink,
        a:visited, 
        .alink:visited {
            color:  " . $this->getTheme('menu_item_background') . ";
        }

        .tag-discount{
            background: " . $this->getTheme('menu_item_text') . " !important;
            color: " . $this->getTheme('header_background') . " !important;
        }

        @media only screen and (min-width: 1360px) {  
            .page-wrapper .page-header .header.content .minicart-wrapper{
                border: 1px solid " . $this->getTheme('header_search_border') . " !important;
                border-radius: 100px;
            }

            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart{
                border: none !important;
                padding-left: 16px !important;
                padding-right: 13px !important;
            }

            .checkout-btn-minicart {
                line-height: 37px !important;
                border-left: 1px solid " . $this->getTheme('header_search_border') . " !important;
                padding-left: 10px;
                height: 35px;
                margin-top: 4px;
            }
            .header .minicart-wrapper {
                width: 225px;
            }
        }

        #mnn-header {
            background: " . $this->getTheme('header_background') . " !important;
        }

        .fa-chevron-down,
        #mnn-fullname,
        #mnn-shortname,
        .minicart-wrapper .action.showcart:before,
        body .checkout-btn-minicart a {
            color: " . $this->getTheme('header_text') . " !important;
        }

        .dropbtn,
        .mnn-cart .minicart-wrapper {
            border: 1px solid " . $this->getTheme('header_search_border') . " !important;
        }

        .minicart-wrapper .checkout-btn-minicart {
            border-left: 1px solid " . $this->getTheme('header_search_border') . " !important;
        }

        #store_menu {
            border-left: 1px solid #f6f6f6 !important;
            z-index: 10;
        }

        .page-footer #category_menu {
            z-index: 9;
        }
       
        .mnn-account .links li a{
            color: " . $this->getTheme('header_text') . " !important;
        }

        #category_menu .category_title span{
            color: " . $this->getTheme('menu_submenu_text') . " !important;
            margin-top: -2px !important;
            display: inline-block !important;
            padding-bottom: 2px !important;
        }

        .category_title i{
            color: " . $this->getTheme('menu_submenu_text') . " !important;
        }

        .mnn-product-info {
            background: " . $this->getTheme('productpage_background') . " !important;
        }
        .mnn-product-info .product-name {
            color: " . $this->getTheme('productpage_title') . " !important;
        }

        .m2n-category-parent:hover {
            background: " . $this->getTheme('menu_item_background_hover') . " !important;
            cursor: pointer;
        }

        .por_peso,
        .mnn-product-info .product-addto-links .action,
        .mnn-product-page .mnn-product-info .product-add .qty label,
        .m2n-price-detail .preco_novo,
        .m2n-price-detail .preco_original{
            color: " . $this->getTheme('productpage_color') . " !important;
        }

        .mnn-product-page .mnn-product-info .product-add .actions button{
            background: " . $this->getTheme('productpage_button_bg') . " !important;
            color: " . $this->getTheme('productpage_button_color') . " !important;
        }

        .qty-btn .fa{
            color: " . $this->getTheme('productpage_button_bg') . " !important;
        }

        #product-review,
        #product-review legend,
        #product-review .field label,
        .product-shortdescription,
        .product-shortdescription .product-name,
        .product-description {
            background: " . $this->getTheme('productpage_desc_bg') . " !important;
            color: " . $this->getTheme('productpage_desc_color') . " !important;
        }

        .product-card .product-name span{
            color: " . $this->getTheme('content_card_name') . " !important;
        }
        ";

        //Layout - Header

        $header_css = "
        .toolbar-products .modes{
            display: none !important;
        }

        .page-wrapper .page-header .panel.wrapper {
            height: 0 !important;
        }

        @media only screen and (min-width: 768px) { 
            .opc-progress-bar {
                margin-top: 25px;
            }            
            .page-wrapper > .breadcrumbs{
                box-sizing: border-box;
                width: 100%;
                margin-top: 10px;
            }                       
            .nav-sections .navigation > ul > li.level0 {
                float: left !important;
                width: 100% !important;
                height: 37px !important;
            }
            .nav-sections .navigation > ul > li.level0.parent > a.level-top {
                padding: 9px 28px 18px 20px !important;
            }
            .nav-sections .navigation > ul > li.level0 > a.level-top{
                padding: 9px 28px 18px 20px !important;
                height: 37px !important;
                margin-top: 2px !important;
            }            
            .navigation ul {
                padding: 0 !important;
            }
            .page-wrapper .page-header .header.content .logo {
                left: 50px;
            }
            .nav-toggle:before {
                color: " . $this->getTheme('header_text') . " !important;               
            }              
            .page-wrapper .nav-sections .navigation > ul li.level0 {
                border: none !important;
            }
            .page-wrapper .page-header .header.content .logo {
                height: 70px;
                max-height: 70px;
            }
            .logo img {
                width: auto;
            }
        }   
        @media only screen and (min-width: 991px) {            
            .nav-sections .navigation > ul > li.level0 .submenu {
                top: 2px !important;
                left: 350px !important;
            }
            
            .nav-sections .navigation .category-item .level1 .submenu {
                top: 0px !important;
                left: 230px !important;
            }
            
            .navigation .level0.parent > .level-top > .ui-menu-icon:after {
                display: none !important;
                content: none !important;
            }           
            .nav-visible{
                display: initial !important;
            }   

            .nav-sections{
                display: none;
                width: 350px;
                min-height: 250px !important;
                max-height: 400px !important;
                position: absolute !important;
                z-index: 9999 !important;
                margin-top: 130px !important;
                left: 30px !important;
                padding: 12px 0 18px 0 !important;
            }
            .nav-sections .navigation > ul > li.level0 {
                float: left !important;
                width: 100% !important;
                height: 37px !important;
            }
            .nav-sections .navigation > ul > li.level0.parent > a.level-top {
                padding: 9px 28px 18px 20px !important;
            }
            .nav-sections .navigation > ul > li.level0 > a.level-top{
                padding: 9px 28px 18px 20px !important;
                height: 37px !important;
                margin-top: 2px !important;
            }
            
            .navigation ul {
                padding: 0 !important;
            }
        
            .nav-toggle {
                display: inline-block !important;
                z-index: 999 !important;
                margin-top: 30px !important;
                padding-right: 15px;
            }
            .nav-toggle:before {
                color: " . $this->getTheme('header_text') . " !important;               
            }  
            
            .page-wrapper .nav-sections .navigation > ul li.level0 {
                border: none !important;
            }         
        }    
        @media only screen and (max-width: 480px) {               
            @media only screen and (max-width: 400px) {
                .minicart-wrapper {
                    padding-bottom: 3px !important;
                }
            }
            .logo img {
                margin-top: 3px !important;
                margin-bottom: -3px !important;
            }
            .page-footer .footer-top .footer-links .footer-links-main .footer-links-column .footer-colum-title > h3 {
                margin-bottom: 8px !important;
                margin-top: 20px !important;
            }
            .block-search .control {
                border: none !important;
            }
            .nav-toggle:before {
                margin-top: 20px;
            }
            .page-wrapper .page-header .header.content .minicart-wrapper .action.showcart .counter.qty .counter-number,
            .nav-toggle:before,
            .block-search .label:before {
                color: " . $this->getTheme('header_text') . " !important;
            }
            .logo {
                max-height: 50px;
            }
            .logo img {
                max-height: 50px;
                width: auto;
                display: block;
                margin: auto;
            }

            #store_menu{
                margin-top: -20px !important;
                margin-bottom: 15px !important;
            }
            .category-title{
                margin-top: 30px !important;
            }
        }
        .cart-summary *{
            border: none !important
        }
        .sidebar.sidebar-main .block .block-content.filter-content .filter-subtitle{
            padding: 15px;
        }
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-subtitle,
        .sidebar.sidebar-main .block .block-content.filter-content .filter-options .filter-options-item {
            background: #ffffff !important;
        }
        
        .page-wrapper .nav-sections .nav-sections-item-title .nav-sections-item-switch, 
        .page-wrapper .nav-sections .nav-sections-item-title.active .nav-sections-item-switch,
        .page-wrapper .nav-sections .navigation > ul li.level0 > a.level-top {
            color: " . $this->getTheme('menu_submenu_text') . " !important;
        }

        @media only screen and (max-width: 768px) {   
            .page-wrapper .nav-sections .header.links > li > a,
            .page-wrapper .nav-sections .header.links > li > span{
                color: " . $this->getTheme('menu_item_text') . " !important;
            }
            .nav-sections .header.links,
            .nav-sections .header.links li > a,
            .nav-sections .header.links li.greet.welcome{
                border: none !important;
            }
            .nav-sections .header.links li.greet.welcome span{
                font-weight:400 !important;
                font-size: 13px;
            }
            .nav-sections .header.links li.greet.welcome{
                text-align: center;
                line-height: 15px;                
                opacity: 0.8;
            }
        }

        
        .nav-sections-item-title {
            background: " . $this->getTheme('menu_item_background') . " !important;
            border: none;
            border-right: 1px solid " . $this->getTheme('menu_submenu_background') . " !important;
            width: 50%;
        }

        .page-wrapper .nav-sections .navigation>ul li.level0 ul.submenu{
            z-index: 999999 !important;
            top: -26px !important;
            background: " . $this->getTheme('menu_submenu_background') . " !important;
        }
        .nav-sections .navigation > ul > li.level0 > a.level-top.ui-state-active{
            background: rgba(0,0,0,0.1) !important;
        }
        .page-wrapper .nav-sections .navigation>ul li.level0 ul.submenu li{
            background: rgba(0,0,0,0.05) !important;
        }

        @media only screen and (max-width: 480px) { 
            .cart.table-wrapper .item .col.item{
                width: 100% !important;
                padding: 5px !important;
            }   
            .cart.table-wrapper .product-item-photo{
                left: 0 !important;
            }
            .item-info .col-price,
            .item-info .col-qty,
            .item-info .col-subtotal{
                width: 33% !important;
                margin-top: -25px;
                margin-bottom: 10px;
            }
            .item-info{
                width: 100% !important;
                display: inline-block !important;
            }
            .product-item-photo{
                float: left;
            }
            .product-item-details{
                float: right;
                width: calc(100% - 60px);
            }
            .cart.table-wrapper .actions-toolbar > .action-edit{
                right: -25px;
                top: 35px;
            }
            .item-actions{
                width: 45px !important;
            }
            .cart-item{
                border-bottom: 1px solid #eee;
            }
            .cart-item:last-child{
                border-bottom: none;
            }
        }

        .checkout-methods-items,
        #co-shipping-method-form,
        .cep-invalidate{
            display: none;
        }

        .cep-invalidate{
            padding: 15px 0;
        }

        .cep-invalidate span:first-child{
            color: #e03c3c;
        }

        .cep-invalidate span:last-child{
            font-weight: 500;
            color: #1b8dde;
            display: inline-block;
            cursor: pointer;
            margin-top: 10px;
        }
        .table-wrapper {
            margin-top: -50px;
        }

        .category_menu-sub {
            background: " . $this->getTheme('menu_item_background') . " !important;
            color: #fff;
        }
    
        .category_menu-sub a {
            color: #fff;
        }

        .category-selected{
            background: " . $this->getTheme('menu_item_background') . " !important;
        }

        .category-selected i,
        .category-selected a:hover,
        .category-selected a{
            color: #fff  !important;
        }

        
        .product-details {
            background: " . $this->hex2rgba($this->getTheme('button_background'), 0.85) . " !important;
            color: " . $this->getTheme('button_text') . " !important;
        }
        .product-details:hover {
            background: " . $this->hex2rgba($this->getTheme('button_background'), 0.90) . " !important;
        }
        .product-wishlist {
            background: " . $this->hex2rgba($this->getTheme('button_background'), 0.75) . " !important;
            color: " . $this->getTheme('button_text') . " !important;
        }
        .product-wishlist:hover {
            background: " . $this->hex2rgba($this->getTheme('button_background'), 0.80) . " !important;
        }
        
        .action-remove a,
        .action-input a,
        .action-add a{
            background: " . $this->getTheme('button_text') . " !important;
            color: " . $this->getTheme('button_background') . " !important;
        }

        .card-hover-mobile a,
        .action-button a{
            color: " . $this->getTheme('button_text') . " !important;
            background: " . $this->getTheme('button_background') . " !important;
        }

        .card-hover-wishlist-mobile a {
            color: " . $this->getTheme('button_background') . " !important;
        }

        .product-name a{
            color: " . $this->getTheme('content_card_name') . " !important;
        }

        .swal-button{
            background: " . $this->getTheme('button_background') . " !important;
            color: " . $this->getTheme('button_text') . " !important;
            border: none !important;
        }
        .swal-button:hover{
            background: " . $this->getTheme('button_background_hover') . " !important;
            color: " . $this->getTheme('button_text_hover') . " !important;
            border: none !important;
        }

        .product-info-price,
        .img-hover-cart,
        .product-price{
            color: " . $this->getTheme('content_card_details') . " !important;
        }

        .minicart-wrapper .action.showcart .counter.qty{
            background: transparent !important;
            border: none !important;
            color: " . $this->getTheme('header_text') . " !important;
            margin-left: -5px !important;
            margin-right: -5px !important;
        }
        
        .minicart-wrapper .action.showcart .counter-number {
            text-shadow: none;
        }

        .page-title-main>strong {
            border-bottom: 1px solid " . $this->hex2rgba($this->getTheme('button_background'), 0.20) . " !important;
            color: " . $this->getTheme('button_background') . " !important;       
        }

        .field label{
            color: " . $this->getTheme('content_text_color') . " !important;       
            font-size: 14px !important;
            font-weight: 500 !important;
            text-align: left !important;
        }

        a{
            text-decoration: none !important;
        }
        .mnn-header a {
            color: " . $this->getTheme('header_text') . " !important;    
        }

        .two {
            background: " . $this->getTheme('menu_item_text') . " !important;    
        }

        .discount-tag {
            color: " . $this->getTheme('button_text') . " !important;
            background: " . $this->getTheme('button_background') . " !important;
        }



        .mnn_shipping_address {
            background: " . $this->getTheme('checkout_address_background') . " !important;
            color: " . $this->getTheme('checkout_address_color') . " !important;
        }
        .mnn_shipping_method {
            background: " . $this->getTheme('checkout_shipping_background') . " !important;
            color: " . $this->getTheme('checkout_shipping_color') . " !important;
        }
        .mnn_shipping_schedule {
            background: " . $this->getTheme('checkout_delivery_background') . " !important;
            color: " . $this->getTheme('checkout_delivery_color') . " !important;
        }
        .mnn_payment {
            background: " . $this->getTheme('checkout_payment_background') . " !important;
            color: " . $this->getTheme('checkout_payment_color') . " !important;
        }

        .mnn_shipping_address .mnn_shipping_action .mnn-opc-next{
            background: transparent !important;
            border: 1px solid " . $this->getTheme('checkout_address_button') . " !important;
            color: " . $this->getTheme('checkout_address_button') . " !important;
        }
        .mnn_shipping_method .mnn_shipping_action .mnn-opc-next{
            background: transparent !important;
            border: 1px solid " . $this->getTheme('checkout_address_button') . " !important;
            color: " . $this->getTheme('checkout_shipping_button') . " !important;
        }
        .mnn_shipping_schedule .mnn_shipping_action .mnn-opc-next{
            background: transparent !important;
            border: 1px solid " . $this->getTheme('checkout_address_button') . " !important;
            color: " . $this->getTheme('checkout_delivery_button') . " !important;
        }
        .mnn_payment .mnn_shipping_action .mnn-opc-next{
            background: transparent !important;
            border: 1px solid " . $this->getTheme('checkout_address_button') . " !important;
            color: " . $this->getTheme('checkout_payment_button') . " !important;
        }

        .mnn_shipping_address .mnn_shipping_action .mnn-opc-back{
            background: transparent !important;
            border: 1px solid transparent !important;
            color: " . $this->getTheme('checkout_address_button') . " !important;
        }
        .mnn_shipping_method .mnn_shipping_action .mnn-opc-back{
            background: transparent !important;
            border: 1px solid transparent !important;
            color: " . $this->getTheme('checkout_shipping_button') . " !important;
        }
        .mnn_shipping_schedule .mnn_shipping_action .mnn-opc-back{
            background: transparent !important;
            border: 1px solid transparent !important;
            color: " . $this->getTheme('checkout_delivery_button') . " !important;
        }
        .mnn_payment .mnn_shipping_action .mnn-opc-back{
            background: transparent !important;
            border: 1px solid transparent !important;
            color: " . $this->getTheme('checkout_payment_button') . " !important;
        }

        .totals .label{
            color: " . $this->getTheme('content_body_textcolor') . " !important;
        }

        .opc-sidebar,
        body .mnn_resume .opc-block-summary{
            background: " . $this->getTheme('checkout_info_background') . " !important;
        }

        .mnn_resume .opc-block-summary>.title,
        .mnn_resume .label,
        body .mnn_resume .cart-summary,
        body .mnn_resume .modal-content {
            color: " . $this->getTheme('checkout_info_color') . " !important;
        }

        .mnn_checkout .fa-angle-right{
            color: " . $this->getTheme('checkout_page_text') . " !important;
        }

        .mnn_checkout .new-address-popup button{
            background: " . $this->getTheme('checkout_address_button') . " !important;
            color: " . $this->getTheme('checkout_address_background') . " !important;
        }
                
        .mnn_checkout .opc-wrapper .shipping-address-item.selected-item {
            border: 1px solid " . $this->getTheme('checkout_address_button') . " !important;
        }
        .mnn_checkout .opc-wrapper .shipping-address-item.selected-item:after{
            background: " . $this->getTheme('checkout_address_button') . " !important;
        }
        #payment .field label,
        #payment .field span {
            color: " . $this->getTheme('checkout_payment_color') . " !important;
            font-size: 14px !important;
        }  
        
        body .main_menu,
        body .menumnn-mobile .menu .active {
            background: " . $this->getTheme('button_background') . " !important;
        }
        

        .orders-history-mobile .col-md-12 a {
            color: " . $this->getTheme('content_body_textcolor') . " !important;
        }

        body .nav-sections-items .active{
            background: " . $this->getTheme('header_cart_background') . " !important;
        }
        body .page-wrapper .nav-sections .nav-sections-item-title.active .nav-sections-item-switch{
            color: " . $this->getTheme('header_cart_text') . " !important;
        }

        @media only screen and (max-width :480px) {
            body #store_menu{
                background: transparent !important;
            }
            body #store_menu .menu_item, #store_menu .menu_item i, 
            body .menu_item_home, .menu_item_home i {
                color: " . $this->getTheme('content_body_textcolor') . " !important;
            }
         }

        @media only screen and (max-width: 991px) {
            body .opc-estimated-wrapper {
                background: transparent !important;
                border-color: " . $this->getTheme('checkout_shipping_background') . " !important;
                color: " . $this->getTheme('checkout_shipping_color') . " !important;
            }
        }

        body .post-info-wraper h2.mp-post-title a, 
        body .about-admin h4.admin-title a, 
        body .mp-post-meta-info a.mp-read-more, 
        body .mp-post-info a.mp-info, 
        body ul.menu-categories a.list-categories:hover, 
        body .products-same-post a.product-item-link:hover, 
        body a.mp-relate-link, 
        body .mpblog-product-name{
            color: " . $this->getTheme('content_card_details') . " !important;
        }

        .mnn-blog .rss_blog{
            border: 1px solid " . $this->getTheme('header_search_border') . " !important;
        }

        .mnn-blog span,
        .mnn-blog i{
            color: " . $this->getTheme('header_text') . " !important;
        }


        /*##############*/

        #category_menu {
            border: 1px solid " . $this->getTheme('menu_submenu_border') . " !important;
        }

        .sidebar .product-items-names .product-item, 
        .sidebar.sidebar-additional .block.block-compare, 
        .sidebar.sidebar-additional .block.block-wishlist, 
        .sidebar.sidebar-additional .block.block-reorder, 
        #category_menu .category_title, 
        #category_menu,
        #category_menu_more {
            background: " . $this->getTheme('menu_background') . " !important;
        }

        .m2n-category-parent {
            background: " . $this->getTheme('menu_item_background') . " !important;
        }

        .m2n-category-parent:hover {
            background: " . $this->getTheme('menu_item_background_hover') . " !important;
        }

        #category_menu .category-selected i, 
        #category_menu .category-selected a:hover, 
        #category_menu .category-selected a,
        #category_menu .block-content span,
        #category_menu .block-content strong,
        #category_menu .block-content i,
        #category_menu .block-content label,
        #category_menu .empty,
        #category_menu .block-content div,
        #category_menu .block-content a,
        #category_menu .category_title span,
        .sidebar.sidebar-additional .block.block-compare .block-title > strong, 
        .sidebar.sidebar-additional .block.block-wishlist .block-title > strong, 
        .sidebar.sidebar-additional .block.block-reorder .block-title > strong,
        #category_menu_more span, .menu_item, .menu_item a, .menu_item i, 
        .m2n-category-parent a, 
        .m2n-category-selected a, 
        .m2n-category-parent i,
        #category_menu_more span, 
        .menu_item, .menu_item a, 
        .menu_item i, 
        .m2n-category-parent a, 
        .m2n-category-selected a, 
        .m2n-category-parent i {
            color: " . $this->getTheme('menu_item_text') . " !important;
        }

        #category_menu_more:hover span, 
        .category_title i,
        .menu_item:hover, 
        .menu_item:hover a, 
        .menu_item:hover i, 
        .m2n-category-parent:hover span, 
        .m2n-category-parent:hover span a, 
        .m2n-category-parent:hover span i, 
        .m2n-category-parent a:hover, 
        .m2n-category-parent a:hover i {
            color: " . $this->getTheme('menu_item_text_hover') . " !important;
        }

        .category_menu-sub{
            background: " . $this->getTheme('menu_submenu_background') . " !important;
            filter: none !important
        }

        .category_menu-sub a, 
        .category_menu-sub-sub a{
            color: " . $this->getTheme('menu_submenu_text') . " !important;
        }

        .category_menu-sub .category-show:hover a, 
        .category_menu-sub-sub .category-show:hover a{
            color: " . $this->getTheme('menu_submenu_text_hover') . " !important;
        }
        ";


        $css = $header . $menu . $button . $content . $fixed . $header_css;
        $css = $css . $this->getTheme('header_css') . $this->getTheme('menu_css') . $this->getTheme('content_css');

        $path = $path_dir . "/frontend/web/css";

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fullpath = $path . "/style.css";

        $fp = fopen($fullpath, "wb");
        fwrite($fp, $css);
        fclose($fp);
    }
}
