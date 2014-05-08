/* 
 * example javascript file
 * 
 * 
 * Functions to run after the page has finished loading
 */
$(document).ready(function() { //run scripts after page has loaded

    
     
});

/*
 * Other Functions
 */

/*
 * Submits the adduserform to adduser action 
 */
function submitUserForm() {
    var status = validateForm();
    if(status){
        $.ajax({
            type:'POST',
            url: '../home/adduser/',
            data:$('#adduserform').serialize(), 
            success: function(response) {
                tableMsg(response);
                $('#userTable').load('../home/updateusertable');
                $( '#adduserform' ).each(function(){
                    this.reset();
                });
            },
            error: function(jqXHR, exception) {
                alert('Form not submitted - Ajax Error: ' + exception);
            }
        });
    } else {
        tableMsg('{"status":"0","msg":"Please Complete All Fields"}')
    }
    return false;
};

function tableMsg(data) {
    var details = jQuery.parseJSON(data);
    
    $('#statusMsg').hide();
    switch (Number(details.status)) {
        case 0:
            $('#statusMsg').css("background-color", "red");
            break;
        case 1:
             $('#statusMsg').css("background-color", "green");
            break;
    }
    $('#statusMsg').html('<p>' + details.msg + '</p>');
    $('#statusMsg').show().delay(5000).fadeOut(2000);
}

function validateForm() {
    var status = true;

    if ($('#firstname').val() == "" || $('#firstname').val() == null) {
        $('#fnerror').html('*Required');
        status = false;
    } else {
      $('#fnerror').html('');
       status = true;
    }
    if ($('#surname').val() == "" || $('#surname').val() == null) {
        $('#snerror').html('*Required');
        status = false;
    } else {
       $('#snerror').html('');
        status = true;
    }
    
    return status;
}



