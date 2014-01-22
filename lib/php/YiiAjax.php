<?php
class YiiAjax extends CApplicationComponent {

	/**
	 * @var bool
	 */
	public $applyBeforeSuccessCallback = true;

	/**
	 * @var bool
	 */
	public $applyOnlyOnSuccess = true;

	/**
	 * @var array
	 */
	public $ajaxResponse = array(
		'class' => 'AjaxResponse'
	);

	/**
	 * @var IAjaxResponse
	 */
	protected static $_ajaxResponse;

	/**
	 * @var AjaxResponseValidator
	 */
	protected $_ajaxResponseValidator;

	/**
	 * @return IAjaxResponse
	 * @throws CException
	 */
	public static function getAjaxResponse() {
		if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
			throw new CException('AjaxRequest can exists only if HTTP request was made with XMLHTTPRequest');
		}
		return self::$_ajaxResponse;
	}

	public function init() {
		parent::init();
		Yii::app()->getRequest()->getIsAjaxRequest() ? $this->initAjaxRequest() : $this->initHTTPRequest();
	}

	public function initAjaxRequest() {
		if (!Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getParam('isYiiAjax')) {
			return;
		}
		Yii::app()->attachEventHandler('onEndRequest', array($this, 'onEndRequest'));
		self::$_ajaxResponse = Yii::createComponent($this->ajaxResponse);
		if (!(self::$_ajaxResponse instanceof IAjaxResponse)) {
			throw new CException('AjaxResponse object should implements IAjaxResponse');
		}
	}

	public function initHTTPRequest() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			return;
		}
	}

	public function detachEndRequestEventHandler() {
		Yii::app()->detachEventHandler('onEndRequest', array($this, 'onEndRequest'));
	}

	/**
	 * @return AjaxResponseValidator
	 */
	public function getAjaxResponseValidator() {
		if ($this->_ajaxResponseValidator) {
			return $this->_ajaxResponseValidator;
		}
		return $this->_ajaxResponseValidator = new AjaxResponseValidator();
	}

	/**
	 * called before end request
	 */
	public function onEndRequest() {
		$response = self::getAjaxResponse()->getArray();
		if ($this->getAjaxResponseValidator()->validate($response)) {
			echo json_encode($response);
		}
	}
}