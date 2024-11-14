function get_merchant(merchant_name,elm){
if(merchant_name=="PhonePe Business"){
$(elm).html('<div class="col-md-4 mb-2"> <label>Merchant Name</label> <select type="number" name="merchant_name" class="form-control" onchange="get_merchant(this.value,\'#merchant\')" required> <option value="PhonePe Business" selected>PhonePe Business</option> <option value="Paytm Business">Paytm Business</option> <option value="SBI Merchant">SBI Merchant</option> </select> </div><div class="col-md-4 mb-2"> <label>Mobile Number</label> <input type="number" name="merchant_username" placeholder="Enter Mobile Number" class="form-control" onKeyPress="if(this.value.length==10) return false;" required> </div><div class="col-md-4 mb-2"> <label>&nbsp;</label> <button type="submit" name="addmerchant" class="btn btn-primary btn-block">Add Merchant</button> </div>');    
}else if(merchant_name=="Paytm Business"){
$(elm).html('<div class="col-md-4 mb-2"> <label>Merchant Name</label> <select type="number" name="merchant_name" class="form-control" onchange="get_merchant(this.value,\'#merchant\')" required> <option value="PhonePe Business">PhonePe Business</option> <option value="Paytm Business" selected>Paytm Business</option> <option value="SBI Merchant">SBI Merchant</option> </select> </div><div class="col-md-3 mb-2"> <label>Mobile Number</label> <input type="number" name="merchant_username" placeholder="Enter Mobile Number" class="form-control" onKeyPress="if(this.value.length==10) return false;" required> </div> <div class="col-md-3 mb-2"> <label>Password</label> <input type="text" name="merchant_password" placeholder="Enter Password" class="form-control" required> </div><div class="col-md-2 mb-2"> <label>&nbsp;</label> <button type="submit" name="addmerchant" class="btn btn-primary btn-block">Add Merchant</button> </div>');    
}else if(merchant_name=="SBI Merchant"){
$(elm).html('<div class="col-md-4 mb-2"> <label>Merchant Name</label> <select type="number" name="merchant_name" class="form-control" onchange="get_merchant(this.value,\'#merchant\')" required> <option value="PhonePe Business">PhonePe Business</option> <option value="Paytm Business">Paytm Business</option> <option value="SBI Merchant" selected>SBI Merchant</option> </select> </div><div class="col-md-3 mb-2"> <label>Username</label> <input type="text" name="merchant_username" placeholder="Enter Username" class="form-control" required> </div> <div class="col-md-3 mb-2"> <label>Password</label> <input type="text" name="merchant_password" placeholder="Enter Password" class="form-control" required> </div><div class="col-md-2 mb-2"> <label>&nbsp;</label> <button type="submit" name="addmerchant" class="btn btn-primary btn-block">Add Merchant</button> </div>');    
}else{
$(elm).html("");
Swal.fire("Merchant Not Selected", '', 'error');   
}	
}


function delete_merchant(merchant_id){
Swal.fire({
  title: 'Are you sure you want to delete this account?',
  showDenyButton: true,
  showCancelButton: false,
  confirmButtonText: 'Yes',
  denyButtonText: 'No',
}).then((result) => {
  if (result.isConfirmed) {
	var form = document.createElement("form");
	document.body.appendChild(form);
	form.method = "POST";
	form.action = location.href;
	var element1 = document.createElement("input");         
    element1.name="merchant_id"
    element1.value = merchant_id;
    element1.type = 'hidden'
    form.appendChild(element1);
	var element2 = document.createElement("input");         
    element2.name="delete"
    element2.value = true;
    element2.type = 'hidden'
    form.appendChild(element2);
	form.submit();
  } else if (result.isDenied) {
    //Swal.fire('Good your account is safe', '', 'info');
  }
});	

}



function get_merchant_otp(merchant_id){
Swal.fire({
  title: 'Did you want to verify this account?',
  showDenyButton: true,
  showCancelButton: false,
  confirmButtonText: 'Yes',
  denyButtonText: 'No',
}).then((result) => {
  if (result.isConfirmed) {
	
	if(merchant_id.length>0){
	loader("show");
	$.ajax({
	    url: 'ajax_merchant',
	    type: 'POST',
	    data: {get_merchant_otp:true,merchant_id:merchant_id},
	    success: function( response, textStatus, jQxhr ){
	    loader("hide");
	    if(response.status==true){
	    swal.fire({html: response.html,showConfirmButton: false, showCancelButton: true, cancelButtonText: "Cancel", allowOutsideClick: false, allowEscapeKey: false}).then(function() { 
	        //location.reload(); 
	    }); 
	    }else{
	    Swal.fire(response.message, '', 'error');
	    }

	    },
	    error: function( jqXhr, textStatus, errorThrown ){
	        loader("hide");
	        console.log( errorThrown );
	    }
	});
	}else{
	Swal.fire('merchant is Not Valid!', '', 'info');	
	}

  } else if (result.isDenied) {
    //Swal.fire('Good your account is safe', '', 'info');
  }
});	
}

