/* 
 * Indeed Crawler Page
 * UI for crawler page
 * Author: Jexter Dean Buenaventura
 */


$('body').on('click','.start-crawler',function(e){
   e.preventDefault();
    var email = $('#email').val();
    var password = $('#password').val();
    var company_id = $('#company-list option').val(); 
    startImport(email,password,company_id);
});


function startImport(email,password,company_id) {
    var ajaxurl = public_path + '/indeed/import';  
    $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
            email:email,
            password:password,
            company_id:company_id
        },
        // THIS MUST BE DONE FOR FILE UPLOADING
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
        },
        complete: function () {

        },
        error: function (xhr, status, error) {
        }

    });
}


