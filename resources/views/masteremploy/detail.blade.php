<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>    
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">       
	
		<div class="tab">
		  <button class="tablinks active" onclick="openCity(event, 'payment')">Payment</button>		  		  
		</div>		

		<div id="payment" class="tabcontent" style="display: block;"/>						
		  <h3></h3><br/>
		  @include("masteremploy._detail")
		</div>		
		
	</div>	    	
</div>
@include("footer")
</body>
</html>