
$(document).ready(function(){
    $('#acount_number').change(function()
                               
                               {
                                var url = $("#url").val()+"welcome/geting_depositor_name";
                                var account_number = $('#acount_number').val();
                                   
                                   
                              if($.isNumeric(account_number) == false)
                              {
                                    $('#acount_number').val("");
                                    $("#open_date").val("");
                                    $("#amount_deposited").val("");
                                    $("#depositor_name").val("");
                                    $("#balance").val("");
                                    $("#depositor_id").val("");
                                    $("#month").val("");
                                    $("#def").val("");
                                    $("#total_deposit").val("");
                                    alert("Please insert only number");
                              }
                              else
                                {
                                $.post(url, {account_number:account_number}, function(data){
                                    
                                  var adv_text = '';
                                  if(data.adv_amount>0)
                                  {
                                    adv_text ='Advance';
                                    $("input[name=adv_calcul]").val(1);
                                  }
                                  $("input[name=depositor_name]").val(data.name);
                                  $("input[name=open_date]").val(data.account_opening_date);
                                  $("input[name=balance]").val(data.balance);
                                  $("input[name=amount_deposited]").val(data.rd_amount);
                                  $("input[name=depositor_id]").val(data.depositor_id);
                                  $("input[name=month]").val(data.month);
                                  $("input[name=def]").val(data.def);
                                  $("input[name=total_deposit]").val(data.total_deposit_amount);
                                  $("input[name=adv_month]").val(data.start_month);
                                  
                                  $("#total_deposit").html(data.total_deposit_amount);
                                  $("#commission").html(data.commision);
                                  $("#net_tendered_amt").html(data.net_tendered_amt);
                                  $("#tds").html(data.tds);
                                  $("#net_amount").html(data.net_amount);
                                  $("#adv_text").html(adv_text);
                                  }, "json");
                                }
                                
                                });
    
    });

$(document).ready(function(){
    $("input[name=mobile_no]").change(function(){
        var mobile_no = $("input[name=mobile_no]").val();
         if($.isNumeric(mobile_no) == false)
                              {
                                 alert("Please insert only number");
                                    $('input[name=mobile_no]').val("");
                              }
        
        });
    });


$(document).ready(function(){
    $("input[name=opening_amount]").change(function(){
        var opening_amount = $("input[name=opening_amount]").val();
         if($.isNumeric(opening_amount) == false)
                              {
                                 alert("Please insert only number");
                                    $('input[name=opening_amount]').val("");
                              }
        
        });
    });

$(document).ready(function(){
    $("input[name=rd_amount]").change(function(){
        var rd_amount = $("input[name=rd_amount]").val();
         if($.isNumeric(rd_amount) == false)
                              {
                                 alert("Please insert only number");
                                    $('input[name=rd_amount]').val("");
                              }
        
        });
    });

$(document).ready(function(){
    $("input[name=account_no]").change(function(){
        var account_no = $("input[name=account_no]").val();
         if($.isNumeric(account_no) == false)
                              {
                                 alert("Please insert only number");
                                    $('input[name=account_no]').val("");
                              }
        
        });
    });
/*confirmation massage*/

function confirmation()
{
    var url = $("#url").val()+"welcome/deposit_form";
    var lot_date = $("input[name=lot_date]").val();
    var lot_no = $("input[name=lot_no]").val();
    var answer = confirm ("Lot Date : "+lot_date+" Lot No "+lot_no);
    if (answer==false)
    {
        window.location=url;
    }
}

/* for date picker */


/*opening date */
$(document).ready(function(){
    $("#deposit_date").Zebra_DatePicker({
         format: 'd-m-Y'
        });
    });

/*OOB Date */
$(document).ready(function(){
    $("#dob").Zebra_DatePicker({
         format: 'd-m-Y'
        });
    });


/*OOB Date */
$(document).ready(function(){
    $("#dob1").Zebra_DatePicker({
         format: 'd-m-Y'
        });
    });

/*lot date */
$(document).ready(function(){
    $("#lot_date").Zebra_DatePicker({
         format: 'd-m-Y'
        });
    });

/*month*/
$(document).ready(function(){
    $('#month').Zebra_DatePicker({
        format: 'd-M-Y' });
    });

/*month*/
$(document).ready(function(){
    $('#adv_month').Zebra_DatePicker({
        format: 'd-M-Y' });
    });
/*number to word conver*/
$(document).ready(function(){
    $('.number').toWords();
    });

$(document).ready(function(){
    $("input[name=def]").click(function(){
        var url = $("#url").val()+"welcome/change_month";
        var account_number = $("input[name=account_number]").val();
        var find_adv = $("input[name=find_adv]").val();
        var session_date = $("input[name=session_date ]").val();
        var month = $("input[name=month]").val();
        /*if(find_adv == 1)
        {
           var month = $("input[name=month]").val();//session_date;
        }
        else
        {
            var month = $("input[name=month]").val();
        }*/
        
        
        
     var depositor_id = $("input[name=depositor_id]").val();
       $.post(url ,{month:month,depositor_id:depositor_id, account_number:account_number,find_adv:find_adv }, function(data){
                                    
                                  $("input[name=amount_deposited]").val(data.rd_amount);
                                  $("input[name=depositor_id]").val(data.depositor_id);
                                  $("input[name=month]").val(data.month);
                                  $("input[name=def]").val(data.def);
                                  $("input[name=total_deposit]").val(data.total_deposit_amount);
                                  $("input[name=balance]").val(data.balance);
                                  $("input[name=adv_month]").val(data.start_month);
                                  $("input[name=adv_calcul]").val(data.adv_calcul);
                                  $("#total_deposit").html(data.total_deposit_amount);
                                  $("#commission").html(data.commision);
                                  $("#net_tendered_amt").html(data.net_tendered_amt);
                                  $("#tds").html(data.tds);
                                  $("#net_amount").html(data.net_amount);
           }, "json");
        });
    }
);

