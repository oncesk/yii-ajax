<?php
abstract class BaseAjaxAction implements IAjaxAction {

	public function __construct() {
		YiiAjax::getAjaxResponse()->addAction($this);
	}

	/**
	 * @return array
	 */
	public function getAttributes() {
		return array(
			'id' => $this->getId(),
			'attributes' => $this->_fetchAttributes()
		);
	}

	/**
	 * @return array
	 */
	protected function _fetchAttributes() {
		$class = new ReflectionClass($this);
		$attributes = array();
		foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
			$attributes[$property->getName()] = $property->getValue($this);
		}
		return $attributes;
	}
}