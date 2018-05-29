$(document).ready(function(){
    $('#validUser').hide();
    $('#validPass').hide();
    $('#validPass2').hide();
    $('#validPassEqual').hide();
    
    $('#btnRegistro').on('click',function(){
        $error = 0;
        if ($('#user').val() == ''){
            $('#validUser').show();
            $error++;
        } else {
            $('#validUser').hide();
        }
        
        if ($('#pass').val() == '') {
            $('#validPass').show();
            $error++;
        } else {
            $('#validPass').hide();
        } 
        if ($('#pass').val() == '') {
            $('#validPass2').show();
            $error++;
        } else {
            $('#validPass2').hide();
        } 
        if ($('#pass').val() != $('#pass2').val()) {
            $('#validPassEqual').show();
            $error++;
        } else {
            $('#validPassEqual').hide();
        }
        debugger;
        if ($error > 0)
            return false;
        else 
            return true;
    })
});