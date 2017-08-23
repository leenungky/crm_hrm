<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
     @include('head')
     <style type="text/css" media="print">
     	   @media print {
			    @page { margin: 0px 6px; }
  				body  { margin: 0px 6px; }   					  
			}
     </style>
</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">       
		@include('header')		
		<br/>
		@if (count($errors))     
			<div class="row">				
				<div class="col-md-12 alert alert-danger">		
				    <ul>
				        @foreach($errors->all() as $error) 		            				            
				            <li>{{$error}}</li>
				        @endforeach 
				    </ul>
			    </div>
		    </div>
		@endif 
		<br/>
		<div class="row">				
			<div class="col-md-12">											
					<div class="row">	
						<div class="col-md-4 load-tree">
						
						</div>
						<div class="col-md-3">							
							<br>&nbsp;<br/>							
							<button class="btn btn-move"> >> </button>											
							<button class="btn btn-clear">Clear</button>	
							<button class="btn btn-delete">Del</button>	
							<br>&nbsp;<br/>		
											<div class="form-group">
							    <button class="btn btn-kurungbuka">(</button>					 
							    <button class="btn btn-kurungtutup">)</button>					 
							    <button class="btn btn-tambah">+</button>					 
							    <button class="btn btn-kurang">-</button>					 
							    <button class="btn btn-bagi">/</button>		
							    <button class="btn btn-kali">X</button>		
							    <br>&nbsp;<br/>		
							    				 
							</div>			

						</div>
						<div class="col-md-5">
							<form method="post" action="/pcat/update/{{$paycat->id}}" class="formsubmit">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">					
							<div class="form-group">
							    <label for="email">Nama</label>
								 <input type="text" class="form-control" id="nama" name="name" placeholder="input nama" value="{{$paycat->name}}" required>
							</div>					
							<div class="form-group">
							    <label for="email">Formula</label>
							    <p>Pastikan rumus dibawah <span style="color:red">benar</span></p>
							    <textarea class="form-control" id="formula" rows="8" name="formula" placeholder="Input description" required>{{$paycat->formula}}</textarea>	
							</div>										
			
							<br/>&nbsp;
\
							<button type="submit" class="btn btn-submit btn-primary">Submit</button>												
							<a href="/pcat/list" class="btn btn-primary">Cancel</a>	
						</div>
					</div>								
					
				
			</div>
		</div>
	</div>	    	
</div>
</body>
</html>

<script type="text/javascript">

	$(document).ready(function(){	
		$( "input[name=name]" ).focus();
		$('.load-tree').load(base_url + "/payroll/tree");
		$(document).on("click",".right-click", function(){
			$(".tree").find('*').removeClass('tree-active');
			$(this).addClass("tree-active");
		})
		$(".btn-delete").click(function(){	
			var formula = $("#formula").val();					
			var newformula = formula.substring(0,formula.length - 1);
			$("#formula").val(newformula);
		});
		$(".btn-kurungbuka").click(function(){			
			addDescription(" ( ");
		});

		$(".btn-kurungtutup").click(function(){			
			addDescription(" ) ");
		});

		$(".btn-tambah").click(function(){			
			addDescription(" + ");
		});

		$(".btn-kurang").click(function(){			
			addDescription(" - ");
		});

		$(".btn-bagi").click(function(){			
			addDescription(" / ");
		});

		$(".btn-kali").click(function(){			
			addDescription(" * ");
		});

		$(".btn-clear").click(function(){			
			$("#formula").val("");
		});

		

		$(".btn-move").click(function(){
			var data = $(".tree").find('.tree-active').text();
			addDescription(data);			
		});



		$(".btn-submit").click(function(){
			var data_post = { 
				_token : "{{ csrf_token() }}",
				name   	: $("input[name='name']").val() ,
				formula : $("textarea[name='formula']").val()
			};
			$.post("/pcat/create",data_post, function(result) {		
				if (data.response.code==200){
					$(".info-notify-add-karyawan").html(data.response.message);
					$(".info-notify-add-karyawan").show();
					location.href="/employ/list";

				}else{
					$(".info-notify-add-karyawan").hide();
					$(".error-notify-add-karyawan").html(data.response.message);
					$(".error-notify-add-karyawan").show();
				}
			});
		});
	});

	function addDescription(data){
		var formula = $("#formula").val();		
		insertAtCaret('formula', data);
		// $("#formula").insertAtCaret(data);
		// $("#formula").val(formula + data);
	}

	function insertAtCaret(areaId, text) {
		var txtarea = document.getElementById(areaId);
		if (!txtarea) { return; }

		var scrollPos = txtarea.scrollTop;
		var strPos = 0;
		var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
			"ff" : (document.selection ? "ie" : false ) );
		if (br == "ie") {
			txtarea.focus();
			var range = document.selection.createRange();
			range.moveStart ('character', -txtarea.value.length);
			strPos = range.text.length;
		} else if (br == "ff") {
			strPos = txtarea.selectionStart;
		}

		var front = (txtarea.value).substring(0, strPos);
		var back = (txtarea.value).substring(strPos, txtarea.value.length);
		txtarea.value = front + text + back;
		strPos = strPos + text.length;
		if (br == "ie") {
			txtarea.focus();
			var ieRange = document.selection.createRange();
			ieRange.moveStart ('character', -txtarea.value.length);
			ieRange.moveStart ('character', strPos);
			ieRange.moveEnd ('character', 0);
			ieRange.select();
		} else if (br == "ff") {
			txtarea.selectionStart = strPos;
			txtarea.selectionEnd = strPos;
			txtarea.focus();
		}

		txtarea.scrollTop = scrollPos;
	}
</script>
