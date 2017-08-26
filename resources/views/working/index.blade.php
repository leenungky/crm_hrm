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

			$.get( domain + "/empermition/detail1/" + val, function( result ) {				
				console.log(result);
				if (result.response.code == 200){	
					$(".body-permition-leave").empty();
					$.each(result.data.dbemploy_permition, function( i, data ) {
						setPermition(i, data);
					});
					setEmployee(result.data.employ);

				}
			});
		})
	})

	function setAllEmploy(i, data){
		var strHtmlToTable ='<tr class="employe_list" id="' + data.id + '">';
		strHtmlToTable  = strHtmlToTable  + '<td>' + data.nik + '</td>';
		strHtmlToTable  = strHtmlToTable  + '<td>' + data.name +'</td>';
		strHtmlToTable  = strHtmlToTable  + '</tr>';
		return strHtmlToTable;							
							
	}

	function setEmployee(employ){
		$("input[name='id']").val(employ.id);
		$("input[name='nik']").val(employ.nik);
		$("input[name='name_karyawan']").val(employ.name);
		$("input[name='birth_place']").val(employ.birth_place);
		$("input[name='birth_date']").val(employ.birth_date);
		$("input[name='phone']").val(employ.phone);
		$("textarea[name='address']").val(employ.name);
		$("input[name='email']").val(employ.email);		
		$("input[name='department']").val(employ.department_name);
		var sex = "";
		if (employ.sex="L"){
			sex = "Laki-Laki";
		}else{
			sex = "perempuan";
		}
		$("input[name='sex']").val(sex);
		$("input[name='job_title']").val(employ.jobtitle_name);
		$("input[name='branch']").val(employ.branch_name);
		$("input[name='nationality']").val(employ.nationality);
	}

	function setPermition(i, data){
		var strHtmlToTable = '<tr class="permition-leave_' + i + '">';	
		var strHtmlToTable = strHtmlToTable + onSetDbToTablePermition(i, data);	
		var strHtmlToTable = strHtmlToTable + '</tr>';		
		$('.tbl-permition-leave > tbody:last-child').append(strHtmlToTable);		
	}

	function onSetDbToTablePermition(rowCount, data){					
		var strHtmlToTable ='<td>'+ data.propose +'</td>';		
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.reason +'</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.dari +'</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.sampai +'</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.day +'</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.checked_nik +'-' + data.checked_name + '</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.checked_date +'</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.approved_nik +'-' + data.approved_name + '</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.approved_date +'</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td>'+ data.description +'</td>';
		strHtmlToTable = strHtmlToTable  + 	'<td><a href="javascript:void(0)">';
		strHtmlToTable = strHtmlToTable  + 	'<span class="p_edit" attr-id="'+ rowCount +'">';
		strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-pencil" rel="tooltip" title="edit"></span>';
		strHtmlToTable = strHtmlToTable  + 	'</span>';
		strHtmlToTable = strHtmlToTable  + 	'</a> | ';
		strHtmlToTable = strHtmlToTable  + 	'<a href="javascript:void(0)" class="confirmation"> ';
		strHtmlToTable = strHtmlToTable  + 	'<span class="p_delete" attr-id="'+ rowCount +'">';
		strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>';
		strHtmlToTable = strHtmlToTable  + 	'</span></a> </td>';
				
		return 	strHtmlToTable;		    				
							
	}

</script>
