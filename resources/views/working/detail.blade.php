<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	
	
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
		  	<div class="col-md-12 title-type">
		  		<div class="radio">
				  <label>
				    <input type="radio" name="type" value="present" checked>
				    <span class="dategreen" style="border-radius: 3px;">present not late</span>
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="type" value="present_late">
				    <span class="datered" style="border-radius: 3px;">present late</span>				    
				  </label>
				</div>		  		
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
