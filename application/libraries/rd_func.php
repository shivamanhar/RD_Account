<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rd_Func
{
    function get_value($table_name, $field_value)
    {
        $ci =  & get_instance();
	$ci->load->model('logic');
        
        $get_opening_amount = $ci->logic->global_where('opening_amount', $field_value);
        if($get_opening_amount->num_rows() >=1)
        {
            foreach($get_opening_amount->result() as $row)
            {
                return $row->o_amount;
            }
        }
        else
        {
            return NULL;
        }
    }
    function is_join_account($account_no)
    {
        $ci =  & get_instance();
	$ci->load->model('logic');
        $field_value = array(
                             'account_no'=>$account_no,
                             'join_account'=>1
                             );
        $get_opening_amount = $ci->logic->global_where('account_holder', $field_value);
        if($get_opening_amount->num_rows() >=1)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    function penalty_cal($depositor_id, $lot_date =NULL)
    {
	
	$ci =  & get_instance();
	$ci->load->model('logic');
		$dbmonth ='';
		$deposit_amount_record = $ci->logic->cal_month("deposit_amount.depositor_id", $depositor_id);
		$d = date('d', $lot_date);
		
		
		if($d<=15)
		{
			$d = 1;
		}
		else
		{
			$d = 16;
		}
		$m = date('m', $lot_date);
		$y = date('Y', $lot_date);
		
		$session_date = strtotime($d.'-'.$m.'-'.$y);
		if($deposit_amount_record->num_rows() <=0)
		{
			return 0;
		}
		else
		{
			
			$deposit_amount = $ci->logic->cal_month("account_holder.id", $depositor_id);
			
			foreach($deposit_amount->result() as $row)
			{
				$dbmonth = $row->month;
				
			}
			foreach($deposit_amount ->result() as $row)
			{
				$db_opening_date =  $row->account_oping_date;
				$d = date('d', $db_opening_date);
				
				$m = date('m', $db_opening_date);
				$y = date('Y', $db_opening_date);
				$db_opening_date = strtotime($d.'-'.$m.'-'.$y);
			}
			
				$datetime1 = new DateTime(date('Y-m-d', $dbmonth));
				$datetime2 = new DateTime(date('Y-m-d', $session_date));
				$interval = $datetime1->diff($datetime2)->m;
				if($interval >= 1)
				{
					
					return array('interval'=>$interval, 'dbmonth'=>$dbmonth);
					
				}
				else
				{
					return array('interval'=>$interval, 'dbmonth'=>$dbmonth);
				}
		}
	}
}