$(function(){
	/*
	* Add New Language
	*/
	$('#addNewLang').on('submit', function(e){
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		})
	    e.preventDefault(e);

	    var form = $('#addNewLang')[0]; 
    	var form_data = new FormData(form);
    	$('#langBtn').attr('disabled', true);
	    $.ajax({
	        type: "POST",
	        url: '/admin_panel/add_language',
	        data: form_data,
	        contentType: false,
        	processData: false,
	        success: function(response) {
	            if(response.success == 1)
	            {
	            	$('#langBtn').attr('disabled', false);
	            	$('#LangClsBtn').click();
	            	swal({title: "Good Job", text: response.message, type: "success"},
					   function(){ 
					       location.reload();
					   }
					);
	            }
	            else if(response.error == 1)
	            {
	            	if(response.type == 'multi')
	            	{
	            		var elements = $();
						for(x = 0; x < response.message.length; x++) 
						{
						    elements = elements.add('<p class="alert alert-danger">'+ response.message[x] +'</p>');
						}
						$('#errCnt').empty();
						$('#errCnt').append(elements);
	            	}
	            	else if(response.type == 'single')
	            	{
	            		var elements = '<p class="alert alert-danger">'+ response.message +'</p>';
	            		$('#errCnt').empty();
						$('#errCnt').append(elements);
	            	}
	            	$('#langBtn').attr('disabled', false);
	            }
	        }
		})
	});


	/*
	* Update Language
	*/
	$('#editLangFrm').on('submit', function(e){
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		})
	    e.preventDefault(e);

	    var form = $('#editLangFrm')[0]; 
    	var form_data = new FormData(form);
    	$('#langBtnUp').attr('disabled', true);
	    $.ajax({
	        type: "POST",
	        url: '/admin_panel/update_language',
	        data: form_data,
	        contentType: false,
        	processData: false,
	        success: function(response) {
	            if(response.success == 1)
	            {
	            	$('#langBtnUp').attr('disabled', false);
	            	$('#LangClsBtnUp').click();
	            	swal({title: "Good Job", text: response.message, type: "success"},
					   function(){ 
					       location.reload();
					   }
					);
	            }
	            else if(response.error == 1)
	            {
	            	if(response.type == 'multi')
	            	{
	            		var elements = $();
						for(x = 0; x < response.message.length; x++) 
						{
						    elements = elements.add('<p class="alert alert-danger">'+ response.message[x] +'</p>');
						}
						$('#errCntUp').empty();
						$('#errCntUp').append(elements);
						$('#langBtnUp').attr('disabled', false);
	            	}
	            	else if(response.type == 'single')
	            	{
	            		var elements = '<p class="alert alert-danger">'+ response.message +'</p>';
	            		$('#errCntUp').empty();
						$('#errCntUp').append(elements);
						$('#langBtnUp').attr('disabled', false);
	            	}
	            }
	        }
		})
	});
});


/*
* Load Language
*/
function load_lang(id)
{
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	})
	BlockUi();
	$.ajax({
		type: 'GET',
		url: '/admin_panel/edit_language/'+id,
		success: function(response) {
			if(response.success == 1)
			{
				$('#langName').val(response.data.name);
				$('#langLoc').val(response.data.locale);
				$('#locIcon').attr('src', '/web/assets/uploads/assets/'+response.data.icon);
				$('#langPreIco').val(response.data.icon);
				$('#langId').val(response.data.id);
				UnBlockUi();
				$('#editLang').modal('show');
			}
			else if(response.error == 1)
			{
				UnBlockUi();
				swal({title: "Error", text: "Something went wrong!", type: "error"});
			}
		}
	});
}


/*Block/Unblock Ui Function*/
function BlockUi()
{
	$.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
}

function UnBlockUi()
{
	$.unblockUI();
}
