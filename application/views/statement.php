<?php
foreach($total->result() as $row)
{
          $amount_deposited=  $row->amount_deposited;
}


foreach($total_def->result() as $row)
{
            $def_amount = $row->def;
}
?>

<table class="table-bordered table-striped custome_table">
            <tr><th >Sl.No.</th> <th class='col-md-2'>Deposit Date</th> <th class="col-md-3"> Deposit Amount</th><th class="col-md-3"> Def </th> <th class="col-md-4"></th></tr>
<?php
$i = 1;
        foreach($statement->result() as $row)
        {
            echo "<tr><td >$i</td><td class='col-md-2'>".date('d-M-Y', $row->month)."</td> <td class='col-md-3'> ".$row->amount_deposited."</td><td class='col-md-3'> ".$row->def."</td> <td class='col-md-4'></td></tr>";
            $i++;
        }
?>
            <tr><td></td><td>Total</td><td><?php if(isset($amount_deposited)){echo $amount_deposited;}?></td><td><?php if(isset($def_amount)){echo $def_amount;}?></td></tr>
</table> 