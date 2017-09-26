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
				<form method="post" action="/payroll/create/{{$parent_id}}" class="formsubmit">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">					
					<div class="form-group">
					    <label for="email">Nama</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="input nama component" value="{{ old('name') }}" required>
					</div>										
					<div class="form-group">
						<label>
							<input type="checkbox" id="is_master" name="is_master" placeholder="input nama component" value="master">
							Is Master
						</label>
					</div>										
					<button type="submit" class="btn">Submit</button>
				</form>
			</div>
		</div>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){	
		$("input[name=name]").focus();
	});
</script>