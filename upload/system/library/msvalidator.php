<?php

class MsValidator {

	public function validate(array $input, array $ruleset)
	{
		$this->errors = array();

		foreach ($ruleset as $key => $item) {
			$rules = explode('|', $item['rule']);

			foreach ($rules as $rule) {
				$method = null;
				$param = null;
				$error_message = null;

				if (strstr($rule, ',') !== false) {
					$rule   = explode(',', $rule);
					$method = 'validate_'.$rule[0];
					$param  = $rule[1];
					$rule   = $rule[0];
				} else {
					$method = 'validate_'.$rule;
					if (isset($item['error_message'])) {
						$error_message = $item['error_message'];
					}
				}

				if (is_callable(array($this, $method))) {
					$result = $this->$method($input, $param, $error_message);
					if (is_array($result)) {
						$this->errors[] = $result;
					}
				} else {
					throw new Exception("Validator method '$method' does not exist.");
				}
			}
		}
		return (count($this->errors) > 0) ? $this->errors : true;
	}

	public function get_errors()
	{
		$response = array();

		foreach ($this->errors as $e) {
			switch ($e['rule']) {
				case 'validate_required' :
					$default_message = "The '" . $e['field'] . "' field is required";
					break;
				case 'validate_alpha_numeric':
					$default_message = "The '" . $e['field'] . "' field may only contain alpha-numeric characters";
					break;
				case 'validate_max_len':
					$default_message = "The '" . $e['field'] . "' field needs to be '" . $e['param'] . "' or shorter in length";
					break;
				case 'validate_min_len':
					$default_message = "The '" . $e['field'] . "' field needs to be '" . $e['param'] . "' or longer in length";
					break;
				default:
					$default_message = "The '" . $e['field'] . "' field is invalid";
			}
			$response[] = (isset($e['error_message'])) ? $e['error_message'] : $default_message;
		}
		return $response;
	}

	protected function validate_required($input, $param = null, $message = null)
	{
		if (isset($input['value']) && ($input['value'] === false || $input['value'] === 0 || $input['value'] === 0.0 || $input['value'] === '0' || !empty($input['value']))) {
			return;
		}

		return array(
			'field' => $input['name'],
			'value' => $input['value'],
			'rule' => __FUNCTION__,
			'param' => $param,
		);
	}

	protected function validate_alpha_numeric($input, $param = null, $message = null)
	{
		if (!isset($input['value']) || empty($input['value'])) {
			return;
		}

		if (!preg_match('/^([a-z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+$/i', $input['value']) !== false) {
			return array(
				'field' => $input['name'],
				'value' => $input['value'],
				'rule' => __FUNCTION__,
				'param' => $param,
				'error_message' => $message
			);
		}
	}

	protected function validate_max_len($input, $param = null, $message = null)
	{
		if (!isset($input['value'])) {
			return;
		}

		if (function_exists('mb_strlen')) {
			if (mb_strlen($input['value']) <= (int) $param) {
				return;
			}
		} else {
			if (strlen($input['value']) <= (int) $param) {
				return;
			}
		}

		return array(
			'field' => $input['name'],
			'value' => $input['value'],
			'rule' => __FUNCTION__,
			'param' => $param,
			'error_message' => $message
		);
	}

	protected function validate_min_len($input, $param = null, $message = null)
	{
		if (!isset($input['value'])) {
			return;
		}

		if (function_exists('mb_strlen')) {
			if (mb_strlen($input['value']) >= (int) $param) {
				return;
			}
		} else {
			if (strlen($input['value']) >= (int) $param) {
				return;
			}
		}

		return array(
			'field' => $input['name'],
			'value' => $input['value'],
			'rule' => __FUNCTION__,
			'param' => $param,
			'error_message' => $message
		);
	}
}

$validator = new MsValidator();

$field = array(
	'name' => 'password',
	// 'value' => 'paSSworD2016' // valid
	'value' => 'p@SSworD+2016-test_pAss' // invalid
);

$ruleset = array(
	array('rule' => 'required', 'error_message' => "Please fill '" . $field['name'] . "' field."),
	array('rule' => 'max_len,15|min_len,6'),
	array('rule' => 'alpha_numeric', 'error_message' => "Field '" . $field['name'] . "' must be only alpha-numeric characters")
);

$is_valid = $validator->validate($field, $ruleset);

if($is_valid === true) {
	echo "The field is valid";
} else {
	print_r($validator->get_errors());
}
die();
