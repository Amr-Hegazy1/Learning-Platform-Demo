const realButtonEl = document.getElementById("file-button")
const fileTextEl = document.getElementById("file-text")

realButtonEl.addEventListener("change",()=>{
    if(realButtonEl.value){
        fileTextEl.innerHTML = realButtonEl.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1]
    }else{
        fileTextEl.innerHTML = "No File Chosen"
    }
})