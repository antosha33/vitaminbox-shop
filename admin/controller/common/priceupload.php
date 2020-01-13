<?php
class ControllerCommonPriceupload extends Controller {
	private $error = array();

	public function index() {
    $this->load->language('common/profile');
    
		$this->document->setTitle('Загрузить прайс для ЮРЛИЦ');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$user_data = array_merge($this->request->post, array(
				'user_group_id' => $this->user->getGroupId(),
				'status'        => 1,
			));
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('common/priceupload', 'user_token=' . $this->session->data['user_token'], true));
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

				$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/priceupload', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('common/priceupload', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true);


		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($user_info)) {
			$data['image'] = $user_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($user_info) && $user_info['image'] && is_file(DIR_IMAGE . $user_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($user_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/priceupload', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'common/priceupload')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}