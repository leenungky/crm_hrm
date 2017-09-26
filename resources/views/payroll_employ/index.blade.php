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
		<div class="row">	
			<form action="/payrollemploy/list" method="get">
				<div class="col-md-3">
					Year :
					<select class="form-control" name="year">
						<?php
							for ($x = $year["from"]; $x <= $year["to"]; $x++) {
								if (isset($input["year"])){
									if ($x==$input["year"]){
										echo "<option selected>".$x."</option>";
									}else{
										echo "<option>".$x."</option>";										
									}	
								}else{
									if ($x==date("Y"))
										echo "<option selected>".$x."</option>";
									else
										echo "<option>".$x."</option>";
									
								}
								
							}
						?>
					</select>
				</div>				
				<div class="col-md-2">
					Month 
					<select class="form-control" name="month">
						@foreach ($month as $key => $value)
							@if (isset($input["month"]))
								@if ($input["month"]==$key)
									<option value="{{$key}}" selected>{{$value}}</option>
								@else
									<option value="{{$key}}">{{$value}}</option>
								@endif
							@else								
								@if ($key==date("m"))
									<option value="{{$key}}" selected>{{$value}}</option>
								@else
									<option value="{{$key}}">{{$value}}</option>
								@endif
							@endif
							
						@endforeach
					</select>
				</div>
				<div class="col-md-2">
					&nbsp;
					<br/>
					<input type="submit" value="Find" class="btn btn-primary">
				</div>

			</form>
		</div>
		<br/>
		 @if(Session::has('message'))
            <div class="row">               
                <div class="col-md-12 alert alert-warning">      
                    <ul>
                        <li>{!! Session::get('message') !!}</li>                      
                    </ul>
                </div>
            </div>
            <br/>
        @endif  		
		<div class="row">	
			<div class="col-md-12">
				<table class="table">
					<?php 
						$str_parameter = "";
						if (isset($order_by)){
							if ($order_by=="asc"){
								$str_parameter = "&order_by=desc";
							}
							else if ($order_by=="desc"){
								$str_parameter = "&order_by=asc";
							}	
						}
					?>
					<thead>
						<th>Nik</th>
						<th>Nama</th>	
						@foreach ($columns as $key => $value)
							<th>{{$value}}</th>
						@endforeach
						<th>Total</th>
						<th>Action</th>
					</thead>
					<tbody>		
						@foreach ($payroll_emp as $key => $value)
							<tr>
								<td>{{$value["nik"]}}</td>
								<td>{{$value["name"]}}</td>		
								@foreach ($columns as $key1 => $value1)
									<td>{{$value[$value1]}}</td>											
								@endforeach						
								<td></td>		
								<td>
									<a href="javascript:void(0)" class="link-edit" val-id="{{$value["emp_id"]}}">										
					    				<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>
				    				</a> | 
				    				<a href="/employ/delete/" val-id="{{$value["emp_id"]}}" class="confirmation">
					    				<span class="delete">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> 
								</td>
							</tr>
						@endforeach						
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-primary btn-submit">Posting</button>
			</div>
		</div>
	 </div>	    	
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		$(".link-edit").click(function(){
			var val = $(this).attr("val-id");
			var year = $("select[name='year']").val();
			var month = $("select[name='month']").val();			
			location.href="/payrollemploy/editemployee/" + val + "?month=" + month + "&year=" + year;
		})
	})
</script>