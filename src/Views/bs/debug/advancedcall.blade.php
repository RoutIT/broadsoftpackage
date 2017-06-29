<html>
    <head>
        <title>Debug:AdvancedCall</title>
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
        <h1>Debug Advanced Call Event: </h1>
        <small>* latest 25 messages, showing latest first</small>
        <debugadvancedcall></debugadvancedcall>
    </div>
    </body>
    <script src="/js/broadsoft.js"></script>
</html>