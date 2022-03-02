<?php 
session_start();
include('../includes/header.php');
include('../includes/database.php');
if(isset($_SESSION['profil'])){

?>
<?php 
    $query="select id_stock,nom,photo from stock ORDER BY id_stock DESC";
    $products="";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
    if($total_row>0){
      foreach($result as $row){
        $products.="<option value='{$row["id_stock"]}'><img src='../image_stock/{$row["photo"]}>' width='70px' height='70px'> {$row["nom"]}</option>";
      }
    }
  ?>

 
<title>Crée vente</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="../js/jquery.min.js"></script>
<link href="css/style.css" rel="stylesheet">
<div class="container content-invoice">
<br />
	<form action="insert.php" id="invoice_form" method="post"> 
		<div class="load-animate animated fadeInUp">
			 <div class="card">
                <div class="card-header p-7">
                    <h5 class="pt-2 d-inline-block">CREER UNE VENTE</h5>
                    <div class="float-right">
                         <table border="0">
                                <thead>
                                    <tr>
                                        <?php 
	
    $query="SELECT  LPAD(MAX(num)+1,6,'0')as n FROM vente";
     $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  
  foreach($result as $row){
    if ($row [ "n" ]==null){
	  ?>
	
	  <th>Numero : <input type="text" name="num"  value="000001" class="form-control form-control-sm numero numero" style="width:120px;height:25px;font-size:17;font-weight: bold;margin-right:5px" readonly/> </th>                 
	   <?php
}else{
 ?>
 <th>Numero : <input type="text" name="num"  value="<?php echo $row [ "n" ];?>" class="form-control form-control-sm numero numero" style="width:120px;height:25px;font-size:17;font-weight: bold;margin-right:5px" readonly/> </th>                       
 <?php
}
	
	}
  
  ?>
                                          
                                           
                                        <th>Date : <input type="hidden" name="date"  value="<?php echo date('Y/m/d');?>" class="form-control form-control-sm dateapp" style="width:120px;height:25px;font-size:17;font-weight: bold" readonly/> 
										<input type="Calendar" name="dated"  value="<?php echo date('d/m/Y');?>" class="form-control form-control-sm dateappd" style="width:120px;height:25px;font-size:17;font-weight: bold" readonly/> 
										</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
							                    </div>
                </div>
				<br />

			<div class="row">
				 		
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 pull-left" style="margin-left:auto">
					<div class="form-group">
					<input type="hidden" class=" form-control form-control-sm" name="id_utilisateur" value="<?php echo $_SESSION['id_utilisateur'];?>">
					Nom complet: <input type="text" class="nom_client form-control form-control-sm" name="nom_client" id="nom_client" placeholder="Nom complet du client"  required="required">
					</div>
					
					
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 pull-right" style="margin-right:auto; margin-left:auto">
					<div class="form-group">
						Adresse: <input type="text" class="form-control form-control-sm" name="adresse" id="adresse" placeholder="Adresse" >
					</div>
					
					
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 pull-right" style="margin-right:auto">
					<div class="form-group">
						Telephone :<input type="text" class="form-control form-control-sm" name="telephone" id="telephone" placeholder="Telephone" required="required" >
					</div>
					
					
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-hover" id="invoiceItem">	
						<tr>
							<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th style="width:250px">Article</th>
                             <th>Prix</th>
                             <th style="width:50px">Quantite</th>
							 <th>Total</th>
							  <th style="width:50px">Remise</th>
							  <th>Montant remise</th>
							  <th>Grand Total</th>
						</tr>							
						<tr class="item">
							<td><input class="itemRow" type="checkbox"></td>
							<td><select class="pid form-control form-control-sm" name="id_stock[]" id="id_stock_">
							<option value="0">Selectionnez</option>
							<?php echo $products; ?></select></td>
							<td><input type="text"  name="prix"  id="prix_" class="form-control form-control-sm prix" autocomplete="off" readonly required="required"></td>			
							<td><input type="text" name="quantite[]" id="quantite_"  class="form-control form-control-sm" required="required" onKeyUp="calculateTotal()" ></td>
							<td><input type="text" name="total[]" id="total_"  class="form-control form-control-sm total" required="required" readonly></td>
							<td><input type="text" name="remise[]" id="remise_" class="form-control form-control-sm remise rem" onKeyUp="calculateRemise()"></td>
							<td><input type="text"  name="mt_remise[]" id="mt_remise_" class="form-control form-control-sm mt_remise" autocomplete="off" readonly required="required" ></td>
							<td><input type="text" name="tot[]" id="tot_"  class="form-control form-control-sm tot" required="required" readonly></td>
						</tr>						
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-left:auto;margin-right:auto;">
					<center>
					<button class="btn btn-success" id="addRows" type="button"><i class='fa fa-plus'></i></button>
					<button class="btn btn-danger delete" id="removeRows" type="button"><i class='fa fa-trash'></i></button>
					</center>
				</div>
			</div>
				
			
					<br>
					<div  class="table-responsive">
					<table width="100%"  class="table table-clear">
  <tr>
    <th width="35%" rowspan="4" scope="col"><label><strong class="text-dark">Remarque</strong></label><textarea name="description" cols="" rows="" class="form-control"></textarea></th>
    <th width="15%" scope="col"><strong class="text-dark">Acompte</strong></th>
    <th width="15%" scope="col"><input type="text" name="montant" class="form-control form-control-sm" ></th>
    <th width="15%" scope="col"><strong class="text-dark">Montant HT</strong></th>
    <th width="15%" scope="col"><input type="text" name="mt_ht" id="mt_ht"  class="form-control form-control-sm mt_ht"  readonly></th>
  </tr>
  <tr class="ittva">
    <td><strong class="text-dark">Zone de livraison</strong></td>
    <td><input type="text" name="zone"   class="form-control form-control-sm " ></td>
    <td><strong class="text-dark">TVA (18%)</strong></td>
    <td><input type="text" name="tva" id="tva"  class="form-control form-control-sm tva " onkeyup="keytva()"></td>
  </tr>
  <tr>
    <td><strong class="text-dark">Tarif</strong></td>
    <td><input type="text" name="tarif" id="tarif"  class="form-control form-control-sm " ></td>
    <td><strong class="text-dark">Montant TVA</strong></td>
    <td><input type="text" name="mt_tva" id="mt_tva"  class="form-control form-control-sm mt_tva" readonly></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong class="text-dark">Montant TTC</strong></td>
    <td><input type="text" name="mt_ttc" id="mt_ttc"  class="form-control form-control-sm mt_ttc" required="required" readonly></td>
  </tr>
</table>
<input type="hidden" value="" class="form-control" name="userId">
						<center><button class="btn btn-success " name="invoice_btn" id="invoice_btn" type="submit"><i class='fa fa-list'></i> <b>Enregistrer</b></button></center>
						<br/>
 </div>
                 </div>
				 
						
					</div>
					
				</div>
				
			<div class="clearfix"></div>		      	
		</div>
	</form>	
	<?php 

include('../includes/footer.php');
?>
	<script>
	
	$(document).ready(function(){
	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = 1;
	$(document).on('click', '#addRows', function() { 
	 var products="<?php echo $products; ?>";
	 count++;
		var htmlRows = '';
		htmlRows += '<tr class="item">';
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';          
		htmlRows += '<td><select class="pid form-control form-control-sm" name="id_stock[]" required="required" >'+products+'</select></td>'; 
		htmlRows += '<td><input type="text"  name="prix" class="form-control form-control-sm prix"  readonly required="required" id="prix_'+count+'"></td>';	
		htmlRows += '<td><input type="text" name="quantite[]"  class="form-control form-control-sm " id="quantite_'+count+'" onKeyUp="calculateTotal()" required="required"></td>';
		htmlRows += '<td><input type="text" name="total[]" id="total_'+count+'"  class="form-control form-control-sm total" readonly required="required"></td>';
		htmlRows += '<td><input type="text"  name="remise[]" id="remise_'+count+'" class="form-control form-control-sm remise rem" autocomplete="off"  onKeyUp="calculateRemise()"></td>';	
		htmlRows += '<td><input type="text"  name="mt_remise[]" id="mt_remise_'+count+'" class="form-control form-control-sm mt_remise" autocomplete="off" readonly "></td>';	
		htmlRows += '<td><input type="text" name="tot[]" id="tot_'+count+'"  class="form-control form-control-sm tot" readonly ></td>';         
		htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);
	}); 
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateRemise();
		calculateTotal();
	});		
	
	
	
});	

 //Get product price
        $("body").on("change",".pid",function(){
          var pid=$(this).val();
          var input=$(this).parents("tr").find(".prix");
          $.ajax({
            url:"get_produit.php",
            type:"post",
            data:{pid:pid},
            success:function(res){
              $(input).val(res);
            }
          });
        });
		 //Get chantier price

		        
