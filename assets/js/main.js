
window.onload = (event) => {

    const moreInfo = document.getElementById("more-info-of-class");
    const shareContent = document.getElementById("share-content");
    const partition = document.getElementById("section-partition");
    const btnCancel = document.getElementById("cancel");

    $('#ost').click((event)=>{
        $('#ost').css('background-color','#0987bd');
        $('#ost').css('color','white');
        setTimeout(()=>{$('#ost').css('background-color','#def6fa');
            $('#ost').css('color','black');},200);
    });
    $('#btn-header').click( (e) => {
        e.preventDefault();
        if (moreInfo.style.display == "none")
            moreInfo.style.display = "block";
        else
            moreInfo.style.display = "none";
    });
    $('#share-content').click( (e) => {
        e.preventDefault();
        shareContent.style.display = "none";
        partition.style.display = "block";
    });
    $('#cancel').click( (e) => {
        e.preventDefault();
        shareContent.style.display = "block";
        partition.style.display = "none";
    });


};

(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
function Open_attend_class(){
    $(".attend-class").show("slow");
}
function Close_attend_class(){
    $(".attend-class").hide("slow");
}
function Open_create_class(){
    $(".create-class-form-container").show("slow");
}
function Close_create_class(){
    $(".create-class-form-container").hide("slow");
}

