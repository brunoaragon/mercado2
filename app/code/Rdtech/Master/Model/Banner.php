<?php

namespace Rdtech\Master\Model;

use \Rdtech\Master\Api\BannerInterface;
use Magento\Framework\App\ResourceConnection;

class Banner implements BannerInterface
{
    /**
     * @var \Magento\Customer\Api\Data\AddressInterfaceFactory
     */
    protected $addressFactory;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;
    /**
     * CustomerAddress constructor.
     * @param \Magento\Customer\Model\AddressFactory $addressFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Customer\Model\AddressFactory $addressFactory,
        \Magento\Framework\App\RequestInterface $request,
        ResourceConnection $resourceConnection
    ) {
        $this->addressFactory = $addressFactory;
        $this->request = $request;
        $this->resourceConnection = $resourceConnection;
    }
    public function getBanner()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $_store_url = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);

        $connection = $this->resourceConnection->getConnection();
        $table_banner = $connection->getTableName('mageplaza_bannerslider_slider');
        $table_product = $connection->getTableName('mageplaza_productslider_slider');

        $query = "select * from mageplaza_bannerslider_slider where status = 1;";
        $sliderCollection = $connection->fetchAll($query);

        $_slider = array();

        foreach ($sliderCollection as $_data) {

            $query = "select ban.banner_id, ban.name, ban.image from mageplaza_bannerslider_slider sli 
                inner join mageplaza_bannerslider_banner_slider inn on inn.slider_id = sli.slider_id
                inner join mageplaza_bannerslider_banner ban on ban.banner_id  = inn.banner_id
                where sli.slider_id = " . $_data['slider_id'];
            $bannerCollection = $connection->fetchAll($query);

            $_banner = array();

            foreach ($bannerCollection as $_bannerdata) {
                $_image_url = $_store_url."media/mageplaza/bannerslider/banner/image/" . $_bannerdata['image'];
                array_push($_banner, array('banner_id' => $_bannerdata['banner_id'], 'name' => $_bannerdata['name'], 'image' => $_image_url));
            }

            array_push($_slider, array('name' => $_data['name'], 'order_by' => $_data['priority'], 'from_date' => $_data['from_date'], 'to_date' => $_data['to_date'], 'banner' => $_banner));
        }

        return $_slider;
    }
}
