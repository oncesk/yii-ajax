<?php
interface IAjaxAction {

	/**
	 * @return string
	 */
	public function getId();

	/**
	 * @return boolean
	 */
	public function isValid();

	/**
	 * @return array
	 */
	public function getAttributes();
}