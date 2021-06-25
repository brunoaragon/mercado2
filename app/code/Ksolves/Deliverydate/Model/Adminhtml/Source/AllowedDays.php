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

use Magento\Framework\Locale\ListsInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class AllowedDays
 */
class AllowedDays implements OptionSourceInterface
{
    /**
     * @var ListsInterface
     */
    protected $localeLists;

    /**
     * AllowedDays constructor.
     *
     * @param ListsInterface $localeLists
     */
    public function __construct(ListsInterface $localeLists)
    {
        $this->localeLists = $localeLists;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = $this->localeLists->getOptionWeekdays();
        array_unshift($options, [
            'label' => __('Nenhum'),
            'value' => -1
        ]);
        return $options;
    }
}