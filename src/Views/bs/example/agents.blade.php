<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Example:Callcenter:{{$slug}}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet"></link>
        <style>
            .Sign-Out {
                text-decoration: line-through;
            }
            .Available {
                background-color: green;
                color: white;
            }
            .Unavailable{
                background-color: red;
                color: white;
            }
            .Sign-In{
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
                 <div class="col-md-6">      
                    <div id="row">
                    <h1>Agents example for slug: {{$slug}}</h1>

                    <div id='bs'>
                        <exampleagents agents="{{ json_encode($users) }}"></exampleagents>
                    </div>
                    
                </div>
            </div>
        </div>
        <script src="/js/broadsoft.js"></script>
    </body>
</html>