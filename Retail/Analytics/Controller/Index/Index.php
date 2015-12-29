<?php


namespace Retail\Analytics\Controller\Index;




class Index extends \Magento\Framework\App\Action\Action
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

	/**
	 * @return \Magento\Framework\Controller\Result\Json
	 */
	
	public function execute() {
		/** @var \Magento\Framework\Controller\Result\Json $result */
		$result = $this->resultJsonFactory->create();
		$data = array('Message'=>'Called Retail Analytics Index Index.');
		return $result->setData($data);
	}
}
