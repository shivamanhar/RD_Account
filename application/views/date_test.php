<?php
$field_value = array(
                              'userid'=> $this->tank_auth->get_user_id(),
                              
                     );
$get_record = $this->logic->global_where('agent_detail', $field_value);

if($get_record->num_rows() >= 1)
			{
                              foreach($get_record->result() as $row)
                              {
                                             $agent_name =  $row->agent_name;
                                             $agent_code = $row->agent_code;
                                             $valid_up_to = $row->valid_up_to;
                                             $limit = $row->limit;
                                             $pan = $row->pan;
                              }
                        }
 ?>
<div class="container">
            <div class="row dipositer">
		  <h4 style="margin:0px"> Deposit Amount Form  <samp style="color:#c60000;font-weight:bold;font-size:20px;"> <?php if($this->session->userdata('lot_date')) {echo "Current Lot Date ", date('d-M-y', $this->session->userdata('lot_date'));} ?> <?php if($this->session->userdata('lot_no')) {echo  " And Lot No. ".$this->session->userdata('lot_no');} ?> </samp>
                              
                              <samp style="color:#009325;font-weight:bold;font-size:20px;"> <?php if(isset($_GET['message'])){ echo "(".$_GET['message'].")";}?></samp>
                              
                  </h4>
                                             <form action="<?php echo base_url();?>welcome/deposit_date" method="post">
                                             
                                            <table class="table-bordered">
                                                   <tr>
                                                            <td class="col-md-3" style="text-align:center">
                                                            <input type="text" id ="lot_date" name="lot_date" value="<?php if($this->session->userdata('lot_date')) {echo date('d-m-Y', $this->session->userdata('lot_date'));} ?>">
                                                            
                                                            </td>
                                                            <td class="col-md-3" style="text-align:center">Lot No. <input type="text" name="lot_no" style="width:45%" value="<?php if($this->session->userdata('lot_no')) {echo  $this->session->userdata('lot_no');} ?>">
                                                            <input type="submit" value="Save" >
                                                            </td>
                                                            <td class="col-md-1"></td>
                                                            <td class="col-md-5" id="detail">
                                                                           <table>
                                                                                          <tr><td style="text-align:left">Gross Deposits :</td> <td style="text-align:right" id = "total_deposit"><?php if(isset($total_deposit)){echo number_format($total_deposit,2,".","," );}?></td></tr>
                                                                                          <tr><td style="text-align:left">Commission :</td> <td style="text-align:right" id="commission"><?php if(isset($commission)){echo number_format($commission,2,".","," );}?> </td></tr>
                                                                                          <tr><td style="text-align:left">Net Tendered Amt. :</td> <td style="text-align:right" id="net_tendered_amt"><?php if(isset($net_tendered_amt)){echo number_format($net_tendered_amt,2,".","," );}?></td></tr>
                                                                                          <tr><td style="text-align:left">TDS :</td> <td style="text-align:right" id="tds"><?php if(isset($tds)){echo number_format($tds,2,".","," );}?></td></tr>
                                                                                          <tr style="border:1px solid #000"><td style="text-align:left" id="net_amount">Net Amount :</td> <td style="text-align:right"><?php if(isset($net_amount)){echo number_format($net_amount,2,".","," );}?> </td></tr>
                                                                           </table>
                                                            </td>
                                                   </tr>
                                            </table>
                                             </form>
               
                             
            </div>
	    <div class="col-md-12">
		  <form action="<?php echo base_url();?>welcome/test2" method="post" >
                              <table class="table-bordered">
				    <tr>
                                                            <th class="col-md-1">A/c No.</th>
                                                            <th class="col-md-4">Depositor's Name</th>
                                                            <th class="col-md-1">Amount Deposited</th>
                                                            <th class="col-md-1">Balance</th>
                                                            <th class="col-md-2" style="text-align:center">Month</th>
                                                            <th class="col-md-1">Def</th>
                                                            <th class="col-md-2 open_date">Open Date</th>
                                                            <th class="col-md-1 remark">Remark / KYC</th>
                                    </tr>
			      </table>		    
	    
		  <input type="text" name="month" id="month" value="<?php if($this->session->userdata('lot_date')) {echo date('M-Y', $this->session->userdata('lot_date'));} ?>">
		  <input type="submit" value="Save / Deposit"> <input type="button" class="btn btn-success" value="Print" onclick="window.print();">
	    </form>