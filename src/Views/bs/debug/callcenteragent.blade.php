<html>
    <head>
        <title>Debug:CallCenterAgent</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            pre {
                background-color: ghostwhite;
                border: 1px solid silver;
                padding: 10px 20px;
                margin: 20px; 
                }
        </style>
    </head>
    <body>
    <div id='bs'>
        <h1>Debug Call Center Agent Event: </h1>
        <small>* latest 25 messages, showing latest first</small>
        <debugcallcenteragent></debugcallcenteragent>
    </div>
    </body>
    <script src="/js/broadsoft.js"></script>
</html>