<?php

namespace Rdtech\Adicionarcarrinho\Controller\Index;

use Magento\Framework\App\ResourceConnection;
class Updatecart extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $formKey;
    protected $resourceConnection;
    protected $quoteRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        ResourceConnection $resourceConnection,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        array $data = []
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->resourceConnection = $resourceConnection;
        $this->quoteRepository = $quoteRepository;
    }

    public function execute()
    {
        $_item_id = $_POST['quote_item_id'];
        $_item_qty = $_POST['qty'];

        $connection = $this->resourceConnection->getConnection();

        $query = "update quote_item set qty = " . $_item_qty . " where item_id = " . $_item_id;
        $update = $connection->query($query);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');

        $itemsVisible = $cart->getQuote()->getAllVisibleItems();

        foreach ($itemsVisible as $item) {
            $item->calcRowTotal();
            $item->save();
        }

        $query = "select item_id, quote_id, product_id, qty, price, row_total from quote_item ite where item_id = " . $_item_id;
        $result = $connection->fetchAll($query);

        foreach ($result as $item) {
            $_item = $item;
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_product = $objectManager->get('Magento\Catalog\Api\ProductRepositoryInterface')->getById($_item['product_id']);

?>
        <div class="col-md-2 col-sm-2 col-xs-2">
            <div class="col-md-12 cart-item-img">
                <span class="product-image-container product-image-container-<?= $_item['product_id'] ?>" style="width: 115px;">
                    <span class="product-image-wrapper" style="padding-bottom: 100%;">
                        <img class="product-image-photo" src="<?= $_product->getExternalImage() ?>" loading="lazy" width="115" height="115">
                    </span>
                </span>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-10">
            <div class="col-md-12">
                <div class="col-md-10 col-sm-10 col-xs-10 cart-item-name">
                    <?php if ($_product->getProductUrl()) : ?>
                        <a href="<?= $_product->getProductUrl() ?>"><?= $_product->getName() ?></a>
                    <?php else : ?>
                        <?= $_product->getName() ?>
                    <?php endif; ?>

                    <?php
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
                    $_product_qty = $StockState->getStockQty($_product->getId(), $_product->getStore()->getWebsiteId());

                    if($_item['qty'] > $_product_qty){
                    ?>  
                    <div class="col-md-12">
                        <span style="font-weight: 500; color: #ef2121;">Quantidade indisponível</span>
                    </div>
                    <?php
                    }
                    ?>

                    <?php
                    /*if ($messages = $block->getMessages()) : ?>
                        <?php foreach ($messages as $message) : ?>
                            <div class="cart item message <?= $block->escapeHtmlAttr($message['type']) ?>">
                                <div><?= $block->escapeHtml($message['text']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php $addInfoBlock = $block->getProductAdditionalInformationBlock(); ?>
                    <?php if ($addInfoBlock) : ?>
                        <?= $addInfoBlock->setItem($_item)->toHtml() ?>
                    <?php endif; 
                    */ ?>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <div class="item-actions" style="margin-top: 5px;">
                        <div class="actions-toolbar">
                            <div id="gift-options-cart-item-<?= $_item['item_id'] ?>" data-bind="scope:'giftOptionsCartItem-<?= $_item['item_id'] ?>'" class="gift-options-cart-item">
                            </div>
                            <a href="#" data-post="{&quot;action&quot;:&quot;http:\/\/mercado.local\/wishlist\/index\/fromcart\/&quot;,&quot;data&quot;:{&quot;item&quot;:&quot;<?= $_item['item_id'] ?>&quot;,&quot;uenc&quot;:&quot;aHR0cDovL21lcmNhZG8ubG9jYWwvY2hlY2tvdXQvY2FydC8,&quot;}}" class="use-ajax action towishlist action-towishlist">
                                <span>Mover para Lista de Compras</span>
                            </a>
                            <a class="action action-edit" href="http://mercado.local/checkout/cart/configure/id/<?= $_item['item_id'] ?>/product_id/<?= $_item['product_id'] ?>/" title="Editar parâmetros do item">
                                <span>Editar</span>
                            </a>
                            <a href="#" title="Remover item" class="action action-delete" data-post="{&quot;action&quot;:&quot;http:\/\/mercado.local\/checkout\/cart\/delete\/&quot;,&quot;data&quot;:{&quot;id&quot;:&quot;<?= $_item['item_id'] ?>&quot;,&quot;uenc&quot;:&quot;aHR0cDovL21lcmNhZG8ubG9jYWwvY2hlY2tvdXQvY2FydC8,&quot;}}">
                                <span>
                                    Remover item </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="col-md-3 col-sm-6 col-xs-6 preco-kg">
                    <?php
                    if ($_product->getProdutoPorPeso()) {
                        if ($_product->getSpecialPrice()) {
                    ?>
                            <div style="width: 100%" class="<?= $_product->getProdutoPorPeso() ? 'peso_classe-preco  peso_classe' : 'classe_unidade unidade-preco' ?> peso-preco col price col-price" data-th="<?= $_item['price'] ?>">
                                <span class="label-price">Preço/<?= round($_product->getProdutoPesoUnidade(), 2) ?><?= $_product->getProdutoUnidadeMedida() ?></span>
                                <span style="font-weight: 300;font-size: 13px;color: #858585;margin-top: -1px;display: block;">R$<?= number_format($_product->getPrice(), 2, ',', '.') ?></span>
                                <span style="font-weight: 600; font-size: 18px; color: #616161; margin-top: -3px; display: inline-block;">R$<?= number_format($_product->getSpecialPrice(), 2, ',', '.') ?></span>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div style="width: 100%" class="<?= $_product->getProdutoPorPeso() ? 'peso_classe-preco  peso_classe' : 'classe_unidade unidade-preco' ?> peso-preco col price col-price" data-th="<?= $_item['price'] ?>">
                                <span class="label-price">Preço/<?= round($_product->getProdutoPesoUnidade(), 2) ?><?= $_product->getProdutoUnidadeMedida() ?></span>
                                <span style="font-weight: 600; font-size: 18px; color: #616161; margin-top: -3px; display: inline-block;">R$<?= number_format($_product->getPrice(), 2, ',', '.') ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 preco-kg">
                    <?php
                    if ($_product->getProdutoPorPeso()) {
                    ?>
                        <div style="width: 100%;text-align:center" class="<?= $_product->getProdutoPorPeso() ? 'peso_classe-qtdpeso  peso_classe' : 'classe_unidade' ?> peso-qtd col price col-price" data-th="<?= $_item['price'] ?>">
                            <span class="label-price">Quantidade</span>
                            <span style="font-weight: 600; font-size: 18px; color: #616161; margin-top: -3px; display: inline-block;"><?= ($_item['qty'] * $_product->getProdutoPesoUnidade()) ?><?= $_product->getProdutoUnidadeMedida() ?></span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-4">
                    <div style="width: 100%" class="<?= $_product->getProdutoPorPeso() ? 'peso_classe-precokg  peso_classe' : 'classe_unidade unidade-preco' ?> col price col-price" data-th="<?= $_item['price'] ?>">

                        <?php
                        if ($_product->getProdutoPorPeso()) {
                            if ($_product->getSpecialPrice()) {
                        ?>
                                <span class="label-price">Preço/KG</span>
                                <span style="font-weight: 300;font-size: 13px;color: #858585;margin-top: -1px;display: block;">R$<?= number_format($_product->getPriceQuilo(), 2, ',', '.') ?></span>
                                <span style="font-weight: 600; font-size: 18px; color: #616161; margin-top: -3px; display: inline-block;">R$<?= number_format($_product->getSpecialPriceQuilo(), 2, ',', '.') ?></span>
                            <?php
                            } else {
                            ?>
                                <span class="label-price">Preço/KG</span>
                                <span style="font-weight: 600; font-size: 18px; color: #616161; margin-top: -3px; display: inline-block;">R$<?= number_format($_product->getPriceQuilo(), 2, ',', '.') ?></span>
                            <?php
                            }
                        } else {
                            ?>
                            <span class="label-price">Unitário</span>
                            <span class="price-excluding-tax" data-label="Excl. Impostos">
                                <span class="cart-price">
                                    <span class="price">R$<?= number_format($_item['price'], 2, ',', '.') ?></span>
                                </span>
                            </span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-4">
                    <div style="width: 100%;" class="<?= $_product->getProdutoPorPeso() ? 'peso_classe-qtd  peso_classe' : 'classe_unidade unidade-qtd' ?> col qty col-qty" data-th="<?= 'Qtd' ?>">

                        <?php
                        if ($_product->getProdutoPorPeso()) {
                        ?>
                            <span class="label-price">Qtd/<?= round($_product->getProdutoPesoUnidade(), 2) ?><?= $_product->getProdutoUnidadeMedida() ?></span>

                            <div class="field qty">
                                <div class="control qty">
                                    <label for="cart-<?= $_item['item_id'] ?>-qty">
                                        <span class="label"><?= 'Qtd' ?></span>
                                        <input type="hidden" class="item-id" value="<?= $_item['item_id'] ?>">
                                        <input style="height: 22px;" id="cart-<?= $_item['item_id'] ?>-qty" name="cart[<?= $_item['item_id'] ?>][qty]" data-cart-item-id="<?= $_product->getSku() ?>" value="<?= intval($_item['qty']) ?>" type="number" size="4" step="any" title="<?= 'sku' ?>" class="input-text qty input-cart-qty" data-validate="{required:true,'validate-greater-than-zero':true}" data-role="cart-item-qty" onfocusout="updateCartItem(<?= $_item['item_id'] ?>, this)" />
                                    </label>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <span class="label-price">Qtd</span>

                            <div class="field qty">
                                <div class="control qty">
                                    <label for="cart-<?= $_item['item_id'] ?>-qty">
                                        <span class="label"><?= 'Qtd' ?></span>
                                        <input type="hidden" class="item-id" value="<?= $_item['item_id'] ?>">
                                        <input style="height: 22px;" id="cart-<?= $_item['item_id'] ?>-qty" name="cart[<?= $_item['item_id'] ?>][qty]" data-cart-item-id="<?= $_product->getSku() ?>" value="<?= intval($_item['qty']) ?>" type="number" size="4" step="any" title="<?= 'sku' ?>" class="input-text qty input-cart-qty" data-validate="{required:true,'validate-greater-than-zero':true}" data-role="cart-item-qty" onfocusout="updateCartItem(<?= $_item['item_id'] ?>, this)" />
                                    </label>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-4">
                    <div style="width: 100%;" class="<?= $_product->getProdutoPorPeso() ? 'peso_classe-total  peso_classe' : 'classe_unidade unidade-total' ?> col col-subtotal subtotal" data-th="<?= $_item['row_total'] ?>">
                        <span class="label-price">Total</span>

                        <?php
                        if ($_product->getSpecialPrice()) {
                        ?>
                            <span style="font-weight: 300;font-size: 13px;color: #858585;margin-top: -1px;display: block;">R$<?= number_format($_product->getPrice() * $_item['qty'], 2, ',', '.') ?></span>
                        <?php
                        }
                        ?>

                        <span class="price-excluding-tax" data-label="Excl. Impostos">
                            <span class="cart-price">
                                <span class="price">R$<?= number_format($_item['row_total'], 2, ',', '.') ?></span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
