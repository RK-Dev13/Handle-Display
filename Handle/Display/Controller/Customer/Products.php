<?php
/**
 *
 * PHP version 7
 *
 * @category  Controller
 * @package   Handle_Display
 * @author    Ritesh Kumar Srivastava <rsrivastava453@gmail.com>
 * @copyright 2022 Ritesh Kumar Srivastava
 * @license   https://opensource.org/licenses/MIT MIT license
 */
namespace Handle\Display\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;

class Products extends \Magento\Framework\App\Action\Action
{
    private $customerSession;
    private $resultPageFactory;

    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
    /**
     * Retrieve customer session object
     *
     * @return \Magento\Customer\Model\Session
     */
    protected function _getSession()
    {
        return $this->customerSession;
    }

    /**
     * Check customer authentication
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->_getSession()->authenticate()) {
            $this->_actionFlag->set("", "no-dispatch", true);
        }
        return parent::dispatch($request);
    }
}
