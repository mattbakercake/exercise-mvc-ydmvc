/* 
 * example javascript file
 * 
 * 
 * Functions to run after the page has finished loading
 */
$(document).ready(function() { //run scripts after page has loaded
    
//here
    
});

/*
 * Other Functions
 */

/*
 * Submits the adduserform HTML form to ajaxadduser model action 
 */
function submitUserForm(baseurl) {
    var status = validateForm(); //JS form validation
    if(status){//if validation passed call action via AJAX
        $.ajax({
            type:'POST',
            url: base_url + '/home/ajaxadduser/',
            data:$('#adduserform').serialize(), 
            success: function(response) {
                tableMsg(response); //show status message
                $('#userTable').load(base_url + '/home/updateusertable'); //redraw table
                $( '#adduserform' ).each(function(){// reset the form
                    this.reset();
                });
            },
            error: function(jqXHR, exception) {
                alert('Form not submitted - Ajax Error: ' + exception);
            }
        });
    } else {// validation isn't passed
        tableMsg('{"status":"0","msg":"Please Complete All Fields"}')  //show status message
    }
    return false;
};

/*
 * displays a status message below user table
 */
function tableMsg(data) {
    var details = jQuery.parseJSON(data); //turn JSON string into object
    
    $('#statusMsg').hide(); 
    switch (Number(details.status)) {
        case 0://action failed
            $('#statusMsg').css({"background-color":"#ff6666", "outline":"1px solid #ff0000"}); //red box
            break;
        case 1: //action succeeded
             $('#statusMsg').css({"background-color":"#66ff66", "outline":"1px solid #19ff19"}); //green box
            break;
    }
    $('#statusMsg').html(details.msg);
    $('#statusMsg').show().delay(5000).fadeOut(2000); //show message and then fade
}

/*
 * performs simple validation of form
 */
function validateForm() {
    var status = true;

    if ($('#firstname').val() == "" || $('#firstname').val() == null) {
        $('#fnerror').html('*Required'); //show error on form
        status = false;
    } else {
      $('#fnerror').html(''); //remove error
       status = true;
    }
    if ($('#surname').val() == "" || $('#surname').val() == null) {
        $('#snerror').html('*Required'); //show error on form
        status = false;
    } else {
       $('#snerror').html('');  //remove error
        status = true;
    }
    
    return status;
}

/*
 * deletes a user record via AJAX using ajaxdeleteuser model action
 */
function ajaxdeleteuser(id) {
    $.ajax({
            type:'POST',
            url: base_url + '/home/ajaxdeleteuser/' + id, 
            success: function(response) {
                tableMsg(response); //show status message
                $('#userTable').load(base_url + '/home/updateusertable'); //redraw table
            },
            error: function(jqXHR, exception) {
                alert('query not submitted - Ajax Error: ' + exception);
            }
        });
        
        return false;
}

