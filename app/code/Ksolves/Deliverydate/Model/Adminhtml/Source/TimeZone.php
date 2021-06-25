<?php
/**
 * Ksolves
 *
 * @category    Ksolves
 * @package     Ksolves_Deliverydate
 * @copyright   Copyright (c) Ksolves (https://www.ksolves.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */

namespace Ksolves\Deliverydate\Model\Adminhtml\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class DeliveryTime
 */
class TimeZone implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => 'America/Bahia',
                'value' => 'America/Bahia'
            ],
            [
                'label' => 'America/Belem',
                'value' => 'America/Belem'
            ],
            [
                'label' => 'America/Boa_Vista',
                'value' => 'America/Boa_Vista'
            ],
            [
                'label' => 'America/Campo_Grande',
                'value' => 'America/Campo_Grande'
            ],
            [
                'label' => 'America/Cuiaba',
                'value' => 'America/Cuiaba'
            ],
            [
                'label' => 'America/Fortaleza',
                'value' => 'America/Fortaleza'
            ],
            [
                'label' => 'America/Maceio',
                'value' => 'America/Maceio'
            ],
            [
                'label' => 'America/Manaus',
                'value' => 'America/Manaus'
            ],          
            [
                'label' => 'America/Noronha',
                'value' => 'America/Noronha'
            ],
            [
                'label' => 'America/Porto_Velho',
                'value' => 'America/Porto_Velho'
            ],
            [
                'label' => 'America/Recife',
                'value' => 'America/Recife'
            ],
            [
                'label' => 'America/Rio_Branco',
                'value' => 'America/Rio_Branco'
            ],
            [
                'label' => 'America/Sao_Paulo',
                'value' => 'America/Sao_Paulo'
            ]            
        ];
        return $options;
    }
}
