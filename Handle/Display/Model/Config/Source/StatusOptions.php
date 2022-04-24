<?php
/**
 *
 * PHP version 7
 *
 * @category  Model
 * @package   Handle_Display
 * @author    Ritesh Kumar Srivastava <rsrivastava453@gmail.com>
 * @copyright 2022 Ritesh Kumar Srivastava
 * @license   https://opensource.org/licenses/MIT MIT license
 */
namespace Handle\Display\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class StatusOptions extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (null === $this->_options) {
            $this->_options=[
                                ['label' => __('Yes'), 'value' => 1],
                                ['label' => __('No'), 'value' => 0]
                            ];
        }
        return $this->_options;
    }
}
