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
                                             $agent_address =  $row->agent_address;
                                             $agent_code = $row->agent_code;
                                             $valid_up_to = $row->valid_up_to;
                                             $limit = $row->limit;
                                             $pan = $row->pan;
                              }
                        }
                        $field_value 		= array(
						'lot_no'=>$this->session->userdata('lot_no'),
						'batch_no'=>$this->session->userdata('batch_no'),
						);
 $total_def	= $this->logic->get_total_def($field_value);
 foreach($total_def->result() as $row)
 {
               $def_amount = $row->def;
 }
 ?>
<div class="container">
               <div class="row">
                              <div style="float:left" class="print_area">
                                               <p>FORM ASLAAS-6</p>
                                                            <h5>SCHEDULE FOR DEPOSIT IN PO RD ACCOUNT (PO-Bagbahara)</h5>
                                                            <p> NB: Separate proforma should bd used for 5-years Post Office RD Account </p>
                                                            <p>Month : <?php if($this->session->userdata('lot_date')) {echo date('M-Y', $this->session->userdata('lot_date'));} ?> / Lot Date: <?php if($this->session->userdata('lot_date')) {echo date('d-M-Y', $this->session->userdata('lot_date'));} ?></p>
							  
							    <h6><?php if(isset($agent_name)){echo "Agent Name  :".$agent_name;}?></h6>
                                                            <h6><?php if(isset($agent_address)){echo "Agent Address  :".$agent_address;}?></h6>
                                                            <p><?php if(isset($agent_code)){echo "Agent Code  :".$agent_code;}?>  / <?php if(isset($valid_up_to)){echo "Valid Up To  :".$valid_up_to;}?> </p>
                                                          
                                                            <samp> <?php if(isset($limit)){echo "<b>Limit  : </b>".$limit;}?></samp>
                                                            <samp><?php if(isset($pan)){echo "   <b>PAN : </b>".$pan;}?></samp>
                                                            <br/>
                                                            <br/>
                              </div>
                              <div style="float:right" class="print_area">
                                              <table>
                                                                                          <tr><td style="text-align:left">Gross Deposits :</td> <td style="text-align:right" id = "total_deposit"><?php if(isset($total_deposit)){echo number_format($total_deposit,2,".","," );}?></td></tr>
                                                                                          <tr><td style="text-align:left">Commission :</td> <td style="text-align:right" id="commission"><?php if(isset($commission)){echo number_format($commission,2,".","," );}?> </td></tr>
                                                                                          <tr><td style="text-align:left">Net Tendered Amt. :</td> <td style="text-align:right" id="net_tendered_amt"><?php if(isset($net_tendered_amt)){echo number_format($net_tendered_amt,2,".","," );}?></td></tr>
                                                                                          <tr><td style="text-align:left">TDS :</td> <td style="text-align:right" id="tds"><?php if(isset($tds)){echo number_format($tds,2,".","," );}?></td></tr>
                                                                                          <tr style="border:1px solid #000"><td style="text-align:left" id="net_amount">Net Amount :</td> <td style="text-align:right"><?php if(isset($net_amount)){echo number_format($net_amount,2,".","," );}?> </td></tr>
                                                                                          
                                                                                          <tr><td></td><td>&nbsp;</td></tr>
                                                                                          <tr><td></td><td>&nbsp;</td></tr>
                                                                                          <tr><td style="text-align:left">Lot Number :</td> <td style="text-align:right" ><?php if($this->session->userdata('lot_no')) {echo  $this->session->userdata('lot_no');} ?></td></tr>
                                                                                          <!-- <tr><td style="text-align:left">Lot Date :</td> <td style="text-align:right" ><?php //if($this->session->userdata('lot_date')) {echo date('d-M-Y', $this->session->userdata('lot_date'));} ?></td></tr> -->
                                                                                         
                                             </table>
                                            
                              </div>
               </div>
