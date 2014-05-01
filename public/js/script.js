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
        url: '../index/adduser/',
        data:$('#adduserform').serialize(), 
        success: function(response) {
            $('#userTable').load('../index/updateUserTable');
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




