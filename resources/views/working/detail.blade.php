<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<style type="text/css">
		.datered{
			background-color :red;
			color: white;
			border-radius :30%;
		}	
		.dategreen{
			background-color :green;
			color: white;
			border-radius :30%;
		}	
	</style>
	
</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">       
	
		<div class="tab">
		  <button class="tablinks active" onclick="openCity(event, 'Profile')">Profile</button>
		</div>		

		<div id="Profile" class="tabcontent" style="display: block;"/>						
		  <div class="row">
		  	<div class="col-md-12">
		  		<label>
		  			<input type="radio" name="type" value="present">present not late
		  		</label>
		  		<label>
		  			<input type="radio" name="type" value="present_late">present late
		  		</label>
		  	</div>
		  </div>
		  <br/>
		  <div class="row">
		  	<div class="col-md-12">
		  		<div data-provide="calendar"></div>
		  	</div>
		  </div>
		  
		</div>
		
		
	</div>	    	
</div>
@include("footer")
</body>
</html>
