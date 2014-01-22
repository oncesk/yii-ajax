<?php
interface IAjaxResponse {

	/**
	 * @param IAjaxAction $action
	 *
	 * @return IAjaxResponse
	 */
	public function addAction(IAjaxAction $action);

	/**
	 * @return mixed
	 */
	public function getArray();
}