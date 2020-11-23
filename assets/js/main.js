
window.onload = (event) => {
    const btnHeader = document.getElementById("btn-header");

};
const moreInfo = document.getElementById("more-info-of-class");
$('#btn-header').click( (e) => {
    e.preventDefault();
    if (moreInfo.style.display == "none")
        moreInfo.style.display = "block";
    else
        moreInfo.style.display = "none";
});