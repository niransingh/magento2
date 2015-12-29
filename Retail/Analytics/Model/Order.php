<?php
namespace Retail\Analytics\Model;

use Magento\Framework\App\ResourceConnection;

class Order
{
	
	 protected $resourceModel; 
 	 protected $resource;
	 
    public function __construct() 
    {  
    	
    }   

    public function getOrdersByDate($lastdate,$lastid,$limit)
    {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$orderCollection = $objectManager->create('Magento\Sales\Model\ResourceModel\Order\Collection');
    
    	$retObj = array ();
		$data = array ();
		$new_lastId = 0;
		$RowCount = 0;
		try {				
			$data_collection = $orderCollection;
			if($lastid==0)
			{
				$data_collection = $data_collection->addAttributeToFilter('updated_at', array('gteq' => $lastdate))
				->addAttributeToFilter('entity_id', array('gt' => $lastid))
				->addAttributeToSelect ( "*" )
				->addAttributeToSort("updated_at","ASC")
				->addAttributeToSort("entity_id","ASC")
				->setPageSize($limit);
				$RowCount = $data_collection->count ();
					
			}
			else
			{
				$RowCount = $orderCollection
				->addAttributeToFilter('updated_at', array('eq' => $lastdate))
				->addAttributeToFilter('entity_id', array('gt' => $lastid))
				->count ();
				$data_collection = $data_collection->addAttributeToFilter('updated_at', array('eq' => $lastdate))
				->addAttributeToFilter('entity_id', array('gt' => $lastid))
				->addAttributeToSelect ( "*" )
				->addAttributeToSort("entity_id","ASC")
				->setPageSize($limit);;
			}
	
			if ($data_collection->count () > 0) {
				$lastdatesend = $data_collection->getLastItem ()->getUpdatedAt();
				$lastidsend=$data_collection->getLastItem()->getId();
	
				foreach ( $data_collection as $order ) {
	
					$items = $order->getAllItems ();
					foreach ( $items as $item ) {
    				$orderArray = array ();
    
    				$orderArray ['entity_id'] = $order->getData ( 'entity_id' );
    				$orderArray ['order_id'] = $order->getData ( 'entity_id' );
    				$orderArray ['created_at'] = $order->getData ( 'created_at' );
    				$orderArray ['updated_at'] = $order->getData ( 'updated_at' );
    				$orderArray ['status'] = $order->getData ( 'status' );
    				$orderArray ['store_id'] = $order->getData ( 'store_id' );
    
    				$orderArray ['increment_id'] = $order->getData ( 'increment_id' );
    				$orderArray ['subtotal'] = $order->getData ( 'subtotal' );
    				$orderArray ['base_subtotal'] = $order->getData ( 'base_subtotal' );
    				$orderArray ['grand_total'] = $order->getData ( 'grand_total' );
    				$orderArray ['base_grand_total'] = $order->getData ( 'base_grand_total' );
    				$orderArray ['payment_method'] = $order->getPayment()->getData('method');
    				$orderArray ['coupon_code'] = $order->getData ( 'coupon_code' );
    
    				$orderArray ['customer_id'] = $order->getData ( 'customer_id' );
    				$orderArray ['email'] = $order->getData ( 'customer_email' );
    				$orderArray ['customer_firstname'] = $order->getData ( 'customer_firstname' );
    				$orderArray ['customer_middlename'] = $order->getData ( 'customer_middlename' );
    				$orderArray ['customer_lastname'] = $order->getData ( 'customer_lastname' );
    				$orderArray ['customer_dob'] = $order->getData ( 'customer_dob' );
    				$orderArray ['customer_group_id'] = $order->getData ( 'customer_group_id' );
    				$orderArray ['customer_is_guest'] = $order->getData ( 'customer_is_guest' );
    				$orderArray ['customer_prefix'] = $order->getData ( 'customer_prefix' );
    				$orderArray ['customer_suffix'] = $order->getData ( 'customer_suffix' );
    				$orderArray ['customer_taxvat'] = $order->getData ( 'customer_taxvat' );
    				$orderArray ['customer_note'] = $order->getData ( 'customer_note' );
    					
    				$orderArray ['global_currency_code']=$order->getData ( 'global_currency_code' );
    				$orderArray ['base_currency_code']=$order->getData ( 'base_currency_code' );
    				$orderArray ['order_currency_code']=$order->getData ( 'order_currency_code' );
    				$orderArray ['store_currency_code']=$order->getData ( 'store_currency_code' );
    
    				$orderArray ['product_id'] = $item->getData ( 'product_id' );
    				$orderArray ['sku'] = $item->getData ( 'sku' );
    				$orderArray ['quantity'] = $item->getData ( 'qty_ordered' );
    				$orderArray ['price'] = $item->getData ( 'price_incl_tax' );
    				$orderArray ['discount'] = $item->getData ( 'discount_amount' );
    				$orderArray ['base_price']=$item->getData ( 'base_price' );
    				$orderArray ['base_discount']=  $item->getData ( 'base_discount_amount' );
    				$orderArray ['original_price']=$item->getData ( 'original_price' );
    				$orderArray ['base_original_price']=$item->getData ( 'base_original_price' );
    
    				$this->getProductCategory($item->getData ( 'product_id' ),$orderArray);
    
    				$billingAddress = json_encode($order->getBillingAddress()->getData());
    				$shippingAddress = json_encode($order->getShippingAddress()->getData());
    				$orderArray ['billing_address'] = json_decode($billingAddress);
    				$orderArray ['shipping_address'] = json_decode($shippingAddress);
    
    				$data[] = $orderArray;
    			}
    		}
			$retObj ['data'] = $data;
				$retObj ['lastdate'] = $lastdatesend;
				if($lastdate != $lastdatesend  )
				{
					$lastidsend=0;
				}
				else if($RowCount<$limit)
				{
					$lastidsend=0;
					$duration = 1;
					$dateinsec = strtotime($lastdatesend);
					$lastdatesend = $dateinsec+$duration;
					$lastdatesend = date('Y-m-d H:i:s',$lastdatesend);
					$retObj ['lastdate'] = $lastdatesend;
				}
				$retObj ['lastid'] = $lastidsend;
				if ($data_collection->count () < $limit && $lastid==0)
				{
					$retObj ['islast'] = true;
				}
				else
				{
					$retObj ['islast'] = false;
				}
			} else {
				$duration = 1;
				$dateinsec = strtotime($lastdate);
				$lastdatesend = $dateinsec+$duration;
				$lastdatesend = date('Y-m-d H:i:s',$lastdatesend);
				$retObj ['lastdate'] = $lastdatesend;
				$retObj ['lastid'] = 0;
				if($lastid>0)
				{
					$retObj ['islast'] = false;
				}
				else
					$retObj ['islast'] = true;
				$retObj ['data'] = $data;
			}
	
			return $retObj;
		} catch ( Exception $e ) {
	
			$retObj ['lastdate'] = $lastdate;
			$retObj ['islast'] = false;
			$retObj ['data'] = $data;
			return $retObj;
		}
    }
    
    
    
