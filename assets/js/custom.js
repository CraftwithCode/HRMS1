$(document).ready(function() {
    
    jQuery('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        // endDate: '31-12-2015',
        // startDate: '01-01-1951',
        autoclose: true,
    });
    // jQuery('.datepicker').datepicker({
    //     format: 'dd-mm-yyyy',
    //     endDate: '31-12-2015',
    //     startDate: '01-01-1951',
    //     autoclose: true,
    // });
});

// function refreshCaptcha()
// {
//     var img = document.images['captchaimg'];
//     img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
// }