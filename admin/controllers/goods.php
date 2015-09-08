<?php
class controllers_goods extends controllers_base {
	public $goods = array();
	public $brands;
	public $categories;
	public $shops;
	public $colors;
	public $sizes;

	public function __construct() {
		parent::__construct();

		$eAdmin = lib_functions::getSession('eAdmin');
		if(empty($eAdmin)) {
			lib_functions::redirect('privilege/index');
		}
	}


	public function getList() {
		$filter = array('page_size'=>20,'page'=>1);

		if(!isset($_REQUEST['query'])) {
			$this->cats = $this->model->table('taoyizhang_wbsd1415_resit_category')->fetchAll();
		}

		if(isset($_REQUEST['query'])) {
			// echo $_REQUEST['query'];
			$this->layout = null;
			$filter['page_size'] = empty($_REQUEST['page_size'])?20:intval($_REQUEST['page_size']);
			$filter['page'] = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
			$this->query = 1;
			$filter['query'] = 1;
			$filter['goods_key'] = !empty($_REQUEST['goods_key'])?$_REQUEST['goods_key']:null;
			$filter['cat_id'] = !empty($_REQUEST['cat_id'])?$_REQUEST['cat_id']:null;

		}
		$filter = $this->add_magic($filter);
		
		$where = " ";
		if(!empty($filter['goods_key'])) {
			$where .= " and (g.goods_sn = '{$filter['goods_key']}' or g.goods_name like '%{$filter['goods_key']}%' )";
		}
		if(!empty($filter['cat_id'])) {
			$where .= " and g.category_id = '{$filter['cat_id']}'";
		}
		
		$sql = "select count(*) from taoyizhang_wbsd1415_resit_goods g where 1=1 $where";
		
		$num = $this->model->getOne($sql);

		

		$sql = "select g.* ,c.name as cat_name
				from taoyizhang_wbsd1415_resit_goods g,taoyizhang_wbsd1415_resit_category c
				where g.category_id=c.id
				$where";
		
		$this->goods = $this->model->getAll($sql);

	//	print_r($this->goods);exit;

		/**
		 * group acl_action
		 */
		$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='group'";
		$groups = $this->model->getAll($sql);

		foreach($groups as $n=>$data) {
			$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='url' and parent_id = '{$data['id']}'";

			$groups[$n]['children'] = $this->model->getAll($sql);
		}

		$this->groups_action_list = $groups;
		$this->view = 'goods/list';
		if(isset($_REQUEST['query'])) {
			$this->make_json_exit('goods/list.php',$filter);
		}


	}

	public function add() {
		$this->brands  = $this->model->table('taoyizhang_wbsd1415_resit_brand')->fetchAll();
		$this->categories = $this->model->table('taoyizhang_wbsd1415_resit_category')->fetchAll();
		$this->shops = $this->model->table('taoyizhang_wbsd1415_resit_shops')->fetchAll();
		/**
		 * group acl_action
		 */
		$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='group'";
		$groups = $this->model->getAll($sql);

		foreach($groups as $n=>$data) {
			$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='url' and parent_id = '{$data['id']}'";

			$groups[$n]['children'] = $this->model->getAll($sql);
		}

		$this->groups_action_list = $groups;
	}

	public function edit($id = null) {
		if(empty($id)) {
			exit('Not exist');
		}
		$this->brands  = $this->model->table('taoyizhang_wbsd1415_resit_brand')->fetchAll();
		$this->categories = $this->model->table('taoyizhang_wbsd1415_resit_category')->fetchAll();
		$this->shops = $this->model->table('taoyizhang_wbsd1415_resit_shops')->fetchAll();
		$this->goods = $this->model->table('taoyizhang_wbsd1415_resit_goods')->fetch(array('where'=>array('id'=>$id)));
		$sql = "select gc.*,c.name as color_name from taoyizhang_wbsd1415_resit_goods_color gc ,taoyizhang_wbsd1415_resit_color c where gc.color_id=c.id and gc.goods_id='{$id}'";
		$this->colors = $this->model->getAll($sql);

		$sql = "select gs.*,s.name as size_name from taoyizhang_wbsd1415_resit_goods_size gs ,taoyizhang_wbsd1415_resit_size s where gs.size_id=s.id and gs.goods_id='{$id}'";
		$this->sizes = $this->model->getAll($sql);
		/**
		 * group acl_action
		 */
		$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='group'";
		$groups = $this->model->getAll($sql);

		foreach($groups as $n=>$data) {
			$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='url' and parent_id = '{$data['id']}'";

			$groups[$n]['children'] = $this->model->getAll($sql);
		}

		$this->groups_action_list = $groups;
	//	print_r($this->sizes);
	}

