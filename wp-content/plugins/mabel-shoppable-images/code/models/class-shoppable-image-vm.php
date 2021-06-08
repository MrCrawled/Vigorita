<?php

namespace MABEL_SI\Code\Models
{

	use MABEL_SI\Core\Common\Managers\Settings_Manager;

	class Shoppable_Image_VM
	{
		public $show_error;
		public $image;
		public $icon;
		public $size;
		public $button_text;
		public $button_action;
		public $animation;
		public $when_to_open;
		public $tags;

		public function __construct()
		{
			$this->tags = array();
			$this->when_to_open = Settings_Manager::get_setting('popupopen');
			$this->button_text = Settings_Manager::get_setting('buttontext');
			$this->button_action = Settings_Manager::get_setting('buttonaction');
			$this->animation = Settings_Manager::get_setting('taganim');
		}
	}
}