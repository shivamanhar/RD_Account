  <div style="overflow:scroll;margin:10px auto;padding-left:20px;padding-right:20px;">
  <table class="table-bordered table-striped custome_table">
            <tr><th >Sl.No.</th> <th class='col-md-1'>A/C No.</th> <th class="col-md-3"> Name </th><th class="col-md-3"> Father's Name</th> <th class="col-md-3"> Mother's Name</th> <th> DOB</th> <th> Mobile</th> <th> Address</th> <th> Opening Date</th> <th> RD Amount </th> <th> Sign</th></tr>
        <?php
       $i = 1;
        foreach($lot_list->result() as $row)
        {
         
         echo "<tr><td >".$i."</td> <td class='col-md-1 c_td'><a href='",base_url()."welcome/depositer_detail/".$row->account_no."'>".$row->account_no."</a></td> <td class='col-md-3'>".strtoupper($row->name)."</td><td class='col-md-3'>".$row->father_name."</td> <td class='col-md-3'>".$row->mother_name."</td> <td>".date('d/M/Y',$row->dob)."</td> <td>".$row->mobile_no."</td> <td>".$row->address."</td> <td>".date('d/M/Y',$row->account_oping_date)."</td> <td>".$row->rd_amount."</td> <td><a href='",base_url().$row->sign_image."' target='_blank'> <img src ='",base_url().$row->thumbs."'></a></td></tr>";
        
            
            $i++;
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