	public function save() {

		// alert('save');
	
		$goods = array(
			'goods_sn' => $this->_request('goods_sn'),
			'goods_name' => $this->_request('goods_name'),
			'category_id' => $this->_request('cat_id'),


			'price' => $this->_request('price'),

			'describle' => $this->_request('desc'),
			'weight' => $this->_request('goods_weight')
			);
		$goods['price'] = empty($goods['price'])?'0.00':$goods['price'];

	//	print_r($_REQUEST);exit;
		try{
			$this->model->startTransaction();
			$this->model->table('taoyizhang_wbsd1415_resit_goods')->insert($goods);
//			$goods_id = $this->model->getOne('select last_insert_id()');
			
		}catch(Exception $e) {
			$this->model->rollback();
			exit('Save failed!'.$e->getMessage());
		}
		$this->model->commit();
		exit('Success');
	}

	public function edit_save() {
		// exit('fuck');

		$goods_sn = $this->_request('goods_sn');
		$goods_id = $this->_request('goods_id');

		$goods = array(
            'goods_sn' => $goods_sn,
			'goods_name' => $this->_request('goods_name'),
			'category_id' => $this->_request('cat_id'),
			'price' => $this->_request('price'),
			
			'weight' => $this->_request('goods_weight'),
			'describle' => $this->_request('desc')
			);
		$goods['price'] = empty($goods['price'])?'0.00':$goods['price'];

	//	print_r($_REQUEST);exit;
		try{
			$this->model->startTransaction();
			$this->model->table('taoyizhang_wbsd1415_resit_goods')->update(array('id'=>$goods_id),$goods);


			// exit('fuwck');
		}catch(Exception $e) {
			$this->model->rollback();
			exit('Save failed!'.$e->getMessage());
		}
		$this->model->commit();
		exit('Update Success');
	}

	public function delete($id=null) {
		if(empty($id)) {
			exit('Not exist');
		}
		$sql = "select count(*) from taoyizhang_wbsd1415_resit_order_goods where goods_id='{$id}'";
		$num = $this->model->getOne($sql);
		if($num>0) {
			exit(json_encode(array('status'=>-1,'msg'=>'cannot delete')));
		}
		$this->model->table('taoyizhang_wbsd1415_resit_goods')->delete(array('id'=>$id));
		exit(json_encode(array('status'=>0,'msg'=>'delete success!')));
	}


	public function search_color() {
		$color_key  = $this->_request('color_keyword');
		$color_key = trim($color_key);
		$sql = "select * from taoyizhang_wbsd1415_resit_color";
		if($color_key !== '') {
			$sql .= " where code ='{$color_key}' or name like '%{$color_key}%'";
		}
		
		$colors = $this->model->getAll($sql);
		exit(json_encode($colors));
	}

	public function search_size() {
		$size_key  = $this->_request('size_keyword');
		$size_key = trim($size_key);
		$sql = "select * from taoyizhang_wbsd1415_resit_size";
		if($size_key !== '') {
			$sql .= " where code ='{$size_key}' or name like '%{$size_key}%'";
		}
		
		$sizes = $this->model->getAll($sql);
		exit(json_encode($sizes));
	}

