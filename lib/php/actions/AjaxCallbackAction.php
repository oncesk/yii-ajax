<?php
class AjaxCallbackAction extends BaseAjaxAction {

	/**
	 * @var string
	 */
	public $callback;

	/**
	 * @var array
	 */
	public $arguments;

	public function __construct($callback, array $arguments = array()) {
		parent::__construct();
		$this->callback = $callback;
		$this->arguments = $arguments;
	}

	/**
	 * @return string
	 */
	public function getId() {
		return 'callback';
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		if ($this->callback && is_string($this->callback)) {
			return true;
		}
		return false;
	}
}