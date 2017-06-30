<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet"></link>
    </head>
    <body>
        <div id="app">
            <div id="wrapper">
                 <div class="col-md-12">      
                    <div id="row">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a href="{{ url('bs/debug') }}"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> bs/debug/index</a>
                                    @foreach($routes as $route)
                                        @foreach(array_pluck($route, 'prefix') as $prefix)
                                            @if($prefix == "bs/debug")
                                                <li>
                                                    
                                                    <a href="{{ url($route->uri) }}"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> {{{ $route->uri }}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="col-md-12">      
                        <div id="row">
                            <h1>Debug Index</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>