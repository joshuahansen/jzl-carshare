<?php
	class Template
	{
		private $head = "modules/head.php";
		private $nav = "modules/nav.php";
		private $footer = "modules/footer.php";
		private $body;

		public function __construct($body)
		{
			$this->body = $body;
		}

		public function display()
		{
            echo "<!DOCTYPE html>";
            echo "<html>";
            require_once($this->head);
            echo "<body>";
            require_once($this->nav);
            require_once($this->body);
            require_once($this->footer);
            echo "</body>";
            echo "</html>";
		}
	}
?>
