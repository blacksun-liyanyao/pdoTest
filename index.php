<?php
/**
* 
*/
class ShopProduct
{
	private $title;
	private $producerMainName;
	private $producerFirstName;
	protected $price = 0;

	public function __construct($title,$firstName,$mainName,$price)
	{
		$this->title = $title;
		$this->producerFirstName = $firstName;
		$this->producerMainName = $mainName;
		$this->price = $price;
	}
	public function getProducerFirstName(){
		return $this->producerFirstName;
	}
	public function getProducerMainName(){
		return $this->producerMainName;
	}
	public function getTitle(){
		return $this->title;
	}
	public function getProducer(){
		return "{$this->producerFirstName}"."{$this->producerMainName}";
	}
	public function getSummaryLine(){
		$base = "{$this->title} ( {$this->producerMainName}, ";
		$base .= "{$this->producerFirstName} )";
		return $base;
	}
}
class CdProduct extends ShopProduct {
	public $playLength;

	public function __construct($title,$firstName,$mainName,$price,$playLength)
	{
		parent::__construct($title,$firstName,$mainName,$price);
		$this->playLength = $playLength;
	}
	public function getPlayLength(){
		return $this->playLength;
	}
	public function getSummaryLine(){
		$base = parent::getSummaryLine();
		$base .= "{$this->price}";
		$base.=": playing time - {$this->playLength}";
		return $base;
	}
} 
$product1 = new CdProduct("haha","li","yanyao",6.03,24);
print "author: {$product1->getSummaryLine()}\n";

?>