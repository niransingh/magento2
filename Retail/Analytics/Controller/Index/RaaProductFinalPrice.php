<?php


namespace Retail\Analytics\Controller\Index;




class RaaProduct extends \Magento\Framework\App\Action\Action
{
    /**
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
	 */
	public function __construct(
		\Magento\Backend\App\Action\Context $context
		,\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
	) {
		parent::__construct($context);
		$this->resultJsonFactory = $resultJsonFactory;
	}

	
	public function execute() {
		
		$result = $this->resultJsonFactory->create();
		$data = array();
		
		try{
			$params = $this->getRequest()->getParams ();
			if(isset($params['lastid']) && isset($params['limit']))
			{
				$lastId = $params ['lastid'];
				$limit = $params ['limit'];
				$isadmin = (isset($params ['isadmin']))?$params ['isadmin']:false;
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$raaDataHelper = $objectManager->create('Retail\Analytics\Helper\Data');
				$width = $raaDataHelper->getImageWidth();
				$height = $raaDataHelper->getImageHeight();
				
				$imagetype = "small_image";
				if (isset ( $params ['width'] ) && $params ['width']!=null && $params ['width']!="") {
					$width = $params ['width'];
				}
				
				if (isset ( $params ['height'] ) && $params ['height']!=null && $params ['height']!="") {
					$height = $params ['height'];
				}
				
				if (isset ( $params ['imagetype'] ) && $params ['imagetype']!=null && $params ['imagetype']!="") {
					$imagetype = $params ['imagetype'];
				}
				
				
				
				$producCollection = new \Retail\Analytics\Model\Product();
				$data = $producCollection->getProductFinalPrice($lastId,$limit,$imagetype,$width ,$height,$isadmin);
				return $result->setData($data);
			}
		}
		catch ( Exception $e ) {
			return $result->setData($data);
		}
	
	}
}
