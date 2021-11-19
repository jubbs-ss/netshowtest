function validaArquivo(){
    if($('#arquivo').val() == '')
    {
        alert('OOOPS, é necessário que você suba um arquivo.');
        return false;
    }
    var ext = $('#arquivo').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['pdf','doc','odt','txt']) == -1) {
        alert('OOOPS, extensão doarquivo inválida');
        return false;
    }

    return;
}

function validateEmail() {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(! re.test(String($('#email').val()).toLowerCase()))
    {
        alert('É necessário que o preenchimento seja um email válido');
        $('#email').val('');
    }
}

function validaTelefone(){
    var caracteresDigitados = $('#telefone').val().length;
    if(caracteresDigitados < 10 || caracteresDigitados > 11){
        alert('Digite um telefone válido');
        $('#telefone').val('');
    }
}

function allowOnlyNumbers(e) {
    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla > 47 && tecla < 58)) return true;
    else {
        if (tecla == 8 || tecla == 0) return true;
        else return false;
    }
}

$('#arquivo').bind('change', function() {
    if(this.files[0].size > 512420)
    {
        alert('O arquivo deve ter no máximo 500kb');
        $('#arquivo').val('');
    }
});
