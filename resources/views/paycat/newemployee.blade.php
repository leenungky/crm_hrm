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
				<form method="post" action="/pcat/newemployee/{{$req->session()->get("pcat_id")}}" class="formsubmit">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
					    <label for="email">Karyawan</label>
						 <input type="text" class="form-control" id="name" name="name" placeholder="input nama department" value="{{ old('name') }}" required>
					</div>
					<button type="submit" class="btn">Submit</button>
				</form>
			</div>
		</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){	
		 var availableTags = [
		      @foreach ($employee as $key => $value)
		      	{value: "{{$value->nik}} - {{$value->name}}",label: "{{$value->nik}} - {{$value->name}}"},		      	
		      @endforeach		      
		    ];
		    $( "input[name=name]" ).autocomplete({
		      source: availableTags,
		      minLength: 2,
		      change: function(event,ui){
		      	console.log(ui);
		    	if (ui.item == null){                    
		        	$(this).val("");
		            return false;
		        }
		    }
		    });
		$( "input[name=name]" ).focus();


	});
</script>