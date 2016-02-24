<?php
 $id = NULL;
    foreach($get_record->result() as $row)
    {
      $name = $row->name;
      $father_name = $row->father_name;
      $husband_name = $row->husband_name;
      $mother_name= $row->mother_name;
      $nominee_name = $row->nominee_name;
      $dob = date('d/m/Y', $row->dob);
      $mobile_no = $row->mobile_no;
      $address = $row->address;
      $account_oping_date = date('d/m/Y',$row->account_oping_date);
      $account_no = $row->account_no;
      $rd_amount = $row->rd_amount;
      $sign_image = $row->sign_image;
      $thumbs = $row->thumbs;
      $remark = $row->remark;
      
    }
         $field_value = array(
                         'depositor_id'=>$id,
                         );
?>
  <div class="container">
    <div class="row">
        <h3> Depositer Detail </h3>
    </div>
    <div class="row dipositer">
        <div class="col-md-12">
         <table>
                              
                        <tr> <td class="col-md-2"></td><td class="col-md-4"></td><td class="col-md-4" rowspan="8"><br/><br/><br/><br/><br/><br/><?php echo "<a href='",base_url().$thumbs."' target='_blank'> <img src ='",base_url().$thumbs."'>"; ?></td></tr>
                        <tr> <td class="col-md-2">Name:</td><td class="col-md-4"><input type="text" name="name" value = '<?php if(isset($name)){echo $name;}?>' style="width:100%" readonly><?php echo "<br/>",form_error('name');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Father's Name:</td><td class="col-md-4"><input type="text" name="father_name" value = '<?php if(isset($father_name)){echo $father_name;}?>' readonly><?php echo "<br/>",form_error('father_name');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Husband Name:</td><td class="col-md-4"><input type="text" name="father_name" value = '<?php if(isset($husband_name)){echo $husband_name;}?>' readonly><?php echo "<br/>",form_error('father_name');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Mother Name:</td><td class="col-md-4"><input type="text" name="mother_name" value = '<?php if(isset($mother_name)){echo $mother_name;}?>' readonly><?php echo "<br/>",form_error('mother_name');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Nominee Name:</td><td class="col-md-4"><input type="text" name="nominee_name" value = '<?php if(isset($nominee_name)){echo $nominee_name;}?>' readonly><?php echo "<br/>",form_error('mother_name');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">DOB:</td><td class="col-md-4"><input type="text" name="dob" value = '<?php if(isset($dob)){echo $dob;}?>' readonly><?php echo "<br/>",form_error('dob');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Mobile No:</td><td class="col-md-4"><input type="text" name="mobile_no" maxlength="10" value = '<?php if(isset($mobile_no)){echo $mobile_no;}?>' readonly><?php echo "<br/>",form_error('mobile_no');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Address:</td><td class="col-md-4"><input type="text" name="address" value = '<?php if(isset($address)){echo $address;}?>' readonly><?php echo "<br/>",form_error('address');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Opening Amount.:</td><td class="col-md-4"><input type="text" name="opening_amount" value="<?php echo $this->rd_func->get_value('opening_amount', $field_value); ?>" readonly><?php echo "<br/>",form_error('opening_amount');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">RD Amount:</td><td class="col-md-4"><input type="text" name="rd_amount"  value = '<?php if(isset($rd_amount)){echo $rd_amount;}?>' readonly><?php echo "<br/>",form_error('rd_amount');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Account No.:</td><td class="col-md-4"><input type="text" name="account_no"  value = '<?php if(isset($account_no)){echo $account_no;}?>' readonly><?php echo "<br/>",form_error('account_no');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Open Date:</td><td class="col-md-4"><input type="text" name="deposit_date" value = '<?php if(isset($account_oping_date)){echo $account_oping_date;}?>' readonly><?php echo "<br/>",form_error('deposit_date');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Remark:</td><td class="col-md-4"><textarea  name="remark" rows="2" cols="40" readonly><?php if(isset($remark)){echo $remark;}?> </textarea><?php echo "<br/>",form_error('remark');?></td><td class="col-md-3"></td></tr>
                        
        </table>
                    
        </div>
    </div>
  </div>