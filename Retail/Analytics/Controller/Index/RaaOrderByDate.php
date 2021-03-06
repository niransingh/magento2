<?php


namespace Retail\Analytics\Controller\Index;




class RaaOrderByDate extends \Magento\Framework\App\Action\Action
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
			if(isset($params['lastdate']) && isset($params['lastid']) && isset($params['limit']))
			{
				$lastdate = $params['lastdate'];
				$lastid = $params ['lastid'];
				$limit = $params ['limit'];
				$orderCollection = new \Retail\Analytics\Model\Order();			
				$data = $orderCollection->getOrdersByDate($lastdate,$lastid,$limit);
				return $result->setData($data);
			}
		}
		catch ( Exception $e ) {
			return $result->setData($data);
		}
		
		
	}
}
