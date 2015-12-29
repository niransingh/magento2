<?php
namespace Retail\Analytics\Model;


class Product
{
	
	 protected $resourceModel; 
 	 protected $resource;
	 
    public function __construct() 
    {  
    	
    }   

    public function getProductCategory($lastId,$limit)
    {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');    	 
   		$retObj = array ();
		$data = array ();
		$new_lastId = 0;
				
		try {
			
			$data_collection = $productCollection
			->addAttributeToFilter ('entity_id', array ("gt" => $lastId ) )
			->addAttributeToSelect ( "*" )
			->setPageSize($limit);
    	     
    	if (count($data_collection) > 0) {
    		$lastId = $data_collection->getLastItem ()->getId ();    
    		foreach ($data_collection as $product) {       	
    			$productArray = array ();
    			$productArray ['entity_id'] = $product->getId();
    			$productArray ['product_id'] = $product->getId();
    			$productArray ['website_ids'] = $product->getWebsiteIds();
    			$productArray ['store_ids'] = $product->getStoreIds();
    			$productArray ["category_id"] = $this->getProductCategoryId($product);
    			$productArray ["category_ides"] = $product->getCategoryIds();
    			$data[] = $productArray;
    			 
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
    
    
    
    
    public function getProductFinalPrice($lastId, $limit,$imagetype,$width ,$height,$isadmin=false)
    {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
    	 
   		$retObj = array ();
		$data = array ();
		$new_lastId = 0;
		
		try {
			
			$data_collection = $productCollection
			->addAttributeToFilter ('entity_id', array ("gt" => $lastId ) )
			->addAttributeToSelect ( "*" )
			->setPageSize($limit);
    	     
    	if (count($data_collection) > 0) {
    		$lastId = $data_collection->getLastItem ()->getId ();
    		$imagehelper = $objectManager->create('Magento\Catalog\Helper\Image');
    
    		foreach ($data_collection as $product) {
    			 
    			$productArray = array ();
    			$productArray ['entity_id'] = $product->getId();
    			$productArray ['product_id'] = $product->getId();
    			$productArray ['name'] = $product->getName();
    			$productArray ['sku'] = $product->getSku();
    			$productArray ['url'] = $product->getProductUrl ();
    			$productArray ['price'] = $product->getPrice();
    			$productArray ["special_price"] = $product->getFinalPrice();
    			$productArray ["created_at"] = $product->getCreatedAt ();
    			$productArray ["updated_at"] = $product->getUpdatedAt ();
    			$productArray ['imageurl'] = $this->getRaaImageURL($product);
    			$productArray ['cacheimageurl'] = $imagehelper->init($product, 'category_page_grid')->constrainOnly(FALSE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize($height,$width)->getUrl();
    			$productArray ['website_ids'] = $product->getWebsiteIds();
    			$productArray ['store_ids'] = $product->getStoreIds();
    			$productArray ["instock"] = $product->isInStock ();
    			$productArray ["issalable"] = $product->getIsSalable ();
    			$productArray ["visibility"] = $product->getVisibility();
    			$productArray ["status"] = $product->getStatus();
    			$productArray ["quantity"] = $this->getProductPrice($product->getId());
    			$data[] = $productArray;
    			 
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
    
    
    public function getProducts($lastId, $limit)
    {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
    	 
   		$retObj = array ();
		$data = array ();
		$new_lastId = 0;
		try {
			$data_collection = $productCollection
			->addAttributeToFilter ('entity_id', array ("gt" => $lastId ) )
			->addAttributeToSelect ( "*" )
			->setPageSize($limit);
    	     
    	if (count($data_collection) > 0) {
    		$lastId = $data_collection->getLastItem ()->getId ();
    		$imagehelper = $objectManager->create('Magento\Catalog\Helper\Image');
    		$raaDataHelper = $objectManager->create('Retail\Analytics\Helper\Data');
    		$width = $raaDataHelper->getImageWidth();
    		$height = $raaDataHelper->getImageHeight();
    
    		foreach ($data_collection as $product) {
    			 
    			$productArray = array ();
    			$productArray ['entity_id'] = $product->getId();
    			$productArray ['product_id'] = $product->getId();
    			$productArray ['name'] = $product->getName();
    			$productArray ['sku'] = $product->getSku();
    			$productArray ['url'] = $product->getProductUrl ();
    			$productArray ['price'] = $product->getPrice();
    			$productArray ["special_price"] = $product->getFinalPrice();
    			$productArray ["created_at"] = $product->getCreatedAt ();
    			$productArray ["updated_at"] = $product->getUpdatedAt ();
    			$productArray ['imageurl'] = $this->getRaaImageURL($product);
    			$productArray ['cacheimageurl'] = $imagehelper->init($product, 'category_page_grid')->constrainOnly(FALSE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize($height,$width)->getUrl();
    			$productArray ['website_ids'] = $product->getWebsiteIds();
    			$productArray ['store_ids'] = $product->getStoreIds();
    			$productArray ["instock"] = $product->isInStock ();
    			$productArray ["issalable"] = $product->getIsSalable ();
    			$productArray ["visibility"] = $product->getVisibility();
    			$productArray ["status"] = $product->getStatus();
    			$productArray ["category_id"] = $this->getProductCategoryId($product);
    			$productArray ["category_ides"] = $product->getCategoryIds();
    			$productArray ["quantity"] = $this->getProductPrice($product->getId());
    			$data[] = $productArray;
    			 
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
    
    public function getProductsByDate($lastdate,$lastid,$limit)
    {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
    
    	$retObj = array ();
    	$data = array ();
    	$new_lastId = 0;
    	$RowCount = 0;
    	try {
    	
    		$data_collection = $productCollection;
    			
    		if($lastid==0)
    		{
    			$data_collection = $data_collection
    			->addAttributeToFilter('updated_at', array('gteq' => $lastdate))
    			->addAttributeToFilter('entity_id', array('gt' => $lastid))
    			->addAttributeToSelect ( "*" )
    			->addAttributeToSort("updated_at","ASC")
    			->addAttributeToSort("entity_id","ASC")
    			->setPageSize($limit);
    			$RowCount = $data_collection->count ();
    	
    		}
    		else
    		{
    	
    			$RowCount = $data_collection
    			->addAttributeToFilter('updated_at', array('eq' => $lastdate))
    			->addAttributeToFilter('entity_id', array('gt' => $lastid))
    			->count ();
    			$data_collection = $data_collection->addAttributeToFilter('updated_at', array('eq' => $lastdate))
    			->addAttributeToFilter('entity_id', array('gt' => $lastid))
    			->addAttributeToSelect ( "*" )
    			->addAttributeToSort("entity_id","ASC")
    			->setPageSize($limit);
    	
    		}
    
    	if ($data_collection->count() > 0) {
    		$lastdatesend = $data_collection->getLastItem ()->getUpdatedAt();
    		$lastidsend=$data_collection->getLastItem()->getId();
    		
    		$imagehelper = $objectManager->create('Magento\Catalog\Helper\Image');
    		$raaDataHelper = $objectManager->create('Retail\Analytics\Helper\Data');
    		$width = $raaDataHelper->getImageWidth();
    		$height = $raaDataHelper->getImageHeight();
    
    		foreach ($data_collection as $product) {
    
    			$productArray = array ();
    			$productArray ['entity_id'] = $product->getId();
    			$productArray ['product_id'] = $product->getId();
    			$productArray ['name'] = $product->getName();
    			$productArray ['sku'] = $product->getSku();
    			$productArray ['url'] = $product->getProductUrl ();
    			$productArray ['price'] = $product->getPrice();
    			$productArray ["special_price"] = $product->getFinalPrice();
    			$productArray ["created_at"] = $product->getCreatedAt ();
    			$productArray ["updated_at"] = $product->getUpdatedAt ();
    			$productArray ['imageurl'] = $this->getRaaImageURL($product);
    			$productArray ['cacheimageurl'] = $imagehelper->init($product, 'category_page_grid')->constrainOnly(FALSE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize($height,$width)->getUrl();
    			$productArray ['website_ids'] = $product->getWebsiteIds();
    			$productArray ['store_ids'] = $product->getStoreIds();
    			$productArray ["instock"] = $product->isInStock ();
    			$productArray ["issalable"] = $product->getIsSalable ();
    			$productArray ["visibility"] = $product->getVisibility();
    			$productArray ["status"] = $product->getStatus();
    			$productArray ["category_id"] = $this->getProductCategoryId($product);
    			$productArray ["category_ides"] = $product->getCategoryIds();
    			$productArray ["quantity"] = $this->getProductPrice($product->getId());
    			$data[] = $productArray;
    
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
    
    public function getProductPrice($productid)
    {	
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    	$this->resource = $objectManager->create('Magento\Framework\App\ResourceConnection');
    	$this->resourceModel = $objectManager->create('Magento\Framework\App\ResourceConnection');
    	$connection = $this->resource->getConnection();
      	$select = $connection->select()->from($this->resourceModel->getTableName('cataloginventory_stock_item'), 'qty')
      	->where(
            'product_id = :product_id'
        );
      	      	
      	$bind = ['product_id' => $productid];      	
      	return $connection->fetchOne($select, $bind);    	
    }
    
    public function getRaaImageURL($product)
    {    	
    	$SmallImage =  $product->getSmallImage();
    	if($SmallImage == null || $SmallImage == "" || $SmallImage == 'no_selection' )
    	{
    		$Image = $product->getImage();
    		$thumnailImage = $product->getThumbnail();
    		if($Image!=null && $Image!="" && $Image != 'no_selection')
    			return $product->getMediaConfig()->getMediaUrl($Image);
    		else if($thumnailImage!=null && $thumnailImage!="" && $thumnailImage != 'no_selection')
    			return $product->getMediaConfig()->getMediaUrl($thumnailImage);
    		else
    			return  $product->getImageUrl();
    	}
    	else
    	{
    		return $product->getMediaConfig()->getMediaUrl($SmallImage);
    	}
    }
    
}