    public function getOrders($lastId,$limit)
    {    	
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$orderCollection = $objectManager->create('Magento\Sales\Model\ResourceModel\Order\Collection');
    	$retObj = array ();
    	$data = array ();
    	$new_lastId = 0;
    	
    	try {
    			
    		$data_collection = $orderCollection
    		->addAttributeToFilter ('entity_id', array ("gt" => $lastId ) )
    		->addAttributeToSelect ( "*" )
    		->setPageSize($limit);
    	
    		if (count($data_collection) > 0) {
    			$lastId = $data_collection->getLastItem ()->getId ();
    			foreach ($data_collection as $order) {    
    
	    			$items = $order->getAllItems ();    			
	    			foreach ( $items as $item ) {
	    				$orderArray = array ();
	    				
	    			 	$orderArray ['entity_id'] = $order->getData ( 'entity_id' );
	    				$orderArray ['order_id'] = $order->getData ( 'entity_id' );
	    				$orderArray ['created_at'] = $order->getData ( 'created_at' );
	    				$orderArray ['updated_at'] = $order->getData ( 'updated_at' );
	    				$orderArray ['status'] = $order->getData ( 'status' );
	    				$orderArray ['store_id'] = $order->getData ( 'store_id' );
	    				
	    				$orderArray ['increment_id'] = $order->getData ( 'increment_id' );
	    				$orderArray ['subtotal'] = $order->getData ( 'subtotal' );
	    				$orderArray ['base_subtotal'] = $order->getData ( 'base_subtotal' );
	    				$orderArray ['grand_total'] = $order->getData ( 'grand_total' );
	    				$orderArray ['base_grand_total'] = $order->getData ( 'base_grand_total' );
	    				$orderArray ['payment_method'] = $order->getPayment()->getData('method');
	    				$orderArray ['coupon_code'] = $order->getData ( 'coupon_code' ); 
	    				
	    				$orderArray ['customer_id'] = $order->getData ( 'customer_id' );
	    				$orderArray ['email'] = $order->getData ( 'customer_email' );
	    				$orderArray ['customer_firstname'] = $order->getData ( 'customer_firstname' );
	    				$orderArray ['customer_middlename'] = $order->getData ( 'customer_middlename' );
	    				$orderArray ['customer_lastname'] = $order->getData ( 'customer_lastname' );
	    				$orderArray ['customer_dob'] = $order->getData ( 'customer_dob' );
	    				$orderArray ['customer_group_id'] = $order->getData ( 'customer_group_id' );
	    				$orderArray ['customer_is_guest'] = $order->getData ( 'customer_is_guest' );
	    				$orderArray ['customer_prefix'] = $order->getData ( 'customer_prefix' );
	    				$orderArray ['customer_suffix'] = $order->getData ( 'customer_suffix' );
	    				$orderArray ['customer_taxvat'] = $order->getData ( 'customer_taxvat' );
	    				$orderArray ['customer_note'] = $order->getData ( 'customer_note' );
	    				 
	    				$orderArray ['global_currency_code']=$order->getData ( 'global_currency_code' );
	    				$orderArray ['base_currency_code']=$order->getData ( 'base_currency_code' );
	    				$orderArray ['order_currency_code']=$order->getData ( 'order_currency_code' );
	    				$orderArray ['store_currency_code']=$order->getData ( 'store_currency_code' );
	    				
	    				$orderArray ['product_id'] = $item->getData ( 'product_id' );
	    				$orderArray ['sku'] = $item->getData ( 'sku' );
	    				$orderArray ['quantity'] = $item->getData ( 'qty_ordered' );
	    				$orderArray ['price'] = $item->getData ( 'price_incl_tax' );
	    				$orderArray ['discount'] = $item->getData ( 'discount_amount' );
	    				$orderArray ['base_price']=$item->getData ( 'base_price' );
	    				$orderArray ['base_discount']=  $item->getData ( 'base_discount_amount' );
	    				$orderArray ['original_price']=$item->getData ( 'original_price' );
	    				$orderArray ['base_original_price']=$item->getData ( 'base_original_price' );
	    				
	    				$this->getProductCategory($item->getData ( 'product_id' ),$orderArray);
	    				    				
	    				$billingAddress = json_encode($order->getBillingAddress()->getData());
	    				$shippingAddress = json_encode($order->getShippingAddress()->getData());
	    				$orderArray ['billing_address'] = json_decode($billingAddress);
	    				$orderArray ['shipping_address'] = json_decode($shippingAddress);
	    				
	    				$data[] = $orderArray;
	    			 }
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

	public function getProductCategory($productid,$orderArray)
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
		$data_collection = $productCollection
    	->addAttributeToSelect ( "*" )    
    	->addAttributeToFilter('entity_id', array('eq' => $productid))
		->setPageSize(1);
		
		if (count($data_collection) > 0) {		
			foreach ($data_collection as $product) {
				
				$orderArray ["category_ides"] = $product->getCategoryIds();
				$orderArray ["category_id"] = $this->getProductCategoryId($product);
			}
		}
	}

	public function getProductCategoryId($product)
	{
	
		if(!$product->getCategoryId())
		{
			$categoryIds = $product->getCategoryIds();
			if(count($categoryIds) > 0)
			{
				return $categoryIds[0];
			}
		}
		 
	}
	
}


