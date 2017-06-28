<h2> This is the Broadsoft package test page.</h2>
If u can reach this page the package is installed successfully.

<h2> ToDo:</h2>
Make simplefied tests


<!DOCTYPE html>
<html>
  <head>
    <title>Talking with Pusher</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="content">
        <h1>Laravel 5 and Pusher is fun!</h1>
        <ul id="messages" class="list-group">
        </ul>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://js.pusher.com/3.1/pusher.min.js"></script>
    <script>
      //instantiate a Pusher object with our Credential's key
      var pusher = new Pusher('22084fe5cced0ffbeaf8', {
          cluster: 'eu',
          encrypted: true
      });

      //Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('CallCenterAgentChannel');

      //Bind a function to a Event (the full Laravel class)
      // channel.bind('App\\Events\\HelloPusherEvent', addMessage);
      channel.bind('jvleeuwen\\broadsoft\\events\\CallCenterAgentEvent', addMessage);

      function addMessage(data) {
        var listItem = $("<li class='list-group-item'></li>");
        listItem.html(data.message);
        $('#messages').prepend(listItem);
      }
    </script>
  </body>
</html>