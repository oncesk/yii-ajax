<?php
class AjaxEvent extends BaseAjaxAction {

	/**
	 * @var string
	 */
	public $action;

	/**
	 * @var array
	 */
	public $arguments = array();

	public function __construct($action, array $arguments = array()) {
		parent::__construct();
		$this->action = $action;
		$this->arguments = $arguments;
	}


	/**
	 * @return string
	 */
	public function getId() {
		return $this->action;
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		return $this->action;
	}

	/**
	 * @return array
	 */
	public function getAttributes() {
		return array(
			'id' => $this->getId(),
			'attributes' => $this->arguments
		);
	}
}