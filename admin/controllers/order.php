<?php
class controllers_order extends controllers_base {
	public $shop_from; //shopcategories
	public $ships; //ship company
	public $payments; //card number
	public $provinces;//province
	public $cities;//province
	public $order_info;//order
	public $order_list;

	public function __construct(){
		parent::__construct();
	//	$this->layout = null;
		
		$eAdmin = lib_functions::getSession('eAdmin');
		if(empty($eAdmin)) {
			lib_functions::redirect('privilege/index');
		}
	}
	
	/**
	 *add order
	 *
	 */
	 public function add() {
		//shopcategories
		$this->shop_from = $this->model->table('taoyizhang_wbsd1415_resit_shop_class')->fetchAll();
		//ship company
		$this->ships = $this->model->table('taoyizhang_wbsd1415_resit_ships')->fetchAll(
			array('where'=>array('enabled'=>1))
		);
		//card number
		$this->payments = $this->model->table('taoyizhang_wbsd1415_resit_payments')->fetchAll(
			array('where'=>array('enabled'=>1))
		);

		//province
		$this->provinces = $this->model->table('taoyizhang_wbsd1415_resit_region')->fetchAll(
				array('where'=>array('region_type'=>1))
			);

		
		if(isset($_REQUEST['shop_class_code'])) {
			$shops = $this->model->table('taoyizhang_wbsd1415_resit_shops')->fetchAll(
				array('where'=>array('class_code'=>$_REQUEST['shop_class_code']))
			);
			
			exit(json_encode($shops));
		}

		if(isset($_REQUEST['province'])) {
			$cities = $this->model->table('taoyizhang_wbsd1415_resit_region')->fetchAll(
				array('where'=>array('region_type'=>2,'parent_id'=>$_REQUEST['province']))
			);
			
			exit(json_encode($cities));
		}

		if(isset($_REQUEST['city'])) {
			$district = $this->model->table('taoyizhang_wbsd1415_resit_region')->fetchAll(
				array('where'=>array('region_type'=>3,'parent_id'=>$_REQUEST['city']))
			);
			
			exit(json_encode($district));
		}

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

	 /**
	  *order save
	  *
	  */
	  public function save() {
		//  $order_source = $this->_request('order_source');
		
			$order = array(
				'add_time' => strtotime($this->_request('add_time')),
                'pay_money' => $this->_request('pay_money'),
				'deal_code' => $this->_request('deal_code'),
				'bz' => $this->_request('bz'),
				'email' => $this->_request('email'),
				'consignee' => $this->_request('consignee'),
				'province' => $this->_request('province'),
				'city' => $this->_request('city'),
				'address' => $this->_request('address'),
				'tel' => $this->_request('tel'),
				'zipcode' => $this->_request('zipcode')
            );
		
			$this->model->startTransaction();
			// save users
//			$user_name = $this->_request('buyer_name');

			$order['order_sn'] = $order['deal_code'];
			$order_id = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->insert($order);

			$this->model->commit();
			$url = lib_functions::url('order/info/'.$order_id);
			header("location:$url");
	  }

	  /**
	   *
	   *order information
	   */
	   public function info($order_id) {

			$sql = "select o.*,sp.name as shop_name,u.user_name
					from taoyizhang_wbsd1415_resit_order_info as o,taoyizhang_wbsd1415_resit_shops as sp,taoyizhang_wbsd1415_resit_users as u
					where u.id=o.user_id  and o.id='{$order_id}'";
			
			$this->order_info = $this->model->getRow($sql);
			//card number
			$sql = "select id,name  from taoyizhang_wbsd1415_resit_payments";
			$this->payments = $this->model->getAll($sql);
			//ship method
			$sql = "select id,name from taoyizhang_wbsd1415_resit_ships";
			$this->ships = $this->model->getAll($sql);


			$sql = "select * from taoyizhang_wbsd1415_resit_order_goods og,taoyizhang_wbsd1415_resit_goods g
					where og.goods_id = g.id and order_id = '{$order_id}'";

			$this->goods = $this->model->getAll($sql);
//           print_r($sql);
//           print_r($this->goods);exit;

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

		//	print_r($this->order_goods);exit;
	   }

	public function remove($order_id) {


		$sql = "delete from taoyizhang_wbsd1415_resit_order_info where id='{$order_id}'";
		$this->model->query($sql);

		//update  order

		$mdl = new models_order();
		$mdl->update_je_sl($order_id);
	}
	  /***
	   *
	   *order list
	   *
	   */
	   public function getList() {

		    $filter = array('page_size'=>20,'page'=>1);
			if(!isset($_REQUEST['query'])) {
				$this->ships = $this->model->table('taoyizhang_wbsd1415_resit_ships')->fetchAll();
				$this->shops = $this->model->table('taoyizhang_wbsd1415_resit_shops')->fetchAll();
				$this->payments = $this->model->table('taoyizhang_wbsd1415_resit_payments')->fetchAll();
			}

			if(isset($_REQUEST['query'])) {
				$this->layout = null;
				$filter['page_size'] = empty($_REQUEST['page_size'])?20:intval($_REQUEST['page_size']);
				$filter['page'] = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
				$this->query = 1;
				$filter['query'] = 1;
				// $filter['order_sn'] = !empty($_REQUEST['order_sn'])?$_REQUEST['order_sn']:null;
				// $filter['deal_code'] = !empty($_REQUEST['deal_code'])?$_REQUEST['deal_code']:null;
				$filter['consignee'] = !empty($_REQUEST['consignee'])?$_REQUEST['consignee']:null;
				$filter['status'] = isset($_REQUEST['status'])?$_REQUEST['status']:null;
				$filter['pay_status'] = isset($_REQUEST['pay_status'])?$_REQUEST['pay_status']:null;
				$filter['ship_id'] = isset($_REQUEST['ship_id'])?$_REQUEST['ship_id']:null;
				// $filter['pay_id'] = isset($_REQUEST['pay_id'])?$_REQUEST['pay_id']:null;
				$filter['start_add_time'] = isset($_REQUEST['start_add_time'])?$_REQUEST['start_add_time']:null;
				$filter['end_add_time'] = isset($_REQUEST['end_add_time'])?$_REQUEST['end_add_time']:null;
			}
			$filter = $this->add_magic($filter);

			$where = '';

			if(!empty($filter['consignee'])) {
				$where .= " and oi.consignee = '{$filter['consignee']}'";
			}
			if(!empty($filter['ship_id'])) {
				$where .= " and oi.shipping_id = '{$filter['ship_id']}'";
			}

			if(isset($filter['status']) && $filter['status'] != '') {
				$where .= " and oi.status = '{$filter['status']}'";
			}
			if(isset($filter['pay_status']) && $filter['pay_status'] != '') {
				$where .= " and oi.pay_status = '{$filter['pay_status']}'";
			}
			if(!empty($filter['start_add_time'])) {
				$where .= " and oi.add_time >= '".strtotime($filter['start_add_time'])."'";
			}
			if(!empty($filter['end_add_time'])) {
				$where .= " and oi.add_time <= '".strtotime($filter['end_add_time'])."'";
			}
			
			$sql = "select count(*) from taoyizhang_wbsd1415_resit_order_info oi where 1=1 $where";
		
			$num = $this->model->getOne($sql);

			$start = $filter['page_size'] * ($filter['page']-1);
			if($start > $num) {
				$start = 0;
			}

			$sql = "select oi.* from taoyizhang_wbsd1415_resit_order_info as oi
					$where 
					limit $start ,{$filter['page_size']}";
			$this->order_list = $this->model->getAll($sql);
			
		   $this->cote_action_list = $this->model->table('taoyizhang_wbsd1415_resit_acl_action')->fetchAll(
			   array('cols'=>array('action_name','action_code'),
				   'where'=>array('type'=>'cote'))
		   );


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

			if(isset($_REQUEST['query'])) {
				$this->make_json_exit('order/.php',$filter);
			}
	   }

	   /**
	    *orderadd goods
		*
		*/
		public function add_goods() {
			$goods_sn = $_REQUEST['goods_sn'];
			$goods_id = $_REQUEST['goods_id'];
			$order_id = $_REQUEST['order_id'];
			$price = $_REQUEST['price'];
			$price = $_REQUEST['price'];
			
			$sql = "select order_sn from taoyizhang_wbsd1415_resit_order_info where id='{$order_id}'";
			$order_sn = $this->model->getOne($sql);

			//color storage
			$mdl = new models_order();

			foreach($_REQUEST as $key => $value) {
				if(substr($key,0,3) == 'row') {
					if((int)$value) {
						$size_color_arr = explode('_',$key);
						$size_id = $size_color_arr[1];
						$color_id = $size_color_arr[2];
						$goods_number = (int)$value;
						$goods_amount = $price * $goods_number;
						$pay_fee = $price * $goods_number;
						$card_fee = $goods_amount - $pay_fee;
						
						$sql = "select code from taoyizhang_wbsd1415_resit_color where id='{$color_id}'";
						$color_code = $this->model->getOne($sql);
						$sql = "select code from taoyizhang_wbsd1415_resit_size where id='{$size_id}'";
						$size_code = $this->model->getOne($sql);

						$goods_arr = array(
							'order_sn' => $order_sn,
							'order_id' => $order_id,
							'goods_id' => $goods_id,
							'goods_sn' => $goods_sn,
							'color_id' => $color_id,
							'size_id'  => $size_id,
							'color_code' => $color_code,
							'size_code'=> $size_code,
							'goods_number'=> $goods_number,
							'goods_amount'=> $goods_amount,
							'card_fee' => $card_fee,
							'pay_fee' => $pay_fee
							);
							
						$mdl->add_goods($goods_arr);
					}
				}
			}
			//update  order 
			$mdl->update_je_sl($order_id);
			/*
			$url = lib_functions::url("goods/select_goods_one/{$goods_id}?order_id=".$order_id);
			header('location:'.$url);
			*/
			exit("<script type='text/javascript'>window.close()</script>");

		//	print_r($_REQUEST);exit;
			
		}


		/** 
		 *Editgoods 
		 *
		 */
		 public function edit_goods() {
			
			 //Edit save
			if(isset($_POST['submit'])) {
				$order_goods_id = $this->_request('order_goods_id');
				$price = $this->_request('price');
				$price = $this->_request('price');
				$num = $this->_request('goods_number');
				$goods_amount = $num*$price;
				$pay_fee = $price * $num;
				$card_fee = $goods_amount-$pay_fee;
			
				$sql = "update taoyizhang_wbsd1415_resit_order_goods set goods_number='{$num}',
						goods_amount='{$goods_amount}',card_fee='{$card_fee}',
						pay_fee='{$pay_fee}' where id='{$order_goods_id}'";
				
				$ret = $this->model->query($sql);
				//update  order 
				$order_id = $this->model->getOne("select order_id from taoyizhang_wbsd1415_resit_order_goods where id='{$order_goods_id}'");
				$mdl = new models_order();
				$mdl->update_je_sl($order_id);

				if($ret) {
					exit(json_encode(array('code'=>0,'msg'=>'Success')));
				}else {
					exit(json_encode(array('code'=>-1,'msg'=>'Save failed!')));
				}
			}else {
				$id = $this->_request('id');
				$sql = "select og.*,g.price,g.price ,g.goods_name as goods_name
						from taoyizhang_wbsd1415_resit_order_goods og, goods g
						where og.goods_id=g.id and og.id = '{$id}'";
				$this->goods = $this->model->getRow($sql);

				$sql = "select s.id,s.name from taoyizhang_wbsd1415_resit_goods_size gs,size s where gs.size_id=s.id and gs.goods_id='{$this->goods['goods_id']}'";
				$this->sizes = $this->model->getAll($sql);

				$sql = "select c.id,c.name from taoyizhang_wbsd1415_resit_goods_color gc,color c  where gc.color_id=c.id and gc.goods_id='{$this->goods['goods_id']}'";
				$this->colors = $this->model->getAll($sql);
			}

		 }

		 /**
		  *deletegoods 
		  *
		  */
		 public function remove_goods() {
			$id = $this->_request('id');
			$order_id = $this->model->getOne("select order_id from taoyizhang_wbsd1415_resit_order_goods where id='{$id}'");

			$sql = "delete from taoyizhang_wbsd1415_resit_order_goods where id='{$id}'";
			$this->model->query($sql);
			
			//update  order 
			
			$mdl = new models_order();
			$mdl->update_je_sl($order_id);
		 }

		 public function edit_base_info() {
			$this->layout = null;
			$id = $this->_request('id');
			$ship_id = $this->_request('ship_id');
			$pay_id = $this->_request('pay_id');
			$sql = "update taoyizhang_wbsd1415_resit_order_info set pay_id='{$pay_id}',shipping_id='{$ship_id}' where id='{$id}'";

			$this->model->query($sql);
			exit();
		 }

		 public function edit_consignee_info() {
			$this->layout = null;
			$id = $this->_request('id');
			$consignee = $this->_request('consignee');
			$address = $this->_request('address');
			$bz = $this->_request('bz');
			$email = $this->_request('email');
			$zipcode = $this->_request('zipcode');
			$tel = $this->_request('tel');
			$province = $this->_request('province');
			$city = $this->_request('city');

			$sql = "update taoyizhang_wbsd1415_resit_order_info set
				consignee='{$consignee}',
				address='{$address}',
				bz='{$bz}',
				email='{$email}',
				zipcode='{$zipcode}',
				tel='{$tel}',
				province='{$province}',
				city='{$city}'
				where id='{$id}'";

			$this->model->query($sql);
			exit();
		 }

		 /**
		  *Pay
		  *
		  */
		  public function pay_money() {
				$status = $this->_request('status');
				$order_id = $this->_request('order_id');
				$sql = "select count(*) from taoyizhang_wbsd1415_resit_order_goods where order_id='{$order_id}'";
				$num = $this->model->getOne($sql);
				if($num == 0) {
					exit(json_encode(array('status'=>-1,'msg'=>'No goods ')));
				}
				//$ret = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->update(array('id'=>$order_id),array('pay_status'=>$status));
				if($status == 0) { //cancel Pay
					$this->model->table('taoyizhang_wbsd1415_resit_order_goods')->update(array('order_id'=>$order_id),array('is_separate'=>0));

					$sql = "update taoyizhang_wbsd1415_resit_order_info set pay_status = $status,pay_money=0,is_separate=0,pay_time=0 where id='{$order_id}'";

				}else{  //Pay
					$time = time();
					$sql = "update taoyizhang_wbsd1415_resit_order_info set pay_status = $status,pay_money=total_amount,pay_time='{$time}' where id='{$order_id}'";

					// lock   stock 
					$mdl= new models_goods();
					
					$mdl->order_add_lock_stock($order_id);
					
				}
				$ret = $this->model->query($sql);
				$msg = $status == 0?'Cancel':'Pay';
				if($ret) {
					exit(json_encode(array('status'=>0,'msg'=>$msg.'success！')));
				}else {
					exit(json_encode(array('status'=>-1,'msg'=>$msg.'Failed！')));
				}
		  }

		 /**
		  *Confirm
		  *
		  */
		  public function confirm() {
				$status = $this->_request('status');
				$order_id = $this->_request('order_id');
				if($status == 0) {
					$ret = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->update(array('id'=>$order_id,'status'=>1,'is_guaqi'=>0),array('status'=>$status,'confirm_time'=>0));
				}else {
					$sql = "select count(*) from taoyizhang_wbsd1415_resit_order_goods where order_id='{$order_id}'";
					$num = $this->model->getOne($sql);
					if($num == 0) {
						exit(json_encode(array('status'=>-1,'msg'=>'No goods！')));
					}
					
					$ret = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->update(array('id'=>$order_id,'status'=>0,'is_guaqi'=>0,'is_separate'=>0),array('status'=>$status,'confirm_time'=>time()));
				
				}
				$msg = $status == 0?'Cancel':'Confirm';
				if($ret) {
					exit(json_encode(array('status'=>0,'msg'=>$msg.'success！')));
				}else {
					exit(json_encode(array('status'=>-1,'msg'=>$msg.'Failed！')));
				}
		  }
		 /**
		  *Notification pick 
		  *
		  */
		  public function notice_peihuo() {
				$status = $this->_request('status');
				$order_id = $this->_request('order_id');
				$msg = $status == 0?'Notification pick cancel ':'Notification pick ';

				if($status == 0) {
					$ret = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->update(array('id'=>$order_id,'pay_status'=>1,'status'=>2,'is_guaqi'=>0),array('status'=>1,'peihuo_time'=>0));
				}else{
					$ret = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->update(
						array('id'=>$order_id,'pay_status'=>1,'status'=>1,'is_guaqi'=>0),
						array('status'=>2,'peihuo_time'=>time())
					);
				}
				
				if($ret) {
					exit(json_encode(array('status'=>0,'msg'=>$msg.'success！')));
				}else {
					exit(json_encode(array('status'=>-1,'msg'=>$msg.'Failed！')));
				}
		  }

		  /**
		   *Wait operation 
		   *
		   */
		   public function guaqi() {
				$status = $this->_request('status');
				$order_id = $this->_request('order_id');
				$msg = $status == 0?'Wait cancel':'Wait ';

				if($status == 0) {
					$ret = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->update(array('id'=>$order_id),array('is_guaqi'=>0));
				}else{
					$ret = $this->model->table('taoyizhang_wbsd1415_resit_order_info')->update(array('id'=>$order_id),array('is_guaqi'=>1));
				}
				
				if($ret) {
					exit(json_encode(array('status'=>0,'msg'=>$msg.'success！')));
				}else {
					exit(json_encode(array('status'=>-1,'msg'=>$msg.'Failed！')));
				}
		  }

	  /***
	   *
	   * list
	   *
	   */
	   public function torange() {
		    $filter = array('page_size'=>20,'page'=>1);
			if(!isset($_REQUEST['query'])) {
				$this->ships = $this->model->table('taoyizhang_wbsd1415_resit_ships')->fetchAll();
				$this->shops = $this->model->table('taoyizhang_wbsd1415_resit_shops')->fetchAll();
				$this->payments = $this->model->table('taoyizhang_wbsd1415_resit_payments')->fetchAll();
			}

			if(isset($_REQUEST['query'])) {
				$this->layout = null;
				$filter['page_size'] = empty($_REQUEST['page_size'])?20:intval($_REQUEST['page_size']);
				$filter['page'] = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
				$this->query = 1;
				$filter['query'] = 1;
				$filter['order_sn'] = !empty($_REQUEST['order_sn'])?$_REQUEST['order_sn']:null;
				$filter['deal_code'] = !empty($_REQUEST['deal_code'])?$_REQUEST['deal_code']:null;
				$filter['consignee'] = !empty($_REQUEST['consignee'])?$_REQUEST['consignee']:null;
				$filter['status'] = $_REQUEST['status'];
				$filter['pay_status'] = $_REQUEST['pay_status'];
				$filter['ship_id'] = $_REQUEST['ship_id'];
				// $filter['pay_id'] = $_REQUEST['pay_id'];
				$filter['start_add_time'] = $_REQUEST['start_add_time'];
				$filter['end_add_time'] = $_REQUEST['end_add_time'];
			}
			$filter = $this->add_magic($filter);

			$where = '';
			if(!empty($filter['order_sn'])) {
				$where .= " and oi.order_sn = '{$filter['order_sn']}'";
			}
			if(!empty($filter['deal_code'])) {
				$where .= " and oi.deal_code = '{$filter['deal_code']}'";
			}
			if(!empty($filter['consignee'])) {
				$where .= " and oi.consignee = '{$filter['consignee']}'";
			}
			if(!empty($filter['ship_id'])) {
				$where .= " and oi.shipping_id = '{$filter['ship_id']}'";
			}
			if(!empty($filter['pay_id'])) {
				$where .= " and oi.pay_id = '{$filter['pay_id']}'";
			}
			if(isset($filter['status']) && $filter['status'] != '') {
				$where .= " and oi.status = '{$filter['status']}'";
			}
			if(isset($filter['pay_status']) && $filter['pay_status'] != '') {
				$where .= " and oi.pay_status = '{$filter['pay_status']}'";
			}
			if(!empty($filter['start_add_time'])) {
				$where .= " and oi.add_time >= '".strtotime($filter['start_add_time'])."'";
			}
			if(!empty($filter['end_add_time'])) {
				$where .= " and oi.add_time <= '".strtotime($filter['end_add_time'])."'";
			}
			
			$sql = "select count(*) from taoyizhang_wbsd1415_resit_order_info oi where oi.status = 2 $where";
		
			$num = $this->model->getOne($sql);
			
			$start = $filter['page_size'] * ($filter['page']-1);
			if($start > $num) {
				$start = 0;
			}

			$sql = "select oi.*,s.name as shop_name from taoyizhang_wbsd1415_resit_order_info as oi,taoyizhang_wbsd1415_resit_shops as s
					where oi.status = 2 
					$where 
					limit $start,{$filter['page_size']}";
			$this->order_list = $this->model->getAll($sql);


			if(isset($_REQUEST['query'])) {
				$this->make_json_exit('order/torange.php',$filter);
			}
	   }

	   /**
	    *ship list
		*
		*/

		public function send_list() {
			$filter = array('page_size'=>20,'page'=>1);
			if(!isset($_REQUEST['query'])) {
				$this->ships = $this->model->table('taoyizhang_wbsd1415_resit_ships')->fetchAll();
				$this->shops = $this->model->table('taoyizhang_wbsd1415_resit_shops')->fetchAll();
				$this->payments = $this->model->table('taoyizhang_wbsd1415_resit_payments')->fetchAll();
			}
			$filter['status'] = 4;
			if(isset($_REQUEST['query'])) {
				$this->layout = null;
				$filter['page_size'] = empty($_REQUEST['page_size'])?20:intval($_REQUEST['page_size']);
				$filter['page'] = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
				$this->query = 1;
				$filter['query'] = 1;
				$filter['order_sn'] = !empty($_REQUEST['order_sn'])?$_REQUEST['order_sn']:null;
				$filter['deal_code'] = !empty($_REQUEST['deal_code'])?$_REQUEST['deal_code']:null;
				$filter['consignee'] = !empty($_REQUEST['consignee'])?$_REQUEST['consignee']:null;
			
				$filter['status'] = isset($_REQUEST['status'])?$_REQUEST['status']:null;
				$filter['pay_status'] = isset($_REQUEST['pay_status'])?$_REQUEST['pay_status']:null;
				$filter['ship_id'] = isset($_REQUEST['ship_id'])?$_REQUEST['ship_id']:null;
				$filter['pay_id'] = isset($_REQUEST['pay_id'])?$_REQUEST['pay_id']:null;
				$filter['start_add_time'] = isset($_REQUEST['start_add_time'])?$_REQUEST['start_add_time']:null;
				$filter['end_add_time'] = isset($_REQUEST['end_add_time'])?$_REQUEST['end_add_time']:null;
			}
			$filter = $this->add_magic($filter);

			$where = '';
			if(!empty($filter['order_sn'])) {
				$where .= " and oi.order_sn = '{$filter['order_sn']}'";
			}
			if(!empty($filter['deal_code'])) {
				$where .= " and oi.deal_code = '{$filter['deal_code']}'";
			}
			if(!empty($filter['consignee'])) {
				$where .= " and oi.consignee = '{$filter['consignee']}'";
			}
			if(!empty($filter['ship_id'])) {
				$where .= " and oi.shipping_id = '{$filter['ship_id']}'";
			}
			if(!empty($filter['pay_id'])) {
				$where .= " and oi.pay_id = '{$filter['pay_id']}'";
			}
			if(isset($filter['status']) && $filter['status'] != '') {
				$where .= " and oi.status = '{$filter['status']}'";
			}
			if(isset($filter['pay_status']) && $filter['pay_status'] != '') {
				$where .= " and oi.pay_status = '{$filter['pay_status']}'";
			}
			if(!empty($filter['start_add_time'])) {
				$where .= " and oi.add_time >= '".strtotime($filter['start_add_time'])."'";
			}
			if(!empty($filter['end_add_time'])) {
				$where .= " and oi.add_time <= '".strtotime($filter['end_add_time'])."'";
			}
			
			$sql = "select count(*) from taoyizhang_wbsd1415_resit_order_info oi where 1=1 $where";
		
			$num = $this->model->getOne($sql);

			$sql = "select oi.* from taoyizhang_wbsd1415_resit_order_info as oi
					
					where oi.status > 3
					$where";
			
			$this->order_list = $this->model->getAll($sql);
			
			$this->pageinfo = $this->set_page($this->order_list,$num,$filter);

			if(isset($_REQUEST['query'])) {
				
				$this->make_json_exit('order/send_list.php',$filter);
			}

		}

		/**
		 *ship 
		 *
		 */
		 public function send($id = null) {
			if(empty($id)) {
				exit('Failed. Not exist!');
			}
			$time = time();
			$sql = "update taoyizhang_wbsd1415_resit_order_info set status =5,shipping_time='{$time}' where id ='{$id}'";
			$this->model->query($sql);

			
			$sql = "update taoyizhang_wbsd1415_resit_goods_stock gs,taoyizhang_wbsd1415_resit_order_goods og
					set gs.actual_quantity = gs.actual_quantity-og.goods_number,gs.lock_quantity=gs.lock_quantity-og.goods_number
					where og.goods_id=gs.goods_id and og.size_id=gs.size_id and og.color_id=gs.color_id
					and og.warehouse_id = gs.warehouse_id
					and og.order_id = '{$id}'";
			$this->model->query($sql);

			$url = lib_functions::url('order/send_list');
			header('location:'.$url);

		 }

		 /**
		  *batch ship 
		  *
		  */
		 public function pl_send() {
			$ids = $_REQUEST['ids'];
			
			if(empty($ids)) {
				exit(json_encode(array('status'=>-1,'msg'=>'operation Failed')));
			}

			$time = time();
			$sql = "update order_info set status =5,shipping_time='{$time}' where id in ($ids)";
			$this->model->query($sql);

			$sql = "update taoyizhang_wbsd1415_resit_goods_stock gs,taoyizhang_wbsd1415_resit_order_goods og
					set gs.actual_quantity = gs.actual_quantity-og.goods_number,gs.lock_quantity=gs.lock_quantity-og.goods_number
					where og.goods_id=gs.goods_id and og.size_id=gs.size_id and og.color_id=gs.color_id
					and og.warehouse_id = gs.warehouse_id
					and og.order_id in ($ids)";
			$this->model->query($sql);
			exit(json_encode(array('status'=>0,'msg'=>'operation success')));

		 }

	  
}