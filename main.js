
window.onload = (event) => {

    const btnHeader = document.getElementById("btn-header");
    const moreInfo = document.getElementById("more-info-of-class");
    const shareContent = document.getElementById("share-content");
    const partition = document.getElementById("section-partition");
    const btnCancel = document.getElementById("cancel");

    $('#btn-header').on("click", (e) => {
        e.preventDefault();
        if (moreInfo.style.display == "block")
            moreInfo.style.display = "none";
        else
            moreInfo.style.display = "block";
    });
    $('#share-content').on("click", (e) =>{
        e.preventDefault();
        shareContent.style.display = "none";
        partition.style.display = "block";
    });

    $('#cancel').on("click", (e) => {
        e.preventDefault();
        shareContent.style.display = "block";
        partition.style.display = "none";
    });
    $.get( "http://localhost/user/inc/GetAction.php", function( data ) {
        var action = JSON.parse(data).action;
        if(action == 'ClassStream')
            ChangeFunctionBtnColor($('.stream-button'));
        else if(action == 'ClassPeople')
            ChangeFunctionBtnColor($('.people-button'));
    });
    $('#add-teacher-by-email').on('click',(e)=>{
        $('form').submit((ev)=>{
            ev.preventDefault();
        });
        let email = $('.teacher-email').val();
        $.post("inc/InviteTeacher.php", {Teacher_email: email}, function(data){
            let result = JSON.parse(data).result;
            if(result=="success"){
                alert("Mời giáo viên thành công và chờ xác nhận");
            }
            else{
                alert('Thêm giáo viên thất bại');
            }
            $('.teacher-email').val('');
        });
    });
    $('#add-student-by-email').on('click',(e)=>{
        $('form').submit((ev)=>{
            ev.preventDefault();
        });
        let email = $('.student-email').val();
        $.post("inc/InviteStudent.php", {Student_email: email}, function(data){
            let result = JSON.parse(data).result;
            if(result=="success"){
                alert("Mời sinh viên thành công và chờ xác nhận");
            }
            else{
                alert('Thêm sinh viên thất bại');
            }
            $('.student-email').val('');
        });
    });
    //Vô hiệu hóa nút tham gia
    $('.join-class').attr("disabled", true);
    $('.join-class').css( 'cursor', 'not-allowed' );
    $('#class-code').on('keyup',(e)=>{
       if($('#class-code').val().length > 2){
           $('.join-class').attr("disabled", false);
           $('.join-class').css( 'cursor', 'pointer' );
       }
       else{
           $('.join-class').attr("disabled", true);
           $('.join-class').css( 'cursor', 'not-allowed' );
       }
    });
    $('.join-class').on('click',(e)=>{
        e.preventDefault();
        let classCode = $('#class-code').val();
        $.post("inc/AcceptStudentFromCode.php", {code: classCode}, function(data){
            let result = JSON.parse(data).result;

            if(result=="success"){
                alert("Gửi yêu cầu tham gia lớp học thành công!!!");
            }
            else{
                alert('Gửi yêu cầu thất bại: '+result['reason']);
            }
            $('#class-code').val('');
            $('.join-class').attr("disabled", true);
            $('.join-class').css( 'cursor', 'not-allowed' );
        });
    });

};

