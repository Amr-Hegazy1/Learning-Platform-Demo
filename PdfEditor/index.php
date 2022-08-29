
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css">
	<link rel="stylesheet" href="./styles.css">
	<link rel="stylesheet" href="./pdfannotate.css">
</head>
<body onload="init()" style="touch-action:pan-y">
<div style="text-align: center">
	<div class="spinner-border" role="status">
		<span class="visually-hidden">Loading...</span>
	</div>
</div>
<div id="pdf-editor">
	<br><br><br>
	<div class="toolbar">
		
		<div class="tool">
			<span>PDF Editor</span>
		</div>
		<div class="tool">
			<label for="">Brush size</label>
			<input type="number" class="form-control text-right" value="1" id="brush-size" max="50">
		</div>
		<div class="tool">
			<label for="">Font size</label>
			<select id="font-size" class="form-control">
				<option value="10">10</option>
				<option value="12">12</option>
				<option value="16" selected>16</option>
				<option value="18">18</option>
				<option value="24">24</option>
				<option value="32">32</option>
				<option value="48">48</option>
				<option value="64">64</option>
				<option value="72">72</option>
				<option value="108">108</option>
			</select>
		</div>
		<div class="color-tool">
			<input type="color" id="color-picker" class="field-radio" onchange="changeColor(this)">
		</div>
		<div class="tool">
			<button class="tool-button active"><i class="fa fa-mouse-pointer" aria-hidden="true" onclick="enablePointer(event)"></i></button>
		</div>
		<div class="tool">
			<button class="tool-button"><i class="fa fa-hand-paper-o" title="Free Hand" onclick="enableSelector(event)"></i></button>
		</div>
		<div class="tool">
			<button class="tool-button"><i class="fa fa-pencil" title="Pencil" onclick="enablePencil(event)"></i></button>
		</div>
		<div class="tool">
			<button class="tool-button"><i class="fa fa-font" title="Add Text" onclick="enableAddText(event)"></i></button>
		</div>
		<div class="tool">
			<button class="tool-button"><i class="fa fa-long-arrow-right" title="Add Arrow" onclick="enableAddArrow(event)"></i></button>
		</div>
		<div class="tool">
			<button class="tool-button"><i class="fa fa-square-o" title="Add rectangle" onclick="enableRectangle(event)"></i></button>
		</div>
		<div class="tool">
			<button class="tool-button"><i class="fa fa-picture-o" title="Add an Image" onclick="addImage(event)"></i></button>
		</div>
		<div class="tool">
			<button class="btn btn-danger btn-sm" onclick="deleteSelectedObject(event)"><i class="fa fa-trash"></i></button>
		</div>
		<div class="tool">
			<button class="btn btn-danger btn-sm" onclick="clearPage()">Clear Page</button>
		</div>
		<div class="tool">
			<button class="btn btn-info btn-sm" onclick="undo(event)" title="Undo" style="color: white;">⤺</button>
		</div>
		<div class="tool">
			<button class="btn btn-info btn-sm" onclick="redo(event)" title="Redo" style="color: white;">⤻</button>
		</div>

		<div class="tool">
			<button class="btn btn-info btn-sm" onclick="zoomIn()" title="Zoom In"><i class="fa fa-plus" aria-hidden="true" style="color: white;"></i></button>
		</div>

		<div class="tool">
			<button class="btn btn-info btn-sm" onclick="zoomOut()" title="Zoom Out"><i class="fa fa-minus" aria-hidden="true" style="color: white;"></i></button>
		</div>
		<div class="tool">
			<button class="btn btn-light btn-sm" onclick="savePDF()"><i class="fa fa-save"></i> Save</button>
		</div>
		
	</div>
	


	<div id="pdf-container"></div>

	<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="dataModalLabel">PDF annotation data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<pre class="prettyprint lang-json linenums">
					</pre>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
<script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.0/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
<script src="./arrow.fabric.js"></script>
<script src="./sample_output.js"></script>
<script src="./pdfannotate.js"></script>

<script src="script.js"></script>
<script src="pinch.js"></script>









</body>
</html>
