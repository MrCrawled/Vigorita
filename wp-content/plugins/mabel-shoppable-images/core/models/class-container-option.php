<?php

namespace MABEL_SI\Core\Models
{

	class Container_Option extends Option
	{
		/**
		 * @var Option[] sub-options.
		 */
		public $options;

		public $button_text;

		public $is_closed = true;

		public function __construct($title, $button_text,$extra_info = null,Option_Dependency $dependency = null,$closed = true)
		{
			parent::__construct(uniqid(),null,$title,$extra_info,$dependency);
			$this->options = array();
			$this->is_closed = $closed;
			$this->button_text = $button_text;
		}
	}
}