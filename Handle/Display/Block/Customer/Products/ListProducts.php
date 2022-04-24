<?php
/**
 *
 * PHP version 7
 *
 * @category  Block
 * @package   Handle_Display
 * @author    Ritesh Kumar Srivastava <rsrivastava453@gmail.com>
 * @copyright 2022 Ritesh Kumar Srivastava
 * @license   https://opensource.org/licenses/MIT MIT license
 */
namespace Handle\Display\Block\Customer\Products;

use Magento\Downloadable\Model\Link\Purchased\Item;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class ListProducts extends \Magento\Framework\View\Element\Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $customerSession;

    protected $productCollectionFactory;

    /**
     * ListProducts constructor.
     * @param Context               $context
     * @param Session               $customerSession
     * @param CollectionFactory     $productCollectionFactory
     * @param array                 $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->imageHelperFactory = $imageHelperFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @param   none
     * @return  backurl
     */
    public function getBackUrl()
    {
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl("customer/account/");
    }

    /**
     * @param  none
     * @return orderCollection
     */
    public function getProductCollection()
    {
        $num = 1;
        if ($this->getDisplayLimit()) {
            $num = $this->getDisplayLimit();
        }
        $collection = $this->productCollectionFactory
            ->create()
            ->setPageSize($num)
            ->addFieldToSelect("*")
            ->addFieldToFilter("product_select_attribute", ["eq" => 1]);
        return $collection;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDisplayLimit()
    {
        return $this->scopeConfig->getValue(
            "handledisplay/general/limit_num",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    /**
     * @param $product
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductImage($product)
    {
        $store = $this->storeManager->getStore();
        $imageUrl =
            $store->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) .
            "catalog/product" .
            $product->getSmallImage();
        return $imageUrl;
    }

    public function getProductImageUrl($product)
    {
        return $imageUrl = $this->imageHelperFactory
            ->create()
            ->init($product, "product_thumbnail_image")
            ->getUrl();
    }
}
