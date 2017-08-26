<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
     @include('head')
     <style type="text/css">     	   
		.employe_list{
			cursor: pointer;
		}
        .employe_list.active{            
            color: red;
        }
     </style>
</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">            	
		@include('header')		
		
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
			<a href="/employ/add">Create</a>
			</div>
		</div>
		<br/>
		<div class="row">	
			<div class="col-md-2">				
				<div class="col-md-9" style="padding-left:0px; padding-right: 0px;">						
					<input type="text" name="find_name" placeholder="input nama" class="form-control">
				</div>				
				<div class="col-md-3">
					<input type="button" value="find" class="btn btn-find-employee">
				</div>
				
				<table class="table tbl-list-employ">
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
					</thead>
					<tbody class="body-list-employ">		
						@foreach ($employes as $key => $value)
							<tr class="employe_list" id="{{$value->id}}">
								<td>{{$value->nik}}</td>
								<td>{{$value->name}}</td>
							</tr>
						@endforeach						
					</tbody>
				</table>
			</div>
			<div class="col-md-10">				
				@include("working.detail")
			</div>
		</div>
	 </div>	    	
</div>
</body>
</html> 

<script>
	var arr_date = [];
	$(document).ready(function(){
		var currentYear = new Date().getFullYear();
	    $('.calendar').calendar({
			 clickDay: function(e) { 			 	
			 	onPost(e);
			 },
			customDayRenderer: function(element, date) {
				var dt = $.datepicker.formatDate('yy-mm-dd', date);				
				if(arr_date[dt]=="present"){								
					$(element).addClass('dategreen');			        
				}else if(arr_date[dt]=="present_late"){								
					$(element).addClass('datered');			        
				}	            
	        },
	        disabledDays: [	        	
	            new Date(currentYear,1,2),
	            new Date(currentYear,1,3),
	            new Date(currentYear,1,8),
	            new Date(currentYear,1,9),
	            new Date(currentYear,1,10),
	            new Date(currentYear,1,11),
	            new Date(currentYear,1,13),
	            new Date(currentYear,1,14),
	            new Date(currentYear,1,15)
	        ]
		});

		$(".btn-find-employee").click(function(){
			var val = $("input[name='find_name']").val();
			$.get( domain + "/empermition/find?filter=" + val, function( result ) {								
				console.log(result);
				if (result.response.code == 200){	
					$(".body-list-employ").empty();
					$.each(result.data.employ, function( i, data ) {												
						var strHtmlToTable = setAllEmploy(i, data);													
						$('.tbl-list-employ > tbody:last-child').append(strHtmlToTable);	
					});
				}
			});
		});

		$(document).on("click",".employe_list", function(){
			$(".employe_list").removeClass("active");
			$(this).addClass("active");
			var val = $(this).attr("id");

			$.get( domain + "/working/detail/" + val, function( result ) {						
				if (result.response.code == 200){											
					arr_date = [];
					$.each(result.data.emp_working, function( i, data ) {
						arr_date[data.date] = data.type;	    		
					});					
					console.log(arr_date);
				}
			});
		})
	})

	
	function onPost(e){
		if ($("input[name='type']").is(':checked')) {			 		
			var valchk = $('input[name=type]:checked').val();
			var dt = $.datepicker.formatDate('yy-mm-dd', e.date);
			var data_post = 
				{ 
					_token : "{{ csrf_token() }}",				
					date    : dt,					
				  	type 	 : valchk};		
			
			$.post( "/working/create",data_post, function(result) {			
				console.log(result);
				console.log(arr_date);
				if (result.response.code==200){						 
					if (result.data.type=="present"){
						$(e.element).removeClass('datered');
						$(e.element).removeClass('dategreen');
						if (result.data.action=="delete"){							
						}else{
							$(e.element).addClass('dategreen');						
					    }
					}else{
						$(e.element).removeClass('datered');
						$(e.element).removeClass('dategreen');
						if (result.data.action=="delete"){							
						}else{							
							$(e.element).addClass('datered');							
						}						
					}
				}else{
					alert(result.response.message);
				}
			});				
		}else{
			alert("Pilih type absent")
		}

	}

</script>
