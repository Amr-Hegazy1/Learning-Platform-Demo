const dropDownEl = document.getElementById("drop-down")
const dropDownEl2 = document.getElementById("drop-down2")
const dropDownOptionsEl = document.getElementById("options")
const dropDownOptionsEl2 = document.getElementById("options2")
const optionsArrayEl = document.getElementsByClassName("option")
const optionsArrayEl2 = document.getElementsByClassName("option2")
const realDropdownEl = document.getElementById("id")
const realDropdownEl2 = document.getElementById("id2")
const selectedDropEl = document.getElementById("selected-drop")
const selectedDropEl2 = document.getElementById("selected-drop2")
const exitDropEl = document.getElementById("exit-drop")
let currentDropOptionsEl = ""

dropDownEl2.addEventListener("click",()=>{
    currentDropOptionsEl = dropDownOptionsEl2
    exitDropEl.classList.toggle("close")
    dropDownOptionsEl2.classList.toggle("open-options")
})


exitDropEl.addEventListener("click",()=>{
    exitDropEl.classList.toggle("close")
    currentDropOptionsEl.classList.toggle("open-options")
})

dropDownEl.addEventListener("click",()=>{
    currentDropOptionsEl = dropDownOptionsEl
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

for(let i=0;i<optionsArrayEl2.length;i++){
    optionsArrayEl2[i].addEventListener("click",()=>{
        exitDropEl.classList.toggle("close")
        selectedDropEl2.innerHTML = optionsArrayEl[i].innerHTML
        realDropdownEl2.value = optionsArrayEl[i].innerHTML
        dropDownOptionsEl2.classList.toggle("open-options")
    })
}


