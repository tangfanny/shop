$("#model").change(function(){
	if(0 == $(this).val()){
		$('.model_box').hide();
		return;
	}
        $("#hiddenmodel").val($(this).val());
	$.getJSON(getmodelinfourl,{'id':$(this).val()},function(data){  
		if(data){
			$('.model_box').show();
			var modelRowHtml = template('modelRowTemplate', {'templateData': data});
//                        alert(JSON.stringify(data));
			$('#modelBaseBody').html(modelRowHtml); 
		}
	})
});

$("#model1").change(function(){  
    if(0 == $(this).val()){
                    $('.model_box1').hide();
                    return;
    }
    var id = $("#hiddenmodel").val();
    $.getJSON(getmodelinfoproductsurl,{'id':id,'products_id':$(this).val()},function(data){  
		if(data){                    
			$('.model_box').show();
			var modelRowHtml = template('modelRowTemplate', {'templateData': data});
                       // alert(JSON.stringify(data));
			$('#modelBaseBody').html(modelRowHtml); 
		}
	})
});
