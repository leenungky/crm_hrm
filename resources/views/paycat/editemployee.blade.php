<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<script type="text/javascript">
		var trans_price = 0;
	</script>
     @include('head')
     
</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">       
		@include('header')		
		<br/>

		
		<div class="row">
			<div class="col-md-12" style="text-align: center;font-weight: bold;font-size: 16px;">
				{{$employee->nik}} - {{$employee->name}} <br/> 
				{{$paycat->formula}}
			</div>
		<div>
		<div class="row">	
			<div class="col-md-12">		
				<form method="post" action="/transaction/create" id="formsubmit">
					@foreach ($components as $key => $value)
						<div class="form-group">
						    <label for="email">{{$value}}</label>
							 <input type="text" class="form-control" id="sender" name="sender" value="">
						</div>	
					@endforeach
					<button type="submit" class="btn btn-submit">Submit</button>
				</form>
			</div>
		</div>
	 </div>	    	
</div>


</body>
</html>
<script type="text/javascript">	
	$(document).ready(function(){

	});  
</script>