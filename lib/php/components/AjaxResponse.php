<?php
class AjaxResponse extends CAttributeCollection implements IAjaxResponse {

	/**
	 * @var IAjaxAction[]
	 */
	protected $_actions = array();

	/**
	 * @var array
	 */
	protected $_response = array();

	public function __construct() {
		$this->_response['actions'] = array();
		$this->_response['response'] = array();
	}

	/**
	 * @param IAjaxAction $action
	 *
	 * @return AjaxResponse
	 */
	public function addAction(IAjaxAction $action) {
		$this->_actions[] = $action;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getArray() {
		foreach ($this->_actions as $action) {
			if ($action->isValid()) {
				$this->_response['actions'][] = $action->getAttributes();
			}
		}
		$this->_response['response'] = $this->toArray();
		return $this->_response;
	}
}