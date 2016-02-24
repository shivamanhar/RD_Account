<?php
echo validation_errors();

$field_value = array(
                     'userid' => $this->tank_auth->get_user_id()
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
                    <div class="col-md-8">
                              <?php
                              if(isset($message))
                              {
                                             echo "<h3>".$message."</h3>";
                              }
                              ?>
                              <form action="<?php echo base_url();?>welcome/agent_detail_post" method="post">
                    <table>
                        <tr> <td class="col-md-4">Agent Name:</td><td class="col-md-4"><input type="text" name="agent_name" value="<?php if(isset($agent_name)) {echo $agent_name;}?>" style="width:100%"><?php echo "<br/>",form_error('agent_name');?></td></tr>
                        <tr> <td class="col-md-4">Agent Code:</td><td class="col-md-4"><input type="text" name="agent_code" value="<?php if(isset($agent_code)) {echo $agent_code;}?>"><?php echo "<br/>",form_error('agent_code');?></td></tr>
                        <tr> <td class="col-md-4">Valid Up To:</td><td class="col-md-4"><input type="text" name="valid_up_to" value="<?php if(isset($valid_up_to)) {echo $valid_up_to;}?>" maxlength="10"><?php echo "<br/>",form_error('valid_up_to');?></td></tr>
                        <tr> <td class="col-md-4">Limit:</td><td class="col-md-4"><input type="text" name="limit" value="<?php if(isset($limit)) {echo $limit;}?>" ><?php echo "<br/>",form_error('limit');?></td></tr>
                        <tr> <td class="col-md-4">PAN:</td><td class="col-md-4"><input type="text" name="pan" value="<?php if(isset($pan)) {echo $pan;}?>"><?php echo "<br/>",form_error('pan');?></td></tr>
                        
                        <tr> <td class="col-md-4" colspan="2"></td><td class="col-md-4"><input type="submit" value="Save / Change "></td></tr>
                    </table>
                              </form>
                    </div>
                    <div class="col-md-1">
                    </div>
                   
                </div>
 </div>