function get_verify_otp(merchant_id,ip,otp){
if(merchant_id.length>0){
if(otp.length>0){
loader("show");
$.ajax({
    url: 'ajax_merchant',
    type: 'POST',
    data: {get_verify_otp:true,merchant_id:merchant_id,ip:ip,otp:otp},
    success: function( response, textStatus, jQxhr ){
    loader("hide");
    if(response.status==true){
    swal.fire({html: response.html,showConfirmButton: false, showCancelButton: true, cancelButtonText: "Cancel", allowOutsideClick: false, allowEscapeKey: false}); 
    }else{
    Swal.fire(response.message, '', 'error');
    }

    },
    error: function( jqXhr, textStatus, errorThrown ){
        loader("hide");
        console.log( errorThrown );
    }
});
}
}else{
Swal.fire('merchant is Not Valid!', '', 'info');	
}
}


function set_business(merchant_id,groupId){
if(merchant_id.length>0){
loader("show");
$.ajax({
    url: 'ajax_merchant',
    type: 'POST',
    data: {set_business:true,merchant_id:merchant_id,groupId:groupId},
    success: function( response, textStatus, jQxhr ){
    loader("hide");
    if(response.status==true){
    Swal.fire(response.message, '', 'success');
    location.reload();
    }else{
    Swal.fire(response.message, '', 'error');
    }

    },
    error: function( jqXhr, textStatus, errorThrown ){
        loader("hide");
        console.log( errorThrown );
    }
});
}else{
Swal.fire('merchant is Not Valid!', '', 'info');	
}
}


function get_merchant_view(merchant_id){
if(merchant_id.length>0){
loader("show");
$.ajax({
    url: 'ajax_merchant',
    type: 'POST',
    data: {get_merchant_view:true,merchant_id:merchant_id},
    success: function( response, textStatus, jQxhr ){
    loader("hide");
    if(response.status==true){
    swal.fire({html: response.html,showConfirmButton: false, showCancelButton: true, cancelButtonText: "Cancel", allowOutsideClick: false, allowEscapeKey: false}); 
    }else{
    Swal.fire(response.message, '', 'error');
    }

    },
    error: function( jqXhr, textStatus, errorThrown ){
        loader("hide");
        console.log( errorThrown );
    }
});
}else{
Swal.fire('merchant is Not Valid!', '', 'info');	
}
}

function set_merchant_primary(merchant_id,elm){
if(merchant_id.length>0){

var merchant_primary = "InActive";
if($(elm).is(":checked")==true){
merchant_primary = "Active";  
}
loader("show");
$.ajax({
    url: 'ajax_merchant',
    type: 'POST',
    data: {set_merchant_primary:true,merchant_id:merchant_id,merchant_primary:merchant_primary},
    success: function( response, textStatus, jQxhr ){
    loader("hide");
    if(response.status==true){
    swal.fire(response.message, '', 'success').then(function() { location.reload(); });
    }else{
    Swal.fire(response.message, '', 'error');
    }

    },
    error: function( jqXhr, textStatus, errorThrown ){
        loader("hide");
        console.log( errorThrown );
    }
});


}else{
Swal.fire('merchant is Not Valid!', '', 'info');	
}

}


function set_merchant_payupi(merchant_id,elm){
if(merchant_id.length>0){

var merchant_payupi = "Hide";
if($(elm).is(":checked")==true){
merchant_payupi = "Show";  
}
loader("show");
$.ajax({
    url: 'ajax_merchant',
    type: 'POST',
    data: {set_merchant_payupi:true,merchant_id:merchant_id,merchant_payupi:merchant_payupi},
    success: function( response, textStatus, jQxhr ){
    loader("hide");
    if(response.status==true){
    swal.fire(response.message, '', 'success').then(function() { location.reload(); });
    }else{
    Swal.fire(response.message, '', 'error');
    }

    },
    error: function( jqXhr, textStatus, errorThrown ){
        loader("hide");
        console.log( errorThrown );
    }
});


}else{
Swal.fire('merchant is Not Valid!', '', 'info');	
}

}

function get_txn_details(base64){
var json = atob(base64);
var response = JSON.parse(json);
let html = `<h4 class="mt-2"><b>Transaction ${response.status}</b></h4> <table class="table table-bordered mt-4 mb-0"><thead><tr> <td width="50%"><b class="f-400">Txn ID </b><br><small>${response.txn_id}</small></td>  <td><b class="f-400">Date Time </b><br><small>${response.txn_date}</small></td></tr><tr> <td colspan="2"><b class="f-400">${response.merchant_name} </b><br><small>${response.merchant_upi}</small></td>  </tr><tr> <td colspan="2"><b class="f-400">${response.customer_name} </b><br><small>${response.payment_mode} ${response.customer_vpa}</small></td>  </tr><tr> <td width="50%"><b class="f-400">Mobile Number </b><br><small>${response.customer_mobile}</small></td>  <td><b class="f-400">Email Address </b><br><small>${response.customer_email}</small></td></tr><tr> <td width="50%"><b class="f-400">Bank ID </b><br><small>${response.bank_orderid}</small></td>  <td><b class="f-400">Bank RRN </b><br><small>${response.utr_number}</small></td></tr><tr> <td width="50%"><b class="f-400">Txn Note </b><br><small>${response.txn_note}</small></td>  <td><b class="f-400">Amount </b><br><small>₹${response.txn_amount}</small></td></tr><tr> <td colspan="2"><b class="f-400">${response.client_orderid} </b><br><small>${response.product_name}</small></td>  </tr></thead></table>`;
swal.fire({html: html,showConfirmButton: false, showCancelButton: true, cancelButtonText: "Cancel", allowOutsideClick: false, allowEscapeKey: false}); 
}