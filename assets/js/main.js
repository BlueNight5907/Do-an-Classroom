const btnHeader = document.getElementById("btn-header");
const moreInfo = document.getElementById("more-info-of-class");

btnHeader.addEventListener("click", (e) => {
    e.preventDefault();
    if (moreInfo.style.display == "none")
        moreInfo.style.display = "block";
    else 
        moreInfo.style.display = "none";
});
