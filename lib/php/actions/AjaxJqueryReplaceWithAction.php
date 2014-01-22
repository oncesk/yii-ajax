<?php
class AjaxJqueryReplaceWithAction extends BaseAjaxAction {

	public $selector;
	public $html;

	/**
	 * @param string $selector
	 * @param string $html
	 */
	public function __construct($selector, $html = null) {
		parent::__construct();
		$this->selector = $selector;
		$this->html = $html;
	}

	/**
	 * @return string
	 */
	public function getId() {
		return 'jquery.replace';
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		if ($this->selector && is_string($this->selector)) {
			if (!is_string($this->html)) {
				$this->html = '';
			}
			return true;
		}
		return false;
	}
}