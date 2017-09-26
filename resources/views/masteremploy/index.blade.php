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
				@include("masteremploy.detail")
			</div>
		</div>
	 </div>	    	
</div>
</body>
</html> 

<script>
	$(document).ready(function(){
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


			$.get( domain + "/masteremploy/detail/" + val, function( result ) {				
				console.log(result);
				if (result.response.code == 200){
						if (result.data.columns.length >  0){						
							var strhtml = "";
							$(".cls-form").empty();
							strhtml = strhtml +  "<form action='/masteremploy/update/" + result.data.id + "' method='post'>";
							strhtml = strhtml +  '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
							$.each(result.data.columns, function( i, column) {
								strhtml = strhtml + setMaster(i, column, result.data.master);
							});
							strhtml = strhtml + "<input type='submit' class='btn btn-primary' value='send'/>";
							strhtml = strhtml + "</form>";
							$(".cls-form").append(strhtml);
						}		
						if (result.data.master_employe != null){
							alert('a');
						}
					// setEmployee(result.data.employ);
				}
			});
		})
	})

	
	
	function setMaster(i, pdata, pmaster){
		var data = '<div class="form-group">';
			data =  data + '<label for="email">' + pdata + ' *</label>';
			data =  data + '<input type="text" class="form-control" id="' + pdata + '" name="' + pdata + '" value="' + pmaster[pdata] + '">';
			data =  data + '</div>';
			return data;			
	}

</script>
