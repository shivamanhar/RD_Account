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
        if($row->dob == 0)
        {
            $dob = date('d-m-Y');
        }
        else
        {
            $data = date('d-m-Y',$row->dob);
        }
        $mobile_no = $row->mobile_no;
        $address = $row->address;
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
                    <?php if(isset($user_message)){echo $user_message;}?>
                    <div class="col-md-12">
                              <?php  if(isset($error)){print_r($error);}?>
                              <?php echo form_open_multipart('welcome/edit_depositer');?>
                              
                    <table>
                              
                        <tr> <td class="col-md-2"></td><td class="col-md-4"></td><td class="col-md-4" rowspan="8"><br/><br/><br/><br/><br/><?php echo "<a href='",base_url().$sign_image."' target='_blank'> <img src ='",base_url().$thumbs."' style='margin-left: 140px;'></a>"; ?><br/><input type="file" name="userfile" class="fileUpload btn btn-primary"></td></tr>
                        <tr> <td class="col-md-2">Name:</td><td class="col-md-4"><input type="text" name="name" style="width:100%" value="<?php if(isset($name)){echo $name;}?>"><?php echo "<br/>",form_error('name');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Father's Name:</td><td class="col-md-4"><input type="text" name="father_name" value="<?php if(isset($father_name)){echo $father_name;}?>"><?php echo "<br/>",form_error('father_name');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Husband Name:</td><td class="col-md-4"><input type="text" name="husband_name" value="<?php if(isset($husband_name)){echo $husband_name;}?>"><?php echo "<br/>",form_error('husband_name');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Mother Name:</td><td class="col-md-4"><input type="text" name="mother_name" value="<?php if(isset($mother_name)){echo $mother_name;}?>"><?php echo "<br/>",form_error('mother_name');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Nominee Name:</td><td class="col-md-4"><input type="text" name="nominee_name" value="<?php if(isset($nominee_name)){echo $nominee_name;}?>"><?php echo "<br/>",form_error('mother_name');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">DOB:</td><td class="col-md-4"><input type="text" name="dob" id="dob" value="<?php if(isset($dob)){echo $dob;}?>"><?php echo "<br/>",form_error('dob');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Mobile No:</td><td class="col-md-4"><input type="text" name="mobile_no" maxlength="10" value="<?php if(isset($mobile_no)){echo $mobile_no;}?>"><?php echo "<br/>",form_error('mobile_no');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Address:</td><td class="col-md-4"><input type="text" name="address" value="<?php if(isset($address)){echo $address;}?>"><?php echo "<br/>",form_error('address');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Opening Amount.:</td><td class="col-md-4"><input type="text" name="opening_amount" value="<?php echo $this->rd_func->get_value('opening_amount', $field_value); ?>" readonly><?php echo "<br/>",form_error('opening_amount');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">RD Amount:</td><td class="col-md-4"><input type="text" name="rd_amount" value="<?php if(isset($rd_amount)){echo $rd_amount;}?>"><?php echo "<br/>",form_error('rd_amount');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Account No.:</td><td class="col-md-4"><input type="text" name="account_no" value="<?php if(isset($account_no)){echo $account_no;}?>" readonly><?php echo "<br/>",form_error('account_no');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Open Date:</td><td class="col-md-4"><input type="text" name="deposit_date" id="deposit_date" value="<?php if(isset($account_oping_date)){echo $account_oping_date;}?>"><?php echo "<br/>",form_error('deposit_date');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Remark:</td><td class="col-md-4"><textarea  name="remark" rows="2" cols="40"><?php if(isset($remark)){echo $remark;}?></textarea><?php echo "<br/>",form_error('remark');?></td><td class="col-md-3"></td></tr>
                        <tr><td></td><td><input type="hidden" value="<?php if(isset($id)){echo $id;}?>" name="id"></td></tr>
                        <tr> <td class="col-md-2" colspan="2"></td><td class="col-md-4"><input type="submit" value="Edit"></td> <td class="col-md-3"></td></tr>
                    
                    
                    </table>
                    
                    
                              </form>
                    </div>
                    
                </div>
 </div>