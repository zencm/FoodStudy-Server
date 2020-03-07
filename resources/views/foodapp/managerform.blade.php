@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-data"></i> {{ __('voyager::generic.database') }}
       
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-md-2">
                                        <select name="type">
                                            <option value="food" {!! $type == 'food' ? 'selected' : '' !!}>Food</option>
                                            <option value="log" {!! $type == 'log' ? 'selected' : '' !!}>Log</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-daterange">
                                            <input type="date" class="form-control" name="from" value="{{$datefrom}}" />
                                            <input type="date" class="form-control" name="until" value="{{$dateuntil}}" />
                                        </div>
                                    </div>

                                    <div class="col-md-4 text-right" >
                                        <a href="/admin/foodapp/export?type={{$type}}&from={{$datefrom}}&until={{$dateuntil}}" download="FoodApp Export - {{$type}} - {{$datefrom}} - {{$dateuntil}}.csv" class="goexport btn btn-success btn-small"><span class="voyager-download"></span> export</a>
                                    </div>
                                </div>
                                
                            </form>
                        
                            
                        @if (!$logs || empty($logs))
                            
                            <div class="alert alert-warning">no logs for the selected date range</div>
                            
                            
                        @else
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            @foreach( $logs[0] as $k => $v )
                                                <th>{{$k}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $logs as $log )
                                            <tr>
                                                @foreach( $log as $k => $v )
                                                    <td>{{$v}}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
        


    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            
            $('.form-search').on('submit', function(){
                $('.goexport').css({opacity:.2});
            });


            $('.form-search input').on('change',function(){
                $('.form-search').submit();
            });
            $('.form-search select').on('change',function(){
                $('.form-search').submit();
            });
        });
    </script>
@stop
