<?php
class AjaxEvent extends BaseAjaxAction {

	/**
	 * @var string
	 */
	public $action;

	/**
	 * @var array
	 */
	public $data = array();

	public function __construct($action, array $data = array()) {
		parent::__construct();
		$this->action = $action;
		$this->data = $data;
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
			'attributes' => $this->data
		);
	}
}