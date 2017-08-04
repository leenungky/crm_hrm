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
				            <li>{{str_replace("name","Nama toko",$error)}}</li>
				        @endforeach 
				    </ul>
			    </div>
		    </div>
		@endif 
		<br/>
		<div class="row">				
			<div class="col-md-12">		
				<form method="post" action="/cuti/create" class="formsubmit">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">					
					<div class="form-group">
					    <label for="email">Nama</label>
						 <input type="text" class="form-control" id="nama" name="name" placeholder="input nama" value="{{ old('code') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">total hari</label>
					    <input type="text" class="form-control" name="days" placeholder="Input Total" value="{{ old('days') }}" required>		 
					</div>
					<div class="form-group">
					    <label for="email">mengurangi cuti</label>
					    <select name="isdeduction" class="form-control" required>
					    	<option>Pilih</option>
					    	@if (old('isdeduction')=="1")
					    		<option value="1" selected>Yes</option>
					    	@else
					    		<option value="1">Yes</option>
					    	@endif

					    	@if (old('isdeduction')=="0")
					    		<option value="0" selected>No</option>
					    	@else
					    		<option value="0">No</option>
					    	@endif					    	
					    </select>			 
					</div>										
					<button type="submit" class="btn">Submit</button>
				</form>
			</div>
		</div>
	</div>	    	
</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){	
		$( "input[name=name]" ).focus();
	});
</script>