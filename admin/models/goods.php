<?php
/**
 *goods base class
 *
 */
class models_goods extends models_base{

	/**
	 *add  actual  stock 
	 *
	 */
	 public function add_actual_stock($params) {
		if(empty($params['warehouse_id']) || empty($params['goods_id']) || empty($params['color_id']) || empty($params['size_id'])) {
			throw new Exception('params error');
		}
		if(empty($params['goods_number'])) {
			throw new Exception('params error');
		}
		$sql = "select count(*) from taoyizhang_wbsd1415_resit_goods_stock where warehouse_id='{$params['warehouse_id']}'
				and goods_id='{$params['goods_id']}' and color_id='{$params['color_id']}'
				and size_id='{$params['size_id']}'";
		if($this->getOne($sql)) {
			$sql = "update taoyizhang_wbsd1415_resit_goods_stock set actual_quantity =actual_quantity+{$params['goods_number']} where
					warehouse_id='{$params['warehouse_id']}' and goods_id='{$params['goods_id']}' and color_id='{$params['color_id']}'
					and size_id='{$params['size_id']}'";
			return $this->query($sql);
		}else {
			return $this->table('taoyizhang_wbsd1415_resit_goods_stock')->insert(array(
				'goods_id'=>	$params['goods_id'],
				'size_id'=>   $params['size_id'],
				'color_id'=>   $params['color_id'],
				'warehouse_id'=> $params['warehouse_id'],
				'actual_quantity'=> $params['goods_number']
			));
		}
	 }

	 /**
	  *add  lock   stock 
	  *
	  */
	  public function add_lock_stock($params) {
			if(empty($params['warehouse_id']) || empty($params['goods_id']) || empty($params['color_id']) || empty($params['size_id'])){
				throw new Exception('params error');
			}
			if(empty($params['goods_number'])) {
				throw new Exception('params error');
			}
			$sql = "select count(*) from taoyizhang_wbsd1415_resit_goods_stock where warehouse_id='{$params['warehouse_id']}'
				and goods_id='{$params['goods_id']}' and color_id='{$params['color_id']}'
				and size_id='{$params['size_id']}'";
			if($this->getOne($sql)) {
				$sql = "update taoyizhang_wbsd1415_resit_goods_stock set lock_quantity =lock_quantity+{$params['goods_number']} where
						warehouse_id='{$params['warehouse_id']}' and goods_id='{$params['goods_id']}' and color_id='{$params['color_id']}'
						and size_id='{$params['size_id']}'";
				return $this->query($sql);
			}else {
				return $this->table('taoyizhang_wbsd1415_resit_goods_stock')->insert(array(
					'goods_id'=>	$params['goods_id'],
					'size_id'=>   $params['size_id'],
					'color_id'=>   $params['color_id'],
					'warehouse_id'=> $params['warehouse_id'],
					'lock_quantity'=> $params['goods_number']
				));
			}
	  }

	  /**
	   *order lock   stock 
	   *
	   */
	   public function order_add_lock_stock($order_id) {
		
			$sql = "select oi.shop_id,og.*
					from taoyizhang_wbsd1415_resit_order_info oi,order_goods og
					where oi.id=og.order_id and oi.id='{$order_id}'";
			$goods_arr = $this->getAll($sql);
			$ware_arr = $this->table('taoyizhang_wbsd1415_resit_shop_ware')->fetchAll(array(
				'where'=>array('shop_id'=>$goods_arr[0]['shop_id'])	,
				'order'=>array('level asc')
			));

			try{
				$this->startTransaction();
				$order_goods_ids = array();

				foreach($goods_arr as $goods) {
					$kc = 0;
					
					foreach($ware_arr as $ware) {
						$stock_data = $this->table('taoyizhang_wbsd1415_resit_goods_stock')->fetch(
							array(
								'where'=>array('goods_id'=>$goods['goods_id'],
												'size_id'=>$goods['size_id'],
												'color_id'=>$goods['color_id'],
												'warehouse_id'=>$ware['ware_id']
										)
							)	
						);
					//	print_r($stock_data);print_r($goods);exit;
						// stock  table
						if(empty($stock_data)) {
							 $this->table('taoyizhang_wbsd1415_resit_goods_stock')->insert(array(
								'goods_id'=>	$goods['goods_id'],
								'size_id'=>   $goods['size_id'],
								'color_id'=>   $goods['color_id'],
								'warehouse_id'=> $ware['ware_id']
							));
							 continue;
						 // lock  
						}elseif($stock_data['actual_quantity']-$stock_data['lock_quantity']<$goods['goods_number']) {  
							continue;	
						}else{
							//add  lock   stock 
							$sql = "update taoyizhang_wbsd1415_resit_goods_stock set lock_quantity =lock_quantity+{$goods['goods_number']}
									where warehouse_id='{$ware['ware_id']}' and goods_id='{$goods['goods_id']}' 
									and color_id='{$goods['color_id']}'
									and size_id='{$goods['size_id']}'";
						//	exit($sql);		
							$this->query($sql);
							
							//
							$sql = "update taoyizhang_wbsd1415_resit_order_goods set warehouse_id='{$ware['ware_id']}' where id='{$goods['id']}'";
							
							$this->query($sql);

							$kc = 1;
							break;
						}
						
					}
					
					if($kc == 0) {  //
						$order_goods_ids[] = $goods['id'];  //order_goods id
					}
					
				}
				
				if(!empty($order_goods_ids)) {
					throw new Exception('Not enough goods','-1');
				}

				$this->commit();
			}catch(Exception $e) {
				$this->rollback();
				//
				$this->table('taoyizhang_wbsd1415_resit_order_info')->update(array('id'=>$order_id),array('is_separate'=>1));
				foreach($order_goods_ids as $id) {
					$this->table('taoyizhang_wbsd1415_resit_order_goods')->update(array('id'=>$id),array('is_separate'=>1));
				}
			
			}

	   }

}