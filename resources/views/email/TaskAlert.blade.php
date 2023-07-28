<!DOCTYPE html>
<html>
<head>
    <title>ItsolutionStuff.com</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>
    <a href="http://127.0.0.1:8000/api/tasks/{{ $details['link'] }}">View the task!</a> 

    <p>Thank you</p>
</body>
</html>