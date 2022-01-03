/**/
$('#selCot').change(function(){
	var id = $(this).val();

	$.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } });

    $.ajax({
        type:"GET",
        url:'/get_regions/'+id,
        success: function(response) {
            if(response.success == 1)
            {
                $.unblockUI();
                $("#selReg").html(response.data).selectpicker('refresh');
            }
            else
            {
            	$.unblockUI();
                $("#selReg").html('').selectpicker('refresh');
            }
        }
    })
});


/**/
function change_lang(locale)
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

    $.ajax({
        type:"GET",
        url:'/set_language/'+locale,
        success: function(response) {
            if(response.success == 1)
            {
                $.unblockUI();
                location.reload();
            }
        }
    })
}


/**/
function user_default_lang(locale)
{
    $('#defLangBtn').attr('disabled', true);
    $.ajax({
        type:"GET",
        url:'/user_default_lang/'+locale,
        success: function(response) {
            if(response.success == 1)
            {
                $('#defLangBtn').attr('disabled', false);
                location.reload();
            }
        }
    })
}


/**/
$('#seltOrg').change(function(){
    var id = $(this).val();

    $.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } });

    $.ajax({
        type:"GET",
        url:'/get_teams/'+id,
        success: function(response) {
            if(response.success == 1)
            {
                $.unblockUI();
                $("#seltTeam").html(response.data).selectpicker('refresh');
            }
            else
            {
                $.unblockUI();
                $("#seltTeam").html('').selectpicker('refresh');
            }
        }
    })
});
