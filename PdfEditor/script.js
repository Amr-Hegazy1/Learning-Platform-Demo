$(".spinner-border").show();
$("#pdf-editor").hide();
var paramString = window.location.href.split('?')[1];
var queryString = new URLSearchParams(paramString);

workFile = queryString.get("workFile");

let undoStack = [];

let redoPageStack = [];
	
let zoom = 1;

let originalHeight = 0;

  
pdf = new PDFAnnotate('pdf-container',"../PdfEditor/fetch_pdf.php?workFile="+workFile , {
  onPageUpdated(page, oldData, newData,objs) {
    console.log(page, oldData, newData);
    undoStack.push(page-1);
  },
  ready() {
    console.log('Plugin initialized successfully');
    $(".spinner-border").hide();
    pdf.loadFromJSON(sampleOutput);
    $("#pdf-editor").show();
    $("body").css({"background-color":"rgb(82, 86, 89)"});
    originalHeight =  $("#pdf-container").height();
    
  },
  scale: 1.5,
  pageImageCompression: 'FAST', // FAST, MEDIUM, SLOW(Helps to control the new PDF file size)
});





function changeActiveTool(event) {
  var element = $(event.target).hasClass('tool-button')
    ? $(event.target)
    : $(event.target).parents('.tool-button').first();
  $('.tool-button.active').removeClass('active');
  $(element).addClass('active');
}

function enableSelector(event) {
  event.preventDefault();
  changeActiveTool(event);
  pdf.enableSelector();
}

function enablePencil(event) {
  event.preventDefault();
  changeActiveTool(event);
  pdf.enablePencil();
}

function enableAddText(event) {
  event.preventDefault();
  changeActiveTool(event);
  pdf.enableAddText();
}

function enableAddArrow(event) {
  event.preventDefault();
  changeActiveTool(event);
  pdf.enableAddArrow(function () {
    $('.tool-button').first().find('i').click();
  });
}

function addImage(event) {
  event.preventDefault();
  pdf.addImageToCanvas();
}

function enableRectangle(event) {
  event.preventDefault();
  changeActiveTool(event);
  pdf.setColor('rgba(255, 0, 0, 0.3)');
  pdf.setBorderColor('blue');
  pdf.enableRectangle();
}

function deleteSelectedObject(event) {
  event.preventDefault();
  pdf.deleteSelectedObject();
}

function undo(event,page) {
  event.preventDefault();
  pdf.undo(page);
}
function redo(event,page) {
  event.preventDefault();
  pdf.redo(page);
}


function savePDF() {
  // pdf.savePdf();
  $("body").css({"background-color":"white"});
  $(".spinner-border").show();

  pdf.savePdf('output.pdf'); // save with given file name
  $(".spinner-border").hide();
  $("body").css({"background-color":"rgb(82, 86, 89)"});
  
}

function clearPage() {
  pdf.clearActivePage();
}

function showPdfData() {
  pdf.serializePdf(function (string) {
    $('#dataModal .modal-body pre')
      .first()
      .text(JSON.stringify(JSON.parse(string), null, 4));
    PR.prettyPrint();
    $('#dataModal').modal('show');
  });
}

function zoomIn(){
  zoom += 0.25;
  if(zoom > 0){
    $("#pdf-container").css({"transform":"scale("+ zoom + ")"});
    $("#pdf-container").height(originalHeight);
    $("#pdf-editor").height(originalHeight);
  }
}

function zoomOut(){
  zoom -= 0.25;
  if(zoom > 0 && zoom < 1){
    $("#pdf-container").css({"transform":"scale("+ zoom + ")"});
    $("#pdf-container").height(originalHeight*zoom);
    $("#pdf-editor").height(originalHeight*zoom);
  }else if(zoom >= 1){
    $("#pdf-container").css({"transform":"scale("+ zoom + ")"});
    $("#pdf-container").height(originalHeight);
    $("#pdf-editor").height(originalHeight);
  }
  if (zoom < 0)
    zoom = 0.25;
  
}

$(function () {
  

  $('#brush-size').change(function () {
    var width = $(this).val();
    pdf.setBrushSize(width);
  });

  $('#font-size').change(function () {
    var font_size = $(this).val();
    pdf.setFontSize(font_size);
  });
});
function changeColor(e){
  pdf.setColor(e.value);
}

document.onkeydown = function (e) {
  
  if (e['key'] == "Delete")
    deleteSelectedObject(e);

  
    if( e.which === 90 && (e.ctrlKey || e.metaKey) && e.shiftKey ){
      redo(e,redoPageStack.pop()); 
   }
   else if( e.which === 90 && (e.ctrlKey || e.metaKey) ){
      var undone = undoStack.pop();
      redoPageStack.push(undone);
      undo(e,undone); 
   }          
  

  
  
};


