<?php

class ControllerSellerAccountSetting extends ControllerSellerAccount {
	public function index() {
        $this->load->model('localisation/country');

        $this->document->setTitle($this->language->get('ms_account_sellersetting_breadcrumbs'));

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
                'text' => $this->language->get('ms_account_sellersetting_breadcrumbs'),
                'href' => $this->url->link('seller/account-setting', '', 'SSL'),
            )
        ));
        $this->data['seller_id'] = $this->customer->getId();
//        $this->data['seller_group_id'] = $this->MsLoader->MsSellerGroup->getSellerGroupBySellerId($this->data['seller_id']);
        $this->data['countries'] = $this->model_localisation_country->getCountries();
        $this->data['settings'] = $this->MsLoader->MsSetting->getSettings(array('seller_id' => $this->data['seller_id']));
        
        list($template, $children) = $this->MsLoader->MsHelper->loadTemplate('multiseller/settings/seller_settings');
        $this->response->setOutput($this->load->view($template, array_merge($this->data, $children)));
	}
    
    public function jxsavesellerinfo() {
        $data = $this->request->post;
        $this->MsLoader->MsSetting->createSetting($data);

        $this->response->redirect($this->url->link('seller/account-dashboard', '', 'SSL'));
    }
}
?>
