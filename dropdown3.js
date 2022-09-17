const dropDownEl = document.getElementById("drop-down")
const dropDownEl2 = document.getElementById("drop-down2")
const dropDownEl3 = document.getElementById("drop-down3")

const dropDownOptionsEl = document.getElementById("options")
const dropDownOptionsEl2 = document.getElementById("options2")
const dropDownOptionsEl3 = document.getElementById("options3")

const optionsArrayEl = document.getElementsByClassName("option")
const optionsArrayEl2 = document.getElementsByClassName("option2")
const optionsArrayEl3 = document.getElementsByClassName("option3")

const realDropdownEl = document.getElementById("id")
const realDropdownEl2 = document.getElementById("id2")
const realDropdownEl3 = document.getElementById("id3")

const selectedDropEl = document.getElementById("selected-drop")
const selectedDropEl2 = document.getElementById("selected-drop2")
const selectedDropEl3 = document.getElementById("selected-drop3")

const exitDropEl = document.getElementById("exit-drop")
let currentDropOptionsEl = ""




exitDropEl.addEventListener("click",()=>{
    exitDropEl.classList.toggle("close")
    if(currentDropOptionsEl==dropDownOptionsEl){
        currentDropOptionsEl.classList.toggle("open-options")
    }else{
        currentDropOptionsEl.classList.toggle("open-options")
    }
})

dropDownEl.addEventListener("click",()=>{
    currentDropOptionsEl = dropDownOptionsEl
    exitDropEl.classList.toggle("close")
    dropDownOptionsEl.classList.toggle("open-options")
})

dropDownEl2.addEventListener("click",()=>{
    currentDropOptionsEl = dropDownOptionsEl2
    exitDropEl.classList.toggle("close")
    dropDownOptionsEl2.classList.toggle("open-options")
})

dropDownEl3.addEventListener("click",()=>{
    currentDropOptionsEl = dropDownOptionsEl3
    exitDropEl.classList.toggle("close")
    dropDownOptionsEl3.classList.toggle("open-options")
})

for(let i=0;i<optionsArrayEl.length;i++){
    optionsArrayEl[i].addEventListener("click",()=>{
        exitDropEl.classList.toggle("close")
        selectedDropEl.innerHTML = optionsArrayEl[i].innerHTML
        if(optionsArrayEl[i].innerHTML=="Available"){
            realDropdownEl.value = "1"
        }else{
            realDropdownEl.value = "0"
        }
        dropDownOptionsEl.classList.toggle("open-options")
    })
}

for(let i=0;i<optionsArrayEl2.length;i++){
    optionsArrayEl2[i].addEventListener("click",()=>{
        exitDropEl.classList.toggle("close")
        selectedDropEl2.innerHTML = optionsArrayEl2[i].innerHTML
        realDropdownEl2.value = optionsArrayEl2[i].innerHTML
        dropDownOptionsEl2.classList.toggle("open-options")
    })
}

for(let i=0;i<optionsArrayEl3.length;i++){
    optionsArrayEl3[i].addEventListener("click",()=>{
        exitDropEl.classList.toggle("close")
        selectedDropEl3.innerHTML = optionsArrayEl3[i].innerHTML
        realDropdownEl3.value = optionsArrayEl3[i].innerHTML
        dropDownOptionsEl3.classList.toggle("open-options")
    })
}