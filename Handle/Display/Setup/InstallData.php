<?php
/**
 *
 * PHP version 7
 *
 * @category  Install attributes
 * @package   Handle_Display
 * @author    Ritesh Kumar Srivastava <rsrivastava453@gmail.com>
 * @copyright 2022 Ritesh Kumar Srivastava
 * @license   https://opensource.org/licenses/MIT MIT license
 */
namespace Handle\Display\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
/**
 * Install attributes
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(["setup" => $setup]);

        /**
         * Add attributes to the eav_attribute
         */
        $eavSetup->removeAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            "product_select_attribute"
        );
        $statusOptions = "Handle\Display\Model\Config\Source\StatusOptions";
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            "product_select_attribute",
            [
                "type" => "int",
                "backend" =>
                    "Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend",
                "frontend" => "",
                "label" => "Handle Display",
                "input" => "select",
                "class" => "",
                "source" => $statusOptions,
                "global" => ScopedAttributeInterface::SCOPE_GLOBAL,
                "visible" => true,
                "required" => false,
                "user_defined" => false,
                "default" => "0",
                "searchable" => false,
                "filterable" => false,
                "comparable" => false,
                "is_used_in_grid" => true,
                "visible_on_front" => false,
                "used_in_product_listing" => true,
                "unique" => false,
            ]
        );
    }
}
