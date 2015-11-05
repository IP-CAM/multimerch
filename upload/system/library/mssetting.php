<?php
final class MsSetting extends Model {

	var $ac_settings = array(
		"as_main_information" => array(
			"tax_enabled" => 1,
			"tax_rate" => "21.00",
			"tax_address_city" => "London",
			"tax_address_street" => "1 Main St."
		),
		"as_tax" => array(
			"tax_enabled" => 1,
			"tax_rate" => "21.00",
			"tax_address_city" => "London",
			"tax_address_street" => "1 Main St."
		),
		"as_holiday" => array(
			"holiday_enable" => 0,
			"holiday_exclude_products_id" => array(1,51,1271)
		)
	);
	
	public function __construct($registry) {
		parent::__construct($registry);
	}
	
	public function setDefoult() {
		
		$customer_id = $this->customer->getId();
		foreach ($this->ac_settings as $name => $mass) {
			foreach ($mass as $setting => $value){
				if(is_array($value)){
					//echo '<pre>'; print_r(serialize($value)); echo '</pre>';
					$this->db->query("INSERT INTO `" . DB_PREFIX . "ms_settings` SET `seller_id` = '" . (int)$customer_id . "', `group` = '" . $name . "', `name` = '" . $setting . "', `value` = '" . serialize($value) . "', `serialized` = '1'");
				}
				else{
					$this->db->query("INSERT INTO `" . DB_PREFIX . "ms_settings` SET `seller_id` = '" . (int)$customer_id . "', `group` = '" . $name . "', `name` = '" . $setting . "', `value` = '" . $value . "', `serialized` = '0'");
				}
			}
			
			
		}
	}
}

?>