</div>

 <div class="container">
                <div class="row dipositer">
                              <div class="print_block">
                              <h4 style="margin:0px"> Deposit Amount Form  <samp style="color:#c60000;font-weight:bold;font-size:20px;"> <?php if($this->session->userdata('lot_date')) {echo "Current Lot Date ", date('d-M-y', $this->session->userdata('lot_date'));} ?> <?php if($this->session->userdata('lot_no')) {echo  " And Lot No. ".$this->session->userdata('lot_no');} ?> </samp>
                              
                              <samp style="color:#009325;font-weight:bold;font-size:20px;"> <?php if(isset($_GET['message'])){ echo "(".$_GET['message'].")";}?> <?php echo form_error('lot_no');?></samp>
                              
                              </h4>
                                             <form action="<?php echo base_url();?>welcome/deposit_date" method="post">
                                             
                                            <table class="table-bordered">
                                                   <tr>
                                                            <td class="col-md-3" style="text-align:center">
                                                                           <?php echo form_error('lot_date');?>
                                                            <input type="text" id ="lot_date" name="lot_date" value="<?php if($this->session->userdata('lot_date')) {echo date('d-m-Y', $this->session->userdata('lot_date'));} ?>">
                                                            
                                                            </td>
                                                            <td class="col-md-3" style="text-align:left;">
								 <span class="print_block"> Batch No. <input type="text" name="batch_no" style="width:45%" value="<?php if($this->session->userdata('batch_no')) {echo  $this->session->userdata('batch_no');} ?>"></span>
								  <br/>
								  <br/>
								  Lot No. &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="lot_no" style="width:45%" value="<?php if($this->session->userdata('lot_no')) {echo  $this->session->userdata('lot_no');} ?>">
                                                            <input type="submit" value="Save" onclick="confirmation();" class="btn btn-primary">
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
                              <form action="<?php echo base_url();?>welcome/deposit" method="post" >
                              <table >
                                          
                                             
                                             <tr>
                                                            <th>Sr.No. </th>
                                                            <th class="col-md-4">Depositor's Name</th>
                                                            <th class="col-md-1">Amount Deposited</th>
                                                            <th class="col-md-1">A/c No.</th>
                                                            <th class="col-md-1">Balance</th>
                                                            <th class="col-md-4" style="text-align:center">Month</th>
                                                            <th class="col-md-1">Def</th>
                                                            <!--<th class="col-md-2 open_date">Open Date</th>-->
                                                            <th class="col-md-1 remark">Remark / KYC</th>
                                                            <th class="print_block"></th>
                                             </tr>
                                             
                                               <?php
					       $dblotid='';
					       $field_value = array(
						'lot_no' => $this->session->userdata('lot_no'),
						'lot_agent_code'=>$this->tank_auth->get_user_id(),
						'batch_no'=>$this->session->userdata('batch_no')
						);
						$rows = $this->logic->global_where('lot_detail', $field_value);
						if($rows->num_rows() > 0)
						{
							foreach($rows->result() as $row)
							{
								$dblotid = $row->id;
							}
						}
					       
                                               $where_field = array(
                                                                    'lot_id' =>$dblotid,
                                                                    'agent_id' =>$this->tank_auth->get_user_id(),
                                                                    );
					     
                                               $join_record = $this->logic->where_join($where_field);					       
                                               $sr_no = 1;
                                             foreach($join_record->result() as $row)
                                             {
                                                            ?>
                                                            <tr>
                                                            <td style="text-align:left"><?php echo $sr_no; ?></td>
                                                            <td class="col-md-4"><?php echo ucwords($row->name); ?></td>
                                                            <td class="col-md-1" style="text-align:right"><?php echo $row->amount_deposited; ?></td>
                                                            <td class="col-md-1"><?php echo $row->account_no; ?></td>
                                                            <td class="col-md-1" style="text-align:right"><?php echo $row->balance; ?></td>
                                                           
                                                            <td class="col-md-2" style="text-align:center">
                                                            
                                                            <?php
							    
									$get_value = $this->logic->global_where('def', array('lot_id'=>$dblotid , 'account_no'=>$row->id));
									$def_check='';
									if($get_value->num_rows>0)
									{
									        foreach($get_value->result() as $db_def)
									      {
										     $db_start_month = $db_def->start_date;
										     "<Br/>";
										    $db_end_month = $db_def->end_date;
										    $def_check = $db_def->def;
										    $adv_amount = $db_def->adv_amount;
									      }
									      
									      $d1 = $db_start_month ;
									      $d2 = $db_end_month;
									      $interval = abs((date('Y', $d2) - date('Y', $d1))*12 + (date('m', $d2) - date('m', $d1)));
									      
									      if(($def_check ==0) AND($adv_amount==0))
									      {
										    echo "-";
									      }
									      else
									      {
										    if($def_check >1)
										    {										    
											  echo "<b>Def</b><br/>";
											  if(date('m-y',$db_start_month) == date('m-y',$db_end_month))
											  {
												echo date('M-Y', $db_start_month);	
											  }
											  else
											  {
												echo date('M-Y', $db_start_month)." To ".date('M-Y', $db_end_month);
											  }
										    }
										    else
										    {
											  if($adv_amount >= 1)
											  {
												echo "<b>Advance </b><br/>";
												if(date('m-y',$db_start_month) == date('m-y',$db_end_month))
												{
												echo date('M-Y', $db_start_month);	
												}
												else
												{
												echo date('M-Y', $db_start_month)." To ".date('M-Y', $db_end_month);
												}
											  }
										    }
									      }
									}else
									{
									      echo "-";
									}
							
							    ?>
                                                            </td>
                                                          
                                                            
                                                            <td class="col-md-1"><?php if($row->def == 0) {echo "-";} else {echo $row->def;} ?></td>
                                                            <!-- <td class="col-md-2 open_date"><?php //echo date('d-m-Y',$row->account_oping_date); ?></td>-->
                                                            <td class="col-md-1 remark"><?php echo $row->dep_remark; ?></td>
                                                            <td class="print_block"><a href="<?php echo base_url()."welcome/delete_amount/".$row->d_id."/".$row->depositor_id; ?>"> <i class="fa fa-minus-circle delete"></i> </a></td>
                                                            </tr>
                                                         <?php 
                                                      $sr_no++;   
                                                            
                                             }
                                                            if($join_record->num_rows() >= 1)
                                                            {
                                                                           ?>
									   
                                                            <tr>
                                                            <td class="col-md-1" colspan="2" style="text-align:center"></td>
                                                            <td class="col-md-1" colspan="1" style="text-align:right"><input type="text" name="total_deposit" value="<?php if(isset($total_deposit)){echo $total_deposit;}?>"id = "total_deposit" style="text-align:right" readonly ></td>
                                                            <td class="col-md-1 " colspan="3"></td>
							    <td class="col-md-1 "><?php if(isset($def_amount)){echo $def_amount; }?>  </td>
							    <td class="col-md-1 " colspan=""></td>
                                                            <td class="print_block"></td>
                                                            </tr>               
                                                            <tr>
                                                            <td class="col-md-1" colspan="2" style="text-align:center"><b> Total: </b></td>
                                                            <td class="col-md-1" colspan="1" style="text-align:right"><input type="text" name="total_deposit" value="<?php if(isset($total_deposit)){echo $total_deposit;}?>"id = "total_deposit" style="text-align:right" readonly ></td>
                                                            <td class="col-md-1 " colspan="5"> <samp class="number"> <?php if(isset($total_deposit)){echo $total_deposit;}?></samp> <?php if(isset($total_deposit)){echo " <samp>Only </samp>";}?> </td>
                                                            <td class="print_block"></td>
                                                            </tr>
                                                                           
                                                                           <?php
                                                            }
                                             ?>
                                             <?php
                                             if(form_error('amount_deposited') != NULL)
                                             {
                                                            echo "<tr><td colspan='8'>",form_error('amount_deposited')," , " ,form_error('depositor_id'), "</td></tr>"; 
                                             }
                                             
                                             ?>
                                                            <input type="hidden" id="depositor_id" name="depositor_id">
                                                            <input type="hidden"  name="adv" value="<?php if(isset($_GET['adv'])) {echo $_GET['adv'];}?>">
                                                            <tr class="print_block">
                                                                           <td></td>
                                                                           <td class="col-md-4"><input type="text" name="depositor_name" id="depositor_name" readonly ></td>
                                                                           <td class="col-md-1" style="text-align:right"><input type="text" name="amount_deposited" id="amount_deposited" style="text-align:right"></td>
                                                                           <td class="col-md-1" ><input type="text" name="account_number" id="acount_number"></td>
                                                                           <td class="col-md-1" style="text-align:right"><input type="text" name="balance" id="balance" style="text-align:right" readonly ></td>
                                                                           <td class="col-md-2" style="text-align:center">
                                                                                          <?php 
                                                                                          if($this->input->get('adv') ==1)
                                                                                          {
                                                                                                         ?>
                                                                                              Advance           
                                                                                          <input type="text" name="adv_month" id="adv_month1" readonly> <br> To <br>
											  <input type="hidden" name="find_adv" value="<?php echo $this->input->get('adv');?>">
											  
											  <input type="hidden" name="session_date" value="<?php echo date('d-M-Y', $this->session->userdata('lot_date')); ?>">
                                                                                          <?php 
                                                                                          }
                                                                                          ?>
											  <input type="hidden" name="adv_calcul" >
                                                                                          <span id="adv_text"></span>
											  
                                                                                          <input type="text" name="month" class="month" id="month"></td>
                                                                           <td class="col-md-1"><input type="text" name="def" id="def" ></td>
                                                                          <!-- <td class="col-md-2 open_date"><input type="text" name="open_date" id="open_date" readonly></td>-->
                                                                           <td class="col-md-1 remark"><input type="text" name="remark"></td>
                                                                           <td class="print_block"></td>
                                                            </tr>
                                                            <tr class="print_block">
                                                                           <td colspan="8">
									      <input type="hidden" name="last_payment" value="<?php ?>">
                                                                                          <input type="submit" value="Save / Deposit"  class="btn btn-primary"> <button class="btn btn-info"> <a href="<?php echo base_url();?>welcome/deposit_form?adv=1"> Advance Deposit </a></button> <button class="btn btn-info"> <a href="<?php echo base_url();?>welcome/deposit_form?adv=0"> Current Deposit </a></button>  <input type="button" class="btn btn-success" value="Print" onclick="window.print();">
                                                                           </td>
                                                                           <td class="print_block"></td>
                                                            </tr>
                                             </table>
                                             </form>
                              </div>
                             
                </div>
 </div>
 
 <div class="container">
      <hr/>
      <div class="row">
	    <div class="col-md-3">
		  <p> Total No. Of Passbook     :<?php echo ($sr_no-1);?></p>
	    </div>
	    <div class="col-md-4">
		  
	    </div>
      </div>
     
      <div class="row">
               
	    <div class="col-md-3">
		 <p> Total Def. Amount           :<?php if(isset($def_amount)){echo $def_amount; }?> </p>
	    </div>
	   
      </div>
      <div class="row">
	    <div class="col-md-3">
		 <!-- Total No. Of Passbook -->
	    </div>
	    <div class="col-md-4">
		  <?php //echo $sr_no;?>
	    </div>
      </div>
      <hr/>
 </div>
 
 
 
