 <div class="container">
    <div class="row">
        <table class="table-bordered table-striped custome_table">
            <tr>
                <td class="col-md-2">Account No.</td>
                <td class="col-md-4">Name.</td>
                <td class="col-md-2">Last Payment</td>
                <td>Def Month</td>
                <td>Def Amount</td>
                <td>Balance Amount</td>
            </tr>
            <?php
            foreach($get_default->result() as $row)
            {
               
               ?>
               <tr>
                <td class="col-md-2"><?php echo $row->acno;?></td>
                <td class="col-md-4"><?php echo $row->name;?></td>
                <td class="col-md-2"><?php echo date('M-y',$row->end_date);?></td>
                <td><?php
                  $db_start_month = $row->end_date; //$row->start_date;
                  $db_end_month = strtotime(date('d-M-Y'));//$row->end_date;
                  $d1 = $db_start_month ;
                  $d2 = $db_end_month;
                  echo $interval = abs((date('Y', $d2) - date('Y', $d1))*12 + (date('m', $d2) - date('m', $d1)));
                
                ?></td>
                <td></td>
                <td></td>
            </tr>
               <?php
               
            }
            ?>
        </table>
      
        <br/>
       
        <?php echo $create_link;?>
    </div>
 </div>