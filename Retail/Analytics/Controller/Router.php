<?php
namespace Retail\Analytics\Controller;
 
/**
 * Inchoo Custom router Controller Router
 *
 * @author      Zoran Salamun <zoran.salamun@inchoo.net>
 */
class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;
 
    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;
 
    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
    }
 
    /**
     * Validate and Match
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
      
        $identifier = trim($request->getPathInfo(), '/');
        $identifier = strtolower($identifier);
        
        if(strpos($identifier, 'raacustomer') !== false) {
        	/*
        	 * We must set module, controller path and action name for our controller class(Controller/Test/Test.php)
        	*/
            $request->setModuleName('raanalytics')->setControllerName('index')->setActionName('raacustomer');
            
        } else if(strpos($identifier, 'raaproduct') !== false) {    
        	       
            $request->setModuleName('raanalytics')->setControllerName('index')->setActionName('raaproduct');
            
        } else if(strpos($identifier, 'raaproductbydate') !== false) {    
        	       
            $request->setModuleName('raanalytics')->setControllerName('index')->setActionName('raaproductbydate');
            
        } else if(strpos($identifier, 'raaproductcategory') !== false) {    
        	       
            $request->setModuleName('raanalytics')->setControllerName('index')->setActionName('raaproductcategory');
            
        } else if(strpos($identifier, 'raaproductfinalprice') !== false) {    
        	       
            $request->setModuleName('raanalytics')->setControllerName('index')->setActionName('raaproductfinalprice');
            
        } else if(strpos($identifier, 'raaorder') !== false) {    
        	       
            $request->setModuleName('raanalytics')->setControllerName('index')->setActionName('raaorder');
            
        } else if(strpos($identifier, 'raaorderbydate') !== false) {    
        	       
            $request->setModuleName('raanalytics')->setControllerName('index')->setActionName('raaorderbydate');
            
        } else if(strpos($identifier, 'raanalytics') !== false) {  
        	        	
        	$request->setModuleName('raanalytics')->setControllerName('index')->setActionName('index');
        	
        } else {
            //There is no match
            return;
        }
 
        /*
         * We have match and now we will forward action
         */
        return $this->actionFactory->create('Magento\Framework\App\Action\Forward',['request' => $request]);
    }
}