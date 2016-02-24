 <div class="container">
                <div class="row dipositer">
                    <div class="col-md-12">
                              <?php  if(isset($error)){print_r($error);}?>
                              <?php echo form_open_multipart('welcome/new_account');?>
                              
                    <table>
                              
                        <tr> <td class="col-md-2"></td><td class="col-md-4"></td><td class="col-md-4" rowspan="8"><br/><br/><br/><br/><br/><br/><input type="file" name="userfile" class="fileUpload btn btn-primary"></td></tr>
                        <tr> <td class="col-md-2">Name:</td><td class="col-md-4"><input type="text" name="name" style="width:100%"><?php echo "<br/>",form_error('name');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Father's Name:</td><td class="col-md-4"><input type="text" name="father_name"><?php echo "<br/>",form_error('father_name');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Husband Name:</td><td class="col-md-4"><input type="text" name="husband_name"><?php echo "<br/>",form_error('husband_name');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Mother Name:</td><td class="col-md-4"><input type="text" name="mother_name"><?php echo "<br/>",form_error('mother_name');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Nominee Name:</td><td class="col-md-4"><input type="text" name="nominee_name"><?php echo "<br/>",form_error('mother_name');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">DOB:</td><td class="col-md-4"><input type="text" name="dob" id="dob" <?php echo date('d-m-Y');?>><?php echo "<br/>",form_error('dob');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Mobile No:</td><td class="col-md-4"><input type="text" name="mobile_no" maxlength="10"><?php echo "<br/>",form_error('mobile_no');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Address:</td><td class="col-md-4"><input type="text" name="address"><?php echo "<br/>",form_error('address');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Opening Amount.:</td><td class="col-md-4"><input type="text" name="opening_amount"><?php echo "<br/>",form_error('opening_amount');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">RD Amount:</td><td class="col-md-4"><input type="text" name="rd_amount"><?php echo "<br/>",form_error('rd_amount');?></td> <td class="col-md-3"></td></tr>
                        
                        <tr> <td class="col-md-2">Account No.:</td><td class="col-md-4"><input type="text" name="account_no"><?php echo "<br/>",form_error('account_no');?></td> <td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Open Date:</td><td class="col-md-4"><input type="text" name="deposit_date" id="deposit_date"><?php echo "<br/>",form_error('deposit_date');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2">Remark:</td><td class="col-md-4"><textarea  name="remark" rows="2" cols="40"></textarea><?php echo "<br/>",form_error('remark');?></td><td class="col-md-3"></td></tr>
                        <tr> <td class="col-md-2" colspan="2"></td><td class="col-md-4"><input type="submit"></td> <td class="col-md-3"></td></tr>
                    
                    
                    </table>
                    
                    
                              </form>
                    </div>
                    
                </div>
 </div>