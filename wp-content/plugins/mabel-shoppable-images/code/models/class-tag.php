<?php
namespace MABEL_SI\Code\Models
{

	class Tag
	{
		public $posX;
		public $posY;
		public $product_id;
		public $title;
		public $price;
		public $link;
		public $thumb;
		public $is_variation;

		public function __construct($x, $y, $pid = null)
		{
			$this->is_variation = false;
			$this->posX = $x;
			$this->posY = $y;
			$this->product_id = $pid;
		}
	}

}
