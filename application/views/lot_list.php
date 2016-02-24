 <div class="container">
    <div class="row">
      <h4 style="color:E60606"> Batch No. <u><?php echo $batch_no;?></u> / <a href="<?php echo base_url();?>welcome/batch_list"> Back to Batch List </a></h4>
      
        <table class="table-bordered table-striped custome_table">
            <tr><th class="col-md-1">Sl.No.</th> <th class="col-md-1">Lot Number</th> <th class="col-md-2"> Lot Date</th><th class="col-md-8"></th></tr>
        <?php
       $i = 1;
        foreach($lot_list->result() as $row)
        {
            echo "<tr><td>".$i."</td><td>".$row->lot_no."</td><td>",date('d-M-Y', $row->lot_date),"</td><td></td></tr>";
            
            $i++;
        }
        ?>
        </table>
        <br/>
        <?php echo $create_link;?>
    </div>
 </div>