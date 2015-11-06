<?php
final class MsSetting extends Model {

	var $ac_settings = array(
		"as_main_information" => array(
			"main_enabled" => 1,
			"main_address_city" => "London"
		)	
	);
	
	public function __construct($registry) {
		parent::__construct($registry);
	}
	
	public function setDefoult() {
		
		$customer_id = $this->customer->getId();
		$sql = "SELECT id FROM `" . DB_PREFIX . "ms_settings` st WHERE st.seller_id = '" . (int)$customer_id . "'";
		$res = $this->db->query($sql);
		if($res->num_rows == 0){		
			foreach ($this->ac_settings as $name => $mass) {
				foreach ($mass as $setting => $value){
					if(is_array($value)){
						$this->db->query("INSERT INTO `" . DB_PREFIX . "ms_settings` SET `seller_id` = '" . (int)$customer_id . "', `group` = '" . $name . "', `name` = '" . $setting . "', `value` = '" . serialize($value) . "', `serialized` = '1'");
					}
					else{
						$this->db->query("INSERT INTO `" . DB_PREFIX . "ms_settings` SET `seller_id` = '" . (int)$customer_id . "', `group` = '" . $name . "', `name` = '" . $setting . "', `value` = '" . $value . "', `serialized` = '0'");
					}
				}
			}
		}
	}
	
	public function getSatting($group, $setting, $customer_id) {

		$sql = "SELECT value, serialized FROM `" . DB_PREFIX . "ms_settings` st WHERE st.seller_id = '" . (int)$customer_id . "' AND st.group = '" . $this->db->escape($group) . "' AND  st.name = '" . $this->db->escape($setting) . "'";
		$res = $this->db->query($sql);
		if($res->num_rows != 0){
			if($res->row['serialized'] == 1){
				return unserialize($res->row['value']);
			}
			return $res->row['value'];	
		}
		else{
			return false;
		}
	}
	
	public function setSatting($group, $mass_setting, $customer_id) {
		foreach ($mass_setting as $key => $value) {
			$sql = "SELECT id FROM `" . DB_PREFIX . "ms_settings` st WHERE st.seller_id = '" . (int)$customer_id . "' AND st.group = '" . $this->db->escape($group) . "' AND  st.name = '" . $this->db->escape($key) . "' LIMIT 1";
			$res = $this->db->query($sql);
			$new_value = is_array($value)?serialize($value):$value;
			$serrialize = is_array($value)?1:0;
			if($res->num_rows != 0){
				$sql1 = "UPDATE " . DB_PREFIX . "ms_settings SET value =  '" . $new_value . "' WHERE id = " . (int)$res->row['id'];
				$res = $this->db->query($sql1);
			}
			else{
				$this->db->query("INSERT INTO `" . DB_PREFIX . "ms_settings` SET `seller_id` = '" . (int)$customer_id . "', `group` = '" . $this->db->escape($group) . "', `name` = '" . $this->db->escape($key) . "', `value` = '" . $new_value . "', `serialized` = '". $serrialize ."'");
			}
		}
	}
}

?>