	/**
	 * all goods list
	 *
	 */
	public function select_goods($order_id = null) {

		if($this->_request('act') == 'query') {
			$this->layout = null;

			$goods_sn = $this->_request('goods_sn');
			$goods_name = $this->_request('goods_name');
			$cat_id = $this->_request('cat_id');
			$brand_id = $this->_request('brand_id');
			
			$sql = "select g.*,s.name as shop_name ,c.name as cat_name,b.name as brand_name
					from taoyizhang_wbsd1415_resit_goods g,taoyizhang_wbsd1415_resit_shops s,taoyizhang_wbsd1415_resit_category c,taoyizhang_wbsd1415_resit_brand b
					where g.shop_id = s.id and g.category_id=c.id and b.id=g.brand_id";

			if(!empty($goods_sn)) {
				$sql .= " and g.goods_sn = '{$goods_sn}'";
			}
			if(!empty($goods_name)) {
				$sql .= " and g.goods_name like '%{$goods_name}%'";
			}
			if(!empty($cat_id)) {
				$sql .= " and g.category_id = '{$cat_id}'";
			}
			if(!empty($brand_id)) {
				$sql .= " and g.brand_id = '{$brand_id}'";
			}
			
			$this->goods = $this->model->getAll($sql);

			$this->fullpage = 0;
			
		}else {
			
			$sql = "select g.*,s.name as shop_name ,c.name as cat_name,b.name as brand_name
					from taoyizhang_wbsd1415_resit_goods g,taoyizhang_wbsd1415_resit_shops s,taoyizhang_wbsd1415_resit_category c,taoyizhang_wbsd1415_resit_brand b
					where g.shop_id = s.id and g.category_id=c.id and b.id=g.brand_id";
			if(!empty($_REQUEST['order_sn'])) {
				$_REQUEST['order_sn'] = urldecode($_REQUEST['order_sn']);

				$sql .= " and (g.goods_sn like '%{$_REQUEST['order_sn']}%' or g.goods_name like '%{$_REQUEST['order_sn']}%') ";
			}
		//	error_log($sql,3,'d:/1.sql');
			$this->goods = $this->model->getAll($sql);
		//	print_r($this->goods);exit;
			$sql = "select * from taoyizhang_wbsd1415_resit_category";
			$this->categories = $this->model->getAll($sql);

			$sql = "select * from taoyizhang_wbsd1415_resit_brand";
			$this->brands = $this->model->getAll($sql);

			$this->fullpage = 1;
		}

		$this->order_id = $order_id;
	}

	/*
	 * someone goods 
	 *
	 *
	 */
	public function select_goods_one($id) {
		
		$sql = "select c.name as color_name,c.id from taoyizhang_wbsd1415_resit_goods_color gc,taoyizhang_wbsd1415_resit_color c
				where gc.color_id = c.id and gc.goods_id='{$id}'";
		$this->colors = $this->model->getAll($sql);
		//print_r($this->colors);exit;
		$sql = "select s.id,s.name as size_name from taoyizhang_wbsd1415_resit_goods_size gs,taoyizhang_wbsd1415_resit_size s
				where gs.size_id=s.id and gs.goods_id='{$id}'";
		$this->sizes = $this->model->getAll($sql);
	//	print_r($this->sizes);exit;
		//goods 
		$sql = "select * from taoyizhang_wbsd1415_resit_goods where id='{$id}'";
		$this->goods = $this->model->getRow($sql);

	}


	/**
	 *upload pictures
	 *
	 */
	 public function upload_img() {
		
		if (isset($_POST["PHPSESSID"])) {
			session_id($_POST["PHPSESSID"]);
		}
	//	print_r($_FILES);exit;
		if(isset($_FILES['Filedata'])) {
			$file_name = $_FILES['Filedata']['name'];
			$tmp_name = $_FILES['Filedata']['tmp_name'];
			
			$save_path = defined('DT')?DT.'/layout/images/':null;
			// exit($save_path);
			if(empty($save_path) || !is_dir($save_path)) {
				$save_path = 'tmp/';
			}

			$file_name_new = $save_path.$file_name;
			$file_name_new = $this->get_file($file_name_new);
		//	exit($tmp_name);
			// exit($file_name_new);
			if (!@move_uploaded_file($tmp_name, $file_name_new)) {
				exit('save failed');
			}

			$img_url = empty($save_path)?'tmp/':'';
			$img_url .= basename($file_name_new);
			$img_url = addslashes($img_url);

			$id = $this->_request('id');
			$sql = "update taoyizhang_wbsd1415_resit_goods set img_url = '{$img_url}' where id='{$id}'";
			$this->model->query($sql);

		}
		exit;
		
	 }
	

	 private function get_file($file_name) {
		if(!file_exists ($file_name)) {
				return $file_name;
		}else {
			
			$path_parts = pathinfo($file_name);
			$new_file = trim($file_name,'.'.$path_parts['extension']);
			$new_file .= '1.'.$path_parts['extension'];

			return $this->get_file($new_file);
		}
	 }
	

}