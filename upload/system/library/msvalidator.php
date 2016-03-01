<?php

class MsValidator {
	
	private $validation_rules = array();
	private $field;
	private $phone_reg = "/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/";
	public $errors = array();

	public function addField($field) {
		$this->field = $field;
		if(is_array($this->field['value'])) {
			$this->field['is_array'] = true;
		} else {
			$this->field['is_array'] = false;
		}
		
		return $this;
	}
	
	//validator chains
	public function between($min, $max) {
		if(!$this->field['is_array']) {
			$length = strlen($this->field['value']);
			if(($length < $min) || ($length > $max)) {
				$this->errors[$this->field['name']][] = 'Length is less or more!';
			}
		} else {
			$count = count($this->field['value']);
			if($count > $max || $count < $min) {
				$this->errors[$this->field['name']][] = "Amount of elements is less or more";
			}
		}
		
		return $this;
	}
	
	public function required() {
		if(!isset($this->field['value']) || empty($this->field['value'])) {
			$this->errors[$this->field['name']][] = 'Field is empty!';
		}
		
		return $this;
	}
	
	public function alphaNumeric() {
		if(count($this->errors) == 0) {
			if(!$this->field['is_array']) {
				if (!ctype_alnum($this->field['value'])) {
					$this->errors[$this->field['name']][] = 'Field is not alphanumeric';
				}
			}
		}
		
		return $this;
	}
	
	public function isNumeric() {
		if(count($this->errors) == 0) {
			if (!$this->field['is_array']) {
				if (!is_numeric($this->field['value'])) {
					$this->errors[$this->field['name']][] = 'Is not a number!';
				}
			}
		}
		
		return $this;
	}
	
	public function isPhone() {
		if(count($this->errors) == 0) {
			if (!$this->field['is_array']) {
				if (!preg_match($this->phone_reg, $this->field['value'])) {
					$this->errors[$this->field['name']][] = 'Not a phone number';
				}
			}
		}
		
		return $this;
	}
	
	public function minLength($min) {
		if(count($this->errors) == 0) {
			if(!$this->field['is_array']) {
				$length = strlen($this->field['value']);
				if ($length < $min) {
					$this->errors[$this->field['name']][] = 'Field is less then ' . $min;
				}
			} else {
				$count = count($this->field['value']);
				if($count > $min) {
					$this->errors[$this->field['name']][] = 'Amount of elements is less then ' . $min;
				}
			}
		}
		
		return $this;
	}
	
	public function maxLength($max) {
		if(count($this->errors) == 0) {
			if(!$this->field['is_array']) {
				$length = strlen($this->field['value']);
				if ($length > $max) {
					$this->errors[$this->field['name']][] = 'Field is more then ' . $max;
				}
			} else {
				$count = count($this->field['value']);
				if($count > $max) {
					$this->errors[$this->field['name']][] = 'Amount of elements is more then ' . $max;
				}
			}
		}
		
		return $this;
	}
	
	public function isEmail(){
		if(count($this->errors) == 0) {
			if (!$this->field['is_array']) {
				if (filter_var($this->field['value'], FILTER_VALIDATE_EMAIL) === FALSE) {
					$this->errors[$this->field['name']][] = "Email is invalid!";
				}
			}
		}
		
		return $this;
	}	
}

$validator = new MsValidator();

$field = array
	(
		'name' => 'password',
		'value' => '880-0555-3535'
	);
$validator->addField($field)->required()->between(1,3)->alphaNumeric()->isNumeric()->isPhone()->isEmail();
print_r($validator->errors);
die;

