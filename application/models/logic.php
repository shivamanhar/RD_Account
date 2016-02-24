<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logic extends CI_Model
{
	function global_insert($table_name, $data)
        {
            $this->db->insert($table_name, $data);
            return mysql_insert_id();
        }
        
        function global_where($table_name, $field_value)
        {
            $this->db->where($field_value);
            return $this->db->get($table_name);
        }
	
            
	function global_get_desc($table_name, $field_where, $order_field,$order_by='desc')
	{
		$this->db->select( '*');		
		$this->db->where($field_where);
		$this->db->order_by($order_field, $order_by);
		$this->db->limit(1,1);
		return $this->db->get($table_name);
	}
        function global_delete($table_name, $field_where)
        {
            $this->db->where($field_where);
            $this->db->delete($table_name); 
        }
        function global_where_limit($table_name, $field_value, $start, $end)
        {
            $this->db->where($field_value);
            $this->db->limit($start, $end);
            return $this->db->get($table_name);
        }
	function global_set($table_name, $field_where, $data)
	{
		$this->db->where($field_where);
		$this->db->update($table_name, $data);
		return mysql_insert_id();
	}
	/* like query */
	   function global_like($table_name, $field_value, $like_field, $like_value)
        {
		$this->db->like($like_field, $like_value, 'both'); 
		$this->db->where($field_value);
		return $this->db->get($table_name);
        }
        function global_like_limit($table_name, $field_value, $start, $end,  $like_field, $like_value)
        {
            $this->db->where($field_value);
	    $this->db->like($like_field, $like_value, 'both'); 
            $this->db->limit($start, $end);
            return $this->db->get($table_name);
        }  
	  
        function global_update($table_name,  $field_where, $data)
        {
            $this->db->where($field_where);
            $this->db->update($table_name, $data);
            return $this->db->affected_rows();
        }
	
        function where_join($field_value)
        {
            $this->db->select( 'account_holder.*, deposit_amount.*, lot_detail.*,  opening_amount.*, opening_amount.depositor_id as dep_id, deposit_amount.remark as dep_remark, deposit_amount.id as d_id');
            $this->db->from('users');
            $this->db->join('account_holder', 'account_holder.agent_id = users.id', 'left');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = account_holder.id','left');
            $this->db->join('opening_amount', 'opening_amount.depositor_id =account_holder.id', 'left');
            $this->db->join('lot_detail', 'lot_detail.id = deposit_amount.lot_id', 'left');
	   // $this->db->join('def', 'def.dep_id = deposit_amount.id', 'left');
            $this->db->where($field_value);
            return $this->db->get();
        }
        function where_join_limit($field_value, $start, $end)
        {
            $this->db->select( 'account_holder.*, deposit_amount.*, lot_detail.*, opening_amount.*, opening_amount.depositor_id as dep_id, deposit_amount.remark as dep_remark');
            $this->db->from('users');
            $this->db->join('account_holder', 'account_holder.agent_id = users.id', 'left');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = account_holder.id','left');
            $this->db->join('opening_amount', 'opening_amount.depositor_id =account_holder.id', 'left');
            $this->db->join('lot_detail', 'lot_detail.id = deposit_amount.lot_id', 'left');
            $this->db->where($field_value);
            $this->db->limit($start, $end);
            return $this->db->get();
 
        }
        /*join opeing amount and deposit amount */
        function get_amount($field, $value, $sum_filed)
        {
            //$this->db->select('deposit_amount.*');
            
            $this->db->select_sum($sum_filed);
            $this->db->from('opening_amount');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = opening_amount.depositor_id');
            $this->db->where($field, $value);
            return $this->db->get();
        }
        /*get lot amount */
        function get_lot_amount($field, $lot_id)
        {
            $this->db->select_sum('amount_deposited');
            $this->db->from('deposit_amount');
            $this->db->join('lot_detail','lot_detail.id=deposit_amount.lot_id');
            $this->db->where($field, $lot_id);
            return $this->db->get();
        }
        function get_total_def($field_value)
        {
             $this->db->select_sum('def');
            $this->db->from('deposit_amount');
            $this->db->join('lot_detail','lot_detail.id=deposit_amount.lot_id');
            $this->db->where($field_value);
            return $this->db->get();
        }
        
        /* calculation of month */
        function cal_month($field, $value)
        {
            $this->db->select('deposit_amount.*, account_holder.*, opening_amount.*');
            $this->db->from('account_holder');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = account_holder.id', 'left');
            $this->db->join('opening_amount', 'opening_amount.depositor_id = account_holder.id', 'left');
            $this->db->where($field, $value);
            $this->db->order_by('deposit_amount.id', 'desc');
            $this->db->limit(1);
            return $this->db->get();
        }
        /*Total Default Data*/
	function total_default_data($where_field)
	{
		$this->db->select('account_holder.*, def.*, deposit_amount.*' );
		$this->db->from('def');
		$this->db->join('account_holder', 'account_holder.id=def.account_no','left');
		$this->db->join('deposit_amount', 'deposit_amount.id=def.dep_id','left');		
		$this->db->where($where_field);
		return $this->db->get();
	}
	 /*default calculation */
	function default_data($where_field, $start, $end)
	{
		$this->db->select('account_holder.*, def.*, deposit_amount.*, account_holder.account_no as acno' );
		$this->db->from('def');
		$this->db->join('account_holder', 'account_holder.id=def.account_no','left');
		$this->db->join('deposit_amount', 'deposit_amount.id=def.dep_id','left');
		$this->db->where($where_field);
		$this->db->limit($start, $end);
		return $this->db->get();
	}
	
	/*get batch list*/
	function get_total_batch($where_field)
	{
		$this->db->where($where_field);
		$this->db->group_by("batch_no"); 
		return $this->db->get("lot_detail");
	}
	/*get batch list*/
	function get_batch($where_field, $start, $end)
	{
		$this->db->where($where_field);
		$this->db->group_by("batch_no");
		$this->db->limit($start, $end);
		return $this->db->get("lot_detail");
	}
}

/* End of file welcome.php */
/* Location: ./application/models/logic.php */