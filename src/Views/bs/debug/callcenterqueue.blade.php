<html>
    <head>
        <title>Debug:CallCenterQueue</title>
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
        <h1>Debug Call Center Queue Events: </h1>
        <small>* latest 25 messages, showing latest first</small>
        <debugcallcenterqueue></debugcallcenterqueue>
    </div>
    </body>
    <script src="/js/broadsoft.js"></script>
</html>