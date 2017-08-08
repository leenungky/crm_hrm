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
		<div class="load-tree">						
		</div>
	 </div>	    	
</div>

@include('footer')			
</body>
</html>

<script type="text/javascript">	
	

	 $.contextMenu({
            selector: '.right-click', 
            callback: function(key, options) {
                var m = "clicked: " + key;
                $(".modal-title").text(key + " Department " + $(this).text());
                if (key=="add"){	
					$(".modal-body").load(base_url + "/department/new?id=" + $(this).attr("id"));
					$('#myModal').modal('show'); 
				}else  if (key=="edit"){	
					$(".modal-body").load(base_url + "/department/edit/" + $(this).attr("id"));
					$('#myModal').\('show'); 
				}				
				else  if (key=="delete"){	
					var conf = confirm('Are you sure?');
					if (conf){
                        var url = base_url + "/department/delete/" + $(this).attr("id");                                    
						$.get(url);
						location.reload();
					}
				}				
            },
            items: {
            	"add": {name: "Add", icon: "add"},
                "edit": {name: "Edit", icon: "edit"},                
                "delete": {name: "Delete", icon: "delete"},
                "sep1": "---------",
                "quit": {name: "Quit", icon: function(){
                    return 'context-menu-icon context-menu-icon-quit';
                }}
            }
        });

       
</script>
