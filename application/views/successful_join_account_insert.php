 <?php
 $id = NULL;
    foreach($add_record->result() as $row)
    {
        $id = $row->id;
        $name = $row->name;
        $father_name = $row->father_name;
        $mother_name = $row->mother_name;
        $husband_name = $row->husband_name;
        $nominee_name = $row->nominee_name;
        $dob = date('d-m-Y',$row->dob);
        $mobile_no = $row->mobile_no;
        $address = $row->address;
        $name1 = $row->name1;
        $father_name1 = $row->father_name1;
        $mother_name1 = $row->mother_name1;
        $husband_name1 = $row->husband_name1;
        $nominee_name1 = $row->nominee_name1;
        $dob1 = date('d-m-Y',$row->dob1);
        $mobile_no1 = $row->mobile_no1;
        $address1 = $row->address1;
        $account_oping_date = date('d-m-Y',$row->account_oping_date);
        $account_no = $row->account_no;
        $rd_amount = $row->rd_amount;
        $remark = $row->remark;
        $thumbs = $row->thumbs;
        $sign_image =$row->sign_image;
        
    }
    $field_value = array(
                         'depositor_id'=>$id,
                         );
 
 ?> 
 <div class="container">
                <div class="row dipositer">
                    
                    <div class="col-md-12">
                        <?php if(isset($user_message)){echo $user_message;}?>
                              <?php  if(isset($error)){print_r($error);}?>
                              <?php echo form_open_multipart('welcome/edit_join_account');?>
                              
                    <table>
                              
                        <tr> <th  colspan="2"><center> <h3> First Account Holder  </h3> </center> </th> <th></th><th colspan="4" class="col-md-6"><center> <h3> Second Account Holder </h3></center></th></tr>
                        <tr><td colspan="5"><hr/></td></tr>
                        <tr> <td class="col-md-2">Name:</td><td class="col-md-4"><input type="text" name="name" style="width:100%" value="<?php if(isset($name)){echo $name;}?>"><?php echo "<br/>",form_error('name');?></td><td ></td><td class="col-md-1">Name:</td><td class="col-md-5"> <input type="text" name="name1" style="width:100%" value="<?php if(isset($name1)){echo $name1;}?>"><?php echo "<br/>",form_error('name1');?> </td></tr>
                        <tr> <td class="col-md-2">Father's Name:</td><td class="col-md-4"><input type="text" name="father_name" value="<?php if(isset($father_name)){echo $father_name;}?>"><?php echo "<br/>",form_error('father_name');?></td><td ></td><td class="col-md-1">Father's Name:</td><td class="col-md-5"> <input type="text" name="father_name1" value="<?php if(isset($father_name1)){echo $father_name1;}?>"><?php echo "<br/>",form_error('father_name1');?> </td></tr>
                        <tr> <td class="col-md-2">Husband Name:</td><td class="col-md-4"><input type="text" name="husband_name" value="<?php if(isset($husband_name)){echo $husband_name;}?>"><?php echo "<br/>",form_error('husband_name');?></td><td ></td><td class="col-md-1">Husband Name:</td><td class="col-md-5"> <input type="text" name="husband_name1" value="<?php if(isset($husband_name1)){echo $husband_name1;}?>"><?php echo "<br/>",form_error('husband_name1');?> </td></tr>
                        <tr> <td class="col-md-2">Mother Name:</td><td class="col-md-4"><input type="text" name="mother_name" value="<?php if(isset($mother_name)){echo $mother_name;}?>"><?php echo "<br/>",form_error('mother_name');?></td><td></td><td class="col-md-1">Mother Name:</td><td class="col-md-5"> <input type="text" name="mother_name1" value="<?php if(isset($mother_name1)){echo $mother_name1;}?>"><?php echo "<br/>",form_error('mother_name1');?> </td></tr>
                        <tr> <td class="col-md-2">Nominee Name:</td><td class="col-md-4"><input type="text" name="nominee_name" value="<?php if(isset($nominee_name)){echo $nominee_name;}?>"><?php echo "<br/>",form_error('nominee_name');?></td><td ></td><td class="col-md-1">Nominee Name:</td><td class="col-md-5"> <input type="text" name="nominee_name1" value="<?php if(isset($nominee_name1)){echo $nominee_name1;}?>"><?php echo "<br/>",form_error('nominee_name1');?> </td></tr>
                        <tr> <td class="col-md-2">DOB:</td><td class="col-md-4"><input type="text" name="dob" id="dob" value="<?php if(isset($dob)){echo $dob;}?>"><?php echo "<br/>",form_error('dob');?></td><td class="col-md-1"></td><td >DOB:</td><td class="col-md-5"> <input type="text" name="dob1" value="<?php if(isset($dob1)){echo $dob1;}?>"  id="dob1" ><?php echo "<br/>",form_error('dob1');?> </td></tr>
                        <tr> <td class="col-md-2">Mobile No:</td><td class="col-md-4"><input type="text" name="mobile_no" maxlength="10" value="<?php if(isset($mobile_no)){echo $mobile_no;}?>"><?php echo "<br/>",form_error('mobile_no');?></td><td ></td><td class="col-md-1">Mobile No:</td><td class="col-md-5"> <input type="text" name="mobile_no1" maxlength="10" value="<?php if(isset($mobile_no1)){echo $mobile_no1;}?>"><?php echo "<br/>",form_error('mobile_no1');?> </td></tr>
                        <tr> <td class="col-md-2">Address:</td><td class="col-md-4"><input type="text" name="address" value="<?php if(isset($address)){echo $address;}?>"><?php echo "<br/>",form_error('address');?></td><td ></td><td class="col-md-2">Address:</td><td class="col-md-5"> <input type="text" name="address1" id="dob1" value="<?php if(isset($address1)){echo $address1;}?>"><?php echo "<br/>",form_error('address1');?> </td></tr>
                        <tr><td colspan="5"><hr/></td></tr>
                        <tr><td class="col-md-2"></td><td class="col-md-4"></td><td colspan="3" rowspan="4"> <br/><?php echo "<a href='",base_url().$sign_image."' target='_blank'> <img src ='",base_url().$thumbs."' style='margin-left: 140px;'></a>"; ?><br/> <br/><input type="file" name="userfile" class="fileUpload btn btn-primary"></td></tr>
                        <tr><td class="col-md-2">Opening Amount:</td> <td class="col-md-4"> <input type="text" name="opening_amount" value="<?php echo $this->rd_func->get_value('opening_amount', $field_value); ?>" readonly><?php echo "<br/>",form_error('opening_amount');?></td><td></td></tr>
                        <tr><td class="col-md-2">RD Amount:</td> <td class="col-md-4"> <input type="text" name="rd_amount" value="<?php if(isset($rd_amount)){echo $rd_amount;}?>"><?php echo "<br/>",form_error('rd_amount');?></td><td></td></tr>
                        <tr><td class="col-md-2">Account No:</td> <td class="col-md-4"> <input type="text" name="account_no" value="<?php if(isset($account_no)){echo $account_no;}?>" readonly><?php echo "<br/>",form_error('account_no');?></td><td></td></tr>
                        <tr><td class="col-md-2">Open Date:</td> <td class="col-md-4"> <input type="text" name="deposit_date" id="deposit_date"  value="<?php if(isset($account_oping_date)){echo $account_oping_date;}?>"><?php echo "<br/>",form_error('deposit_date');?></td><td></td></tr>
                        <tr><td class="col-md-2">Remark:</td> <td class="col-md-4"> <textarea  name="remark" rows="2" cols="40"><?php if(isset($remark)){echo $remark;}?></textarea><?php echo "<br/>",form_error('remark');?></td><td></td></tr>
                        <tr><td class="col-md-2"></td> <td class="col-md-4"> <input type="submit" value="Edit"></td><td></td></tr>
                        <tr><td><input type="hidden" value="<?php if(isset($id)){echo $id;}?>" name="id"></td></tr>
                    </table>
                    
                    
                              </form>
                    </div>
                    
                </div>
 </div>
 
 
 