<!DOCTYPE html>
<html>
<head>
    <title>Task Assigned</title>
</head>
<body>
<h1>Task Assigned to You</h1>
<p>Hello,</p>
<p>You have been assigned a new task: {{ $task->title }}</p>
<p>Description: {{ $task->description }}</p>
<p>Due Date: {{ $task->due_date }}</p>
<p>Best Regards,</p>
<p>Your Team</p>
</body>
</html>