<?php


namespace Retail\Analytics\Controller\Index;




class RaaProductByDate extends \Magento\Framework\App\Action\Action
{
   
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
			if(isset($params['lastdate']) && isset($params['lastid']) && isset($params['limit']))
			{
				$lastdate = $params['lastdate'];
				$lastId = $params ['lastid'];
				$limit = $params ['limit'];
				$producCollection = new \Retail\Analytics\Model\Product();
				$data = $producCollection->getProductsByDate($lastdate,$lastId,$limit);
				return $result->setData($data);
			}
		}
		catch ( Exception $e ) {
			return $result->setData($data);
		} 
	
	}
}
