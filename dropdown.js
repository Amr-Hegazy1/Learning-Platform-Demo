const dropDownEl = document.getElementById("drop-down")
const dropDownOptionsEl = document.getElementById("options")
const optionsArrayEl = document.getElementsByClassName("option")
const realDropdownEl = document.getElementById("id")
const selectedDropEl = document.getElementById("selected-drop")
const exitDropEl = document.getElementById("exit-drop")


exitDropEl.addEventListener("click",()=>{
    exitDropEl.classList.toggle("close")
    dropDownOptionsEl.classList.toggle("open-options")
})

dropDownEl.addEventListener("click",()=>{
    exitDropEl.classList.toggle("close")
    dropDownOptionsEl.classList.toggle("open-options")
})

for(let i=0;i<optionsArrayEl.length;i++){
    optionsArrayEl[i].addEventListener("click",()=>{
        exitDropEl.classList.toggle("close")
        selectedDropEl.innerHTML = optionsArrayEl[i].innerHTML
        realDropdownEl.value = optionsArrayEl[i].innerHTML
        dropDownOptionsEl.classList.toggle("open-options")
    })
}


