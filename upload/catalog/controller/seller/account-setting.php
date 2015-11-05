<?php

class ControllerSellerAccountSetting extends ControllerSellerAccount {
	
	public function index() { 
		$this->document->addScript('catalog/view/javascript/account-seller-setting.js');
		$this->document->addScript('catalog/view/javascript/plupload/plupload.full.js');
		$this->document->addScript('catalog/view/javascript/plupload/jquery.plupload.queue/jquery.plupload.queue.js');

		// rte
		if($this->config->get('msconf_enable_rte')) {
			$this->document->addScript('catalog/view/javascript/multimerch/summernote/summernote.js');
			$this->document->addStyle('catalog/view/javascript/multimerch/summernote/summernote.css');
		}

		$this->load->model('localisation/country');
		$this->data['countries'] = $this->model_localisation_country->getCountries();

		$seller = $this->MsLoader->MsSeller->getSeller($this->customer->getId());

		$this->data['salt'] = $this->MsLoader->MsSeller->getSalt($this->customer->getId());
		$this->data['statusclass'] = 'warning';

		if ($seller) {
			switch ($seller['ms.seller_status']) {
				case MsSeller::STATUS_UNPAID:
				case MsSeller::STATUS_INCOMPLETE:
					$this->data['statusclass'] = 'warning';
					break;
				case MsSeller::STATUS_ACTIVE:
					$this->data['statusclass'] = 'success';
					break;
				case MsSeller::STATUS_DISABLED:
				case MsSeller::STATUS_DELETED:
					$this->data['statusclass'] = 'danger';
					break;
			}

			$this->data['seller'] = $seller;
			unset($this->data['seller']['banner']);
			$this->data['country_id'] = $seller['ms.country_id'];

			if (!empty($seller['ms.avatar'])) {
				$this->data['seller']['avatar']['name'] = $seller['ms.avatar'];
				$this->data['seller']['avatar']['thumb'] = $this->MsLoader->MsFile->resizeImage($seller['ms.avatar'], $this->config->get('msconf_preview_seller_avatar_image_width'), $this->config->get('msconf_preview_seller_avatar_image_height'));
				$this->session->data['multiseller']['files'][] = $seller['ms.avatar'];
			}

			if ($this->config->get('msconf_enable_seller_banner')) {
				if (!empty($seller['banner'])) {
					$this->data['seller']['banner']['name'] = $seller['banner'];
					$this->data['seller']['banner']['thumb'] = $this->MsLoader->MsFile->resizeImage($seller['banner'], $this->config->get('msconf_product_seller_banner_width'), $this->config->get('msconf_product_seller_banner_height'));
					$this->session->data['multiseller']['files'][] = $seller['banner'];
				}
			}

			$this->data['statustext'] = '';

			if ($seller['ms.seller_status'] != MsSeller::STATUS_INCOMPLETE) {
				$this->data['statustext'] = $this->language->get('ms_account_status') . $this->language->get('ms_seller_status_' . $seller['ms.seller_status']);
			}

			if ($seller['ms.seller_status'] == MsSeller::STATUS_INACTIVE && !$seller['ms.seller_approved']) {
				$this->data['statustext'] .= $this->language->get('ms_account_status_tobeapproved');
			}

			if ($seller['ms.seller_status'] == MsSeller::STATUS_INCOMPLETE) {
				$this->data['statustext'] .= $this->language->get('ms_account_status_please_fill_in');
			}

			$this->data['ms_account_sellerinfo_terms_note'] = '';
		} else {
			$this->data['seller'] = FALSE;
			$this->data['country_id'] = $this->config->get('config_country_id');


			$this->data['statustext'] = $this->language->get('ms_account_status_please_fill_in');

			if ($this->config->get('msconf_seller_terms_page')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('msconf_seller_terms_page'));

				if ($information_info) {
					$this->data['ms_account_sellerinfo_terms_note'] = sprintf($this->language->get('ms_account_sellerinfo_terms_note'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('msconf_seller_terms_page'), 'SSL'), $information_info['title'], $information_info['title']);
				} else {
					$this->data['ms_account_sellerinfo_terms_note'] = '';
				}
			} else {
				$this->data['ms_account_sellerinfo_terms_note'] = '';
			}
		}
		$this->document->setTitle($this->language->get('ms_account_sellerinfo_heading'));

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
				'text' => $this->language->get('ms_account_sellerinfo_breadcrumbs'),
				'href' => $this->url->link('seller/account-setting', '', 'SSL'),
			)
		));
		
		$this->data['group_menu'] = $this->getMenu();
		$this->MsLoader->MsSetting->setDefoult();

		list($template, $children) = $this->MsLoader->MsHelper->loadTemplate('account-setting');
		$this->response->setOutput($this->load->view($template, array_merge($this->data, $children)));
	}
	
	public function getMenu() {
		$menu = array();
		foreach ($this->MsLoader->MsSetting->ac_settings as $group => $datamass) {
				$menu[] = array(
					'name' => $this->language->get('ms_sellersetting_'.$group),
					'link' => $this->url->link('seller/account-setting/'.$group)
				);
		}
		return $menu;
	}
	
	public function as_main_information() {
		
		$this->document->setTitle($this->language->get('ms_account_sellerinfo_heading'));

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
				'text' => $this->language->get('ms_account_sellerinfo_breadcrumbs'),
				'href' => $this->url->link('seller/account-setting', '', 'SSL'),
			)
		));
		
		if(isset($this->request->post) && $this->request->post){
			echo '<pre>'; print_r($this->request->post); echo '</pre>';
		}
		
		$this->data['group_menu'] = $this->getMenu();
		
		list($template, $children) = $this->MsLoader->MsHelper->loadTemplate('multiseller/settings/' . __FUNCTION__);
		$this->response->setOutput($this->load->view($template, array_merge($this->data, $children)));
		
	}
	public function as_tax() {
		
		$this->document->setTitle($this->language->get('ms_account_sellerinfo_heading'));

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
				'text' => $this->language->get('ms_account_sellerinfo_breadcrumbs'),
				'href' => $this->url->link('seller/account-setting', '', 'SSL'),
			)
		));
		
		if(isset($this->request->post) && $this->request->post){
			echo '<pre>'; print_r($this->request->post); echo '</pre>';
		}
		
		$this->data['group_menu'] = $this->getMenu();
		
		list($template, $children) = $this->MsLoader->MsHelper->loadTemplate('multiseller/settings/' . __FUNCTION__);
		$this->response->setOutput($this->load->view($template, array_merge($this->data, $children)));
	}
	public function as_holiday() {
		
		$this->document->setTitle($this->language->get('ms_account_sellerinfo_heading'));

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
				'text' => $this->language->get('ms_account_sellerinfo_breadcrumbs'),
				'href' => $this->url->link('seller/account-setting', '', 'SSL'),
			)
		));
		
		if(isset($this->request->post) && $this->request->post){
			echo '<pre>'; print_r($this->request->post); echo '</pre>';
		}
		
		$this->data['group_menu'] = $this->getMenu();
		
		list($template, $children) = $this->MsLoader->MsHelper->loadTemplate('multiseller/settings/' . __FUNCTION__);
		$this->response->setOutput($this->load->view($template, array_merge($this->data, $children)));
	}	
}
?>