function calculateTotal(){
	var totalAmount = 0; 
	$("[id^='prix_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("prix_",'');
		var prix = $('#prix_'+id).val();
		var quantite  = $('#quantite_'+id).val();
		if(!quantite) {
			quantite = 1;
		}
		var total = prix*quantite;
		$('#total_'+id).val(parseFloat(total));
		$('#tot_'+id).val(parseFloat(total));
		totalAmount += total;			
	});
	var sum = 0;
        $(".tot").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
		        $("#mt_ht").val(sum);
				$("#mt_ttc").val(sum);
}
function calculateRemise(){
	var totalAmount = 0; 
	$("[id^='remise_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("remise_",'');
		var remise = $('#remise_'+id).val();
		var total  = $('#total_'+id).val();
		if(!total) {
			total_remise = 1;
		}
		var total_remise = total*remise/100;
		$('#mt_remise_'+id).val(parseFloat(total_remise));
		totalAmount += total;
		calculateREMISE_Total();		
	});
	
}
function calculateREMISE_Total(){
	var totalAmount = 0; 
	$("[id^='total_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("total_",'');
		var total = $('#total_'+id).val();
		var mt_remise  = $('#mt_remise_'+id).val();
		if(!mt_remise) {
			mt_remise = 1;
		}
		var grand_total = total-mt_remise;
		$('#tot_'+id).val(parseFloat(grand_total));
		totalAmount += grand_total;			
	});
	
	var sum = 0;
        $(".tot").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
		        $("#mt_ht").val(sum);
}
 function keytva(){
	var taxRate = $("#tva").val();
	var subTotal = $('#mt_ht').val();	
	if(subTotal) {
		var taxAmount = subTotal*taxRate/100;
		$('#mt_tva').val(taxAmount);
		subTotal = parseFloat(subTotal)+parseFloat(taxAmount);
		$('#mt_ttc').val(subTotal);		
		var amountPaid = $('#amountPaid').val();
		var totalAftertax = $('#totalAftertax').val();	
		if(amountPaid && totalAftertax) {
			totalAftertax = totalAftertax-amountPaid;			
			$('#mt_ttc').val(totalAftertax);
		} else {		
			$('#mt_ttc').val(subTotal);
		}
	}
}
 
	</script>
	<?php 
}else if(isset($_SESSION['profil'])==''){
header("Location:../index.php");
}?>
</div>
</div>	
