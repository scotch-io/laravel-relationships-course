<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
</head>
<body>

    @foreach ($posts as $post)
        <h2>{{ $post->title }}</h2>
    @endforeach 
    
</body>
</html>