<div class="container">
               <br/>
               <br/>
              
               <div class="row">
                              <div style="float:left" class="print_area">
                                             
                              </div>
                              <div style="float:right" class="print_area">
                                            <center>
                                              Seal AND Signaute of Agent <br/>
                                              <?php if(isset($agent_name)){echo $agent_name;}?>
                                            </center>
                              </div>
               </div>
</div>
<div class="container">
               
              
              
               <div class="row">
                              <div style="float:left" class="print_area">
                                     <br/>
                                      <center>
                                             <h4>CERTIFICATE OF POST OFFICE</h4>
                                              It is certified that a total sum of Rs.  <?php if(isset($total_deposit)){echo number_format($total_deposit,2,".","," ) ;}?>  (<samp class="number"> <?php if(isset($total_deposit)){echo $total_deposit;}?> </samp> Only ) has been received and deposited credited as shown above in the PR RD Account Pass Books of the investor's Concerned. 
                                      </center>
                              </div>
                             
               </div>
</div>


<div class="container">
               <br/>
               <br/>
              <br/>
               <div class="row">
                              <div style="float:left" class="print_area">
                                             
                              </div>
                              <div style="float:right" class="print_area">
                                            <center>
                                              Signature of Post Master<br/>
                                              Seal of the Post Office
                                            </center>
                              </div>
               </div>
</div>


