
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
function remove_People(){
    let td = item_remove.parent().parent().parent();
    let tr = td.parent();
    tr.remove();
}

//Xóa người dùng ra khỏi lớp học
let item_remove = null;
$(".btn-remove-people").on("click", function(event){
    item_remove=$(this);
});
$(".accept_remove_people").on("click", function(event){
    remove_People();
    item_remove = null;
});
$(".refuse_remove_people").on("click", function(event){
    item_remove = null;
});
//Thay đổi giao diện nút được nhấn hoặc rơ chuột
let current_function_button = null;
$('.function-button').on("click",function (event){
    if(current_function_button != null){
        current_function_button.css('border-bottom','#f8f9fa 4px solid');
        current_function_button.css('color','rgba(0,0,0,.9)');
    }
    $(this).css('border-bottom','#07a36f 4px solid');
    $(this).css('color','#07a36f');
    $(this).css('background-color','#c4f5e5');
    current_function_button = $(this);
});
$('.function-button').on('mouseenter',function (event){
    if(current_function_button!=null){
        if(current_function_button.text() == $(this).text()){
            current_function_button.css('background-color','#dff5ee');
        }
        else{
            $(this).css('background-color','#d9dadb');
        }
    }
    else{
        $(this).css('background-color','#d9dadb');
    }
});
$('.function-button').on('mouseleave',function (event){
    $(this).css('background-color','#f8f9fa');
});