(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        let forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        let validation = Array.prototype.filter.call(forms, function(form) {
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
function Open_change_class(){
    $(".change-class-form-container").show("slow");
}
function Close_change_class(){
    $(".change-class-form-container").hide("slow");
}
let rs = false;
function remove_People(){
    let ID = item_remove.id;
    let btn = item_remove.button;
    let td = btn.parent().parent().parent();
    let tr = td.parent();
    $.post("inc/RemovePeople.php", {ID: ID}, function(data){
        let result = JSON.parse(data).result;
        if(result=="success"){
            tr.remove();
        }
        else{
            alert(result);
        }
    });

}

//Xóa người dùng ra khỏi lớp học
let item_remove = null;
$(".btn-remove-people").on("click", function(event){
    let btn = $(this);
    let span = btn.parent();
    let div = span.parent();
    let Class = div.attr('class');
    let ID = getFinalClass(Class);
    item_remove={button: $(this),id : ID};
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
function ChangeFunctionBtnColor(btn){
    if(current_function_button != null){
        current_function_button.css('border-bottom','#f8f9fa 4px solid');
        current_function_button.css('color','rgba(0,0,0,.9)');
    }
    btn.css('border-bottom','#07a36f 4px solid');
    btn.css('color','#07a36f');
    current_function_button = $(this);
};
$('.function-button').hover(function (event){
    event.preventDefault();
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
},function (){
    $(this).css('background-color','#f8f9fa');
});
$('#log-out-btn').on('click',function (){
    if(confirm('Xác nhận đăng xuất')){
        window.location.href = 'logout.php';
    }

});
function setQueryStringParameter(name, value) {
    const params = new URLSearchParams(location.search);
    params.set(name, value);
    window.history.replaceState({}, "", decodeURIComponent(`${location.pathname}?${params}`));
}
function getSearchParameters() {
    let prmstr = window.location.search.substr(1);
    return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
}

function transformToAssocArray( prmstr ) {
    let params = {};
    let prmarr = prmstr.split("&");
    for ( let i = 0; i < prmarr.length; i++) {
        let tmparr = prmarr[i].split("=");
        params[tmparr[0]] = tmparr[1];
    }
    return params;
}

let params = getSearchParameters();

function copyMyText() {
    //select the element with the id "copyMe", must be a text box
    let Text = document.getElementById("copyMe").innerText;
    //select the text in the text box
    appCopyToClipBoard(Text);
}
function appCopyToClipBoard(sText)
{
    var oText = false,
        bResult = false;
    try
    {
        oText = document.createElement("textarea");
        $(oText).addClass('clipboardCopier').val(sText).insertAfter('body').focus();
        oText.select();
        document.execCommand("Copy");
        bResult = true;
    }
    catch(e) {
    }

    $(oText).remove();
    return bResult;
}
function getFinalClass(String){
    let arrString = String.split(" ");
    return arrString[arrString.length - 1]
}
$(".btn-send-email-student").on("click",function(e){
    let btn = $(this);
    let span = btn.parent();
    let div = span.parent();
    let Class = div.attr('class');
    let ID = getFinalClass(Class);
    alert(ID);

});
$(".btn-send-email-teacher").on("click",function(e){
    let btn = $(this);
    let span = btn.parent();
    let div = span.parent();
    let Class = div.attr('class');
    let ID = getFinalClass(Class);

});
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
$('.btn-delete-class').on('click',()=>{
    $(".change-class-form-container").hide("slow");
});
$('.accept_remove_class').on('click',()=>{
    $.post("inc/RemoveClass.php", {remove_class: true}, function(data){
        if(data == 1){
            Redirect("Home.php");
        }
        else{
            alert("Xóa lớp học thất bại");
        }
    });
});
function Redirect(href) {
    window.location=href;
}

$(".mr-2 .btn-removing-student").on('click',function (e){
    let btn = $(this);
    let span = btn.parent();
    let div = span.parent();
    let td = div.parent();
    let tr = td.parent();
    let ID = div.attr("id");
    $.post("inc/ConfirmToAttend.php", {code: ID,action:'delete'}, function(data){

        let result = JSON.parse(data).result;
        if(result=="success"){
            alert('Thực hiện thành công');
            tr.remove();
        }
        else{
            alert('Thực hiện thất bại: '+result);
        }
    });
});

$(".mr-2 .btn-adding-student").on('click',function (e){
    let btn = $(this);
    let span = btn.parent();
    let div = span.parent();
    let ID = div.attr("id");
    let td = div.parent();
    let tr = td.parent();
    $.post("inc/ConfirmToAttend.php", {code: ID,action:'accept'}, function(data){
        let result = JSON.parse(data).result;
        if(result=="success"){
            alert('Thực hiện thành công');
            tr.remove();
        }
        else{
            alert('Thực hiện thất bại: '+result);
        }
    });
});
$(".set-admin-btn").on('click',function (e){
    let btn = $(this);
    let td = btn.parent();
    let ID = td.attr("id");
    let tr = td.parent();
    $.post("inc/ChangePermission.php", {username:ID,role:1}, function(data){
        let result = JSON.parse(data).result;
        if(result=="success"){
            alert('Thực hiện thành công');
            tr.remove();
        }
        else{
            alert('Thực hiện thất bại: '+result);
        }
    });
});
$(".set-teacher-btn").on('click',function (e){
    let btn = $(this);
    let td = btn.parent();
    let ID = td.attr("id");
    let tr = td.parent();
    $.post("inc/ChangePermission.php", {username:ID,role:2}, function(data){
        let result = JSON.parse(data).result;
        if(result=="success"){
            alert('Thực hiện thành công');
            tr.remove();
        }
        else{
            alert('Thực hiện thất bại: '+result);
        }
    });
});
$(".set-student-btn").on('click',function (e){
    let btn = $(this);
    let td = btn.parent();
    let ID = td.attr("id");
    let tr = td.parent();
    $.post("inc/ChangePermission.php", {username:ID,role:3}, function(data){
        let result = JSON.parse(data).result;
        if(result=="success"){
            alert('Thực hiện thành công');
            tr.remove();
        }
        else{
            alert('Thực hiện thất bại: '+result);
        }
    });
});