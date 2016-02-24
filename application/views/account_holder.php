    <div class="container">
          <div class="row">
                    <form action="<?php echo base_url();?>welcome/find_account_holder" method="post">
                    <input type="text" name="account_holder" placeholder="Enter Account Holder Name / Find Account Holder" class="form-control" style="width:60%;float:left;margin-right:30px;"> <input type="submit" value="Find" type="button" class="btn btn-success">
                    </form>
          </div>
    </div>
    <?php
    function edit_link($id =NULL,$join_account)
    {
         
           if($join_account >= 1)
               {
                   $edit_link = "<a href='".base_url()."welcome/successful_join_account_insert/".$id."/'>";
                   return $edit_link;
               }
               else
               {
                  $edit_link = "<a href='".base_url()."welcome/successful_add/".$id."/'>";
                   return $edit_link;
               }
    }
    
    function account_holder($join_account, $name1, $name2)
    {
         if($join_account <= 0)
               {
                 $account_holder = $name1;
                 return strtoupper($account_holder);
               }
               else
               {
                  $account_holder = strtoupper($name1." And ".$name2);
                  return "<samp style='font-weight: bold;color: #DA1818;font-size: 15px;'> JOIN ACCOUNT <samp> <h4 style='color: #000;font-size: 18px;'>".$account_holder."</h4>";
               }
    }
    
    function depositer_link($join_account, $account_no)
    {
         if($join_account <= 0)
               {
                  return base_url()."welcome/depositer_detail/".$account_no;
               }
               else
               {
                  return base_url()."welcome/join_account_detail/".$account_no;
               }
    }
    ?>
    
  <div style="overflow:scroll;margin:10px auto;padding-left:20px;padding-right:20px;">
  <table class="table-bordered table-striped custome_table">
            <tr><th >Sl.No.</th> <th class='col-md-1'>A/C No.</th> <th class="col-md-3"> Name </th><th class="col-md-3"> Father's Name</th> <th class="col-md-3"> Mother's Name</th> <th> DOB</th> <th> Mobile</th> <th> Address</th> <th> Opening Date</th> <th> RD Amount </th> <th> Sign</th> <th> Edit</th><th></th></tr>
        <?php
       $i = 1;
        foreach($lot_list->result() as $row)
        {
            $dob2='-';
            $account_od = '-';
         if($row->account_oping_date)
         {
            $account_od = date('d/M/Y',$row->account_oping_date);
         }
         if($row->dob)
         {
          $dob2=   date('d/M/Y',$row->dob);
         }
         
         echo "<tr><td >".$row->id."</td> <td class='col-md-1 c_td'><a href='".depositer_link($row->join_account, $row->account_no)."'>".$row->account_no."</a></td> <td class='col-md-3'>".account_holder($row->join_account, $row->name, $row->name1)."</td><td class='col-md-3'>".$row->father_name."</td> <td class='col-md-3'>".$row->mother_name."</td> <td>".$dob2."</td> <td>".$row->mobile_no."</td> <td>".$row->address."</td> <td>".$account_od."</td> <td>".$row->rd_amount."</td> <td><a href='",base_url().$row->sign_image."' target='_blank'> <img src ='",base_url().$row->thumbs."'></a></td>
         <td>",edit_link($row->id, $row->join_account)."Edit</a></td><td><a href='".base_url()."welcome/statement/".$row->id."/$row->account_no' title='statement'><i class='fa fa-database'></i></a></td></tr>";
        
        }
        ?>
        </table> 

    </div>
  <div class="container">
    <div class="row">
       <br/>
        <?php echo $create_link;?>
    </div>
  </div>

