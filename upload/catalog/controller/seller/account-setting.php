<?php

class ControllerSellerAccountSetting extends ControllerSellerAccount {
	
	public function index() { 
		if($this->MsLoader->MsSetting->ac_settings){
			foreach(array_slice($this->MsLoader->MsSetting->ac_settings, 0, 1) as $first_menu_link => $value){
				$this->response->redirect($this->url->link('seller/account-setting/'.$first_menu_link, '', 'SSL'));
			}
		}
		else{
				$this->response->redirect($this->url->link('seller/account-dashboard', '', 'SSL'));
		}
	}
	
	public function getMenu() {
		$menu = array();
		foreach ($this->MsLoader->MsSetting->ac_settings as $group => $datamass) {
				$menu[] = array(
					'name' => $this->language->get('ms_sellersetting_'.$group.'_menu'),
					'link' => $this->url->link('seller/account-setting/'.$group)
				);
		}
		return $menu;
	}
	
	public function as_main_information() {
		
		$this->document->setTitle($this->language->get(__FUNCTION__ . '_title'));
		$customer_id = $this->customer->getId();

		$this->data['breadcrumbs'] = $this->MsLoader->MsHelper->setBreadcrumbs(array(
			array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/account', '', 'SSL'),
			),
			array(
				'text' => $this->language->get('ms_account_dashboard_breadcrumbs'),
				'href' => $this->url->link('seller/account-dashboard', '', 'SSL'),
			),
			array(
				'text' => $this->language->get(__FUNCTION__ . '_breadcrumbs'),
				'href' => $this->url->link('seller/account-setting/' . __FUNCTION__, '', 'SSL'),
			)
		));
		//Save the data from Form
		if(isset($this->request->post) && $this->request->post){
			$this->MsLoader->MsSetting->setSatting(__FUNCTION__, $this->request->post, $customer_id);
		}
		
		//Get the data for Form
		$this->data['main_enabled'] = $this->MsLoader->MsSetting->getSatting(__FUNCTION__, 'main_enabled', $customer_id);
		$this->data['main_address_city'] = $this->MsLoader->MsSetting->getSatting(__FUNCTION__, 'main_address_city', $customer_id);
		
		$this->data['group_menu'] = $this->getMenu();
		
		list($template, $children) = $this->MsLoader->MsHelper->loadTemplate('multiseller/settings/' . __FUNCTION__);
		$this->response->setOutput($this->load->view($template, array_merge($this->data, $children)));
	}
}
?>
