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
    $.ajax({
        type:'POST',
        url: '../home/adduser/',
        data:$('#adduserform').serialize(), 
        success: function(response) {
            alert(response);
            $('#userTable').load('../home/updateusertable');
            $( '#adduserform' ).each(function(){
                this.reset();
            });
        },
        error: function(jqXHR, exception) {
            alert('Form not submitted - Ajax Error: ' + exception);
        }
    });

    return false;
};




