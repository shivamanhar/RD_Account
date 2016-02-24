 <div class="container">
    <div class="row">
        <table class="table-bordered table-striped custome_table">
            <tr><th class="col-md-1">Sl.No.</th> <th class="col-md-1">Batch Number</th> <th class="col-md-2"> Lot Date</th><th class="col-md-8"></th></tr>
        <?php
       $i = 1;
        foreach($lot_list->result() as $row)
        {
            echo "<tr><td>".$i."</td><td> <a href='".base_url()."welcome/lot_list/".$row->batch_no."'>".$row->batch_no."</a></td><td>",date('d-M-Y', $row->lot_date),"</td><td></td></tr>";
            
            $i++;
        }
        ?>
        </table>
        <br/>
        <?php echo $create_link;?>
    </div>
 </div>