<?php
class AjaxResponseValidator {

	public function validate(array $response = array()) {
		if (empty($response)) {
			return false;
		}
		if (!isset($response['actions'])) {
			return false;
		}
		return true;
	}
}