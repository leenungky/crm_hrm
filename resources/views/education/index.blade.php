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
                            <li>{{$error}}</li>
                        @endforeach 
                    </ul>
                </div>
            </div>
            <br/>
        @endif 
        
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
            <form action="/price/list" method="get">
                <div class="col-md-2">
                    City<br/>
                    <input type="text" name="city" class="form-control" value="{{isset($filter["city"]) ? $filter["city"] : ""}}">
                </div>               
                <div class="col-md-2">
                    Kecamatan<br/>
                    <input type="text" name="kecamatan" class="form-control" value="{{isset($filter["kecamatan"]) ? $filter["kecamatan"] : ""}}">
                </div>               
                <div class="col-md-2">
                    <br/>
                    <input type="submit" value="find" class="btn">
                </div>
            </form>
        </div><br/>
        <div class="row">               
            <div class="col-md-12">
                <a href="/education/new">Create</a>
            </div>
        </div>
        <br/>
        <div class="row">   
            <div class="col-md-12">
                <table class="table">                   
                    <thead>
                        <th>Name</th>
                        <th>Description</th>                                              
                        <th>Action</th>
                    </thead>
                    <tbody>     
                        @foreach ($education as $key => $value)
                            <tr>
                                <td>{{$value->name}}</td>
                                <td>{{$value->description}}</td>                                
                                <td>
                                    <a href="/education/edit/{{$value->id}}">
                                        <span class="edit"> 
                                            <span class="glyphicon glyphicon-pencil"  rel="tooltip" title="delete"></span>
                                        </span>
                                    </a> | 
                                    <a href="/education/delete/{{$value->id}}" class="confirmation">
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
            <?php 
                if (isset($filter)){
                    $education->appends($filter);
                }
            ?>
            {!! $education->render() !!}
            </div>
        </div>
     </div>         
</div>


</body>
</html>