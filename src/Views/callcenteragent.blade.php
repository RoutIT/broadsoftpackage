<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = {{env('PUSHER_APP_DEBUG') }};

    var pusher = new Pusher('{{env('PUSHER_APP_KEY') }}', {
      cluster: 'eu',
      encrypted: true
    });

    var channel = pusher.subscribe('CallCenterAgent');
    channel.bind('AgentState', function(data) {
        console.log(data);
      {{-- alert("bam daar ben ik dan"); --}}
    });
  </script>
</head>
<body>
<h1>Callcenteragents events test page:</h1>
  <div id='acdEvents'>
    <ol>
    </ol>
  </div>
</body>
</html>