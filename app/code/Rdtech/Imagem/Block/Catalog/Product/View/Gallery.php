<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Simple product data view
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Rdtech\Imagem\Block\Catalog\Product\View;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Gallery\ImagesConfigFactoryInterface;
use Magento\Catalog\Model\Product\Image\UrlBuilder;
use Magento\Framework\Data\Collection;
use Magento\Framework\DataObject;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Stdlib\ArrayUtils;

/**
 * Product gallery block
 *
 * @api
 * @since 100.0.2
 */
class Gallery extends \Magento\Catalog\Block\Product\View\Gallery
{   
    /**
     * @var \Magento\Framework\Config\View
     */
    protected $configView;

    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var array
     */
    private $galleryImagesConfig;

    /**
     * @var ImagesConfigFactoryInterface
     */
    private $galleryImagesConfigFactory;

    /**
     * @var UrlBuilder
     */
    private $imageUrlBuilder;

    /**
     * @param Context $context
     * @param ArrayUtils $arrayUtils
     * @param EncoderInterface $jsonEncoder
     * @param array $data
     * @param ImagesConfigFactoryInterface|null $imagesConfigFactory
     * @param array $galleryImagesConfig
     * @param UrlBuilder|null $urlBuilder
     */

     /**
     * Retrieve collection of gallery images
     *
     * @return Collection
     */

    /**
     * Retrieve product images in JSON format
     *
     * @return string
     */
    public function getGalleryImagesJson()
    {
        
        $imagesItems = [];        
        /** @var DataObject $image */

        $_product = $this->getProduct();
                
        if(!$_product->getExternalImage()){
            foreach ($this->getGalleryImages() as $image) {
                $imageItem = new DataObject(
                    [
                        'thumb' => $image->getData('small_image_url'),
                        'img' => $image->getData('medium_image_url'),
                        'full' => $image->getData('large_image_url'),
                        'caption' => ($image->getLabel() ?: $this->getProduct()->getName()),
                        'position' => $image->getData('position'),
                        'isMain'   => $this->isMainImage($image),
                        'type' => str_replace('external-', '', $image->getMediaType()),
                        'videoUrl' => $image->getVideoUrl(),
                    ]
                );
                foreach ($this->getGalleryImagesConfig()->getItems() as $imageConfig) {
                    $imageItem->setData(
                        $imageConfig->getData('json_object_key'),
                        $image->getData($imageConfig->getData('data_object_key'))
                    );
                }
                $imagesItems[] = $imageItem->toArray();
            }
        } else {
            $external_gallery = $_product->getExternalImage();
            $external_gallery = explode(',',$external_gallery);

            $position = 0;
            $ismain = true;

            foreach ($external_gallery as $image) {
                $imageItem = new DataObject(
                    [
                        'thumb' => $image,
                        'img' => $image,
                        'full' => $image,
                        'caption' => '',
                        'position' => $position,
                        'isMain'   => $ismain,
                        'type' => 'image',
                        'videoUrl' => '',
                    ]
                );
               
                $imagesItems[] = $imageItem->toArray();

                $position++;
                $ismain = false;
            }
        }      
                       
        if (empty($imagesItems)) {
            $imagesItems[] = [
                'thumb' => $this->_imageHelper->getDefaultPlaceholderUrl('thumbnail'),
                'img' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'full' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'caption' => '',
                'position' => '0',
                'isMain' => true,
                'type' => 'image',
                'videoUrl' => null,
            ];
        }           
        
        return json_encode($imagesItems);
    }  
}
