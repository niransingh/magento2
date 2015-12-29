<?php
namespace Retail\Analytics\Model;


class Customer
{
	
	
	 
    public function __construct() 
    {  
    	
    }   

    
    public function getCustomers($lastId, $limit)
    {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$customerCollection = $objectManager->create('Magento\Customer\Model\ResourceModel\Customer\Collection');
    	    	
    
		$retObj = array ();
		$data = array ();
		$new_lastId = 0;
		try {
			$data_collection = $customerCollection
			->addAttributeToFilter ('entity_id', array ("gt" => $lastId ) )
			->addAttributeToSelect ( "*" )
			->setPageSize($limit);
			
			if ($data_collection->count () > 0) {
				$lastId = $data_collection->getLastItem ()->getId ();
				foreach ( $data_collection as $customer ) {
					$customerArray = array ();
					$customerArray ['entity_id'] = $customer->getData ( 'entity_id' );
					$customerArray ['customer_id'] = $customer->getData ( 'entity_id' );
					$customerArray ['firstname'] = $customer->getData ( 'firstname' );
					$customerArray ['lastname'] = $customer->getData ( 'lastname' );
					$customerArray ['email'] = $customer->getData ( 'email' );
					$customerArray ['phone'] = $customer->getData ( 'phone' );
					$customerArray ['group_id'] = $customer->getData ( 'group_id' );
					$customerArray ['created_at'] = $customer->getData ( 'created_at' );
					$customerArray ['updated_at'] = $customer->getData ( 'updated_at' );
					$customerArray ['website_id'] = $customer->getData ( 'website_id' );
					$data [] = $customerArray;
				}
				
				$retObj ['data'] = $data;
				$retObj ['lastid'] = $lastId;
				if ($data_collection->count () < $limit) {
					$retObj ['islast'] = true;
				} else {
					$retObj ['islast'] = false;
				}
			} else {
				$retObj ['lastid'] = $lastId;
				$retObj ['islast'] = true;
				$retObj ['data'] = $data;
			}
			
			return $retObj;
		} catch ( Exception $e ) {
			
			$retObj ['lastid'] = - 1;
			$retObj ['islast'] = false;
			$retObj ['data'] = $data;
			return $retObj;
		}
	
    }
    
   
    
}
