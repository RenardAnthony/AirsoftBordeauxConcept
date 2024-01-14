var messageDiv = document.getElementById('erreur_message');

if(messageDiv){
    setTimeout(sup_error_message, 5000);
}

function sup_error_message(){

    if(messageDiv){
        messageDiv.style.display='none';
    }
}