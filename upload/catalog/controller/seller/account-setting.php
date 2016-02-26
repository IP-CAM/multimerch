<?php

class ControllerSellerAccountSetting extends ControllerSellerAccount {
	public function index() {
        $this->document->addScript('catalog/view/javascript/ms-common.js');
        $this->document->addScript('catalog/view/javascript/account-settings.js');
        $this->document->addScript('catalog/view/javascript/plupload/plupload.full.min.js');
        $this->document->addScript('catalog/view/javascript/plupload/jquery.plupload.queue/jquery.plupload.queue.js');

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
        
        $this->data['settings']['slr_thumb'] = $this->MsLoader->MsFile->resizeImage($this->data['settings']['slr_logo'], $this->config->get('msconf_preview_seller_avatar_image_width'), $this->config->get('msconf_preview_seller_avatar_image_height'));
        list($template, $children) = $this->MsLoader->MsHelper->loadTemplate('multiseller/settings/seller_settings');
        $this->response->setOutput($this->load->view($template, array_merge($this->data, $children)));
	}
    
    public function jxSaveSellerInfo() {
        $data = $this->request->post;

        if (isset($data['settings']['slr_logo']) && !empty($data['settings']['slr_logo'])) {
            $data['settings']['slr_logo'] = $this->MsLoader->MsFile->moveImage($data['settings']['slr_logo']);
            if (!$this->MsLoader->MsFile->checkFileAgainstSession($data['settings']['slr_logo'])) {
                $json['errors']['settings[slr_logo]'] = $this->language->get('ms_error_file_upload_error');
            }
        }
        $this->MsLoader->MsSetting->createSetting($data);
        $this->response->redirect($this->url->link('seller/account-dashboard', '', 'SSL'));
    }

    public function jxUploadSellerLogo() {
        $json = array();
        $file = array();

        $json['errors'] = $this->MsLoader->MsFile->checkPostMax($_POST, $_FILES);

        if ($json['errors']) {
            return $this->response->setOutput(json_encode($json));
        }

        foreach ($_FILES as $file) {
            $errors = $this->MsLoader->MsFile->checkImage($file);

            if ($errors) {
                $json['errors'] = array_merge($json['errors'], $errors);
            } else {
                $fileName = $this->MsLoader->MsFile->uploadImage($file);
                $thumbUrl = $this->MsLoader->MsFile->resizeImage($this->config->get('msconf_temp_image_path') . $fileName, $this->config->get('msconf_preview_seller_avatar_image_width'), $this->config->get('msconf_preview_seller_avatar_image_height'));
                $json['files'][] = array(
                    'name' => $fileName,
                    'thumb' => $thumbUrl
                );
            }
        }

        return $this->response->setOutput(json_encode($json));
    }
}
?>
