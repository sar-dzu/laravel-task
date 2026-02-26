<!DOCTYPE html>
<html>
<head>
    <title>Result</title>
</head>
<body>

<h1>Postupnosť</h1>

<ul>
    @foreach($sequence as $value)
        <li>{{ $value }}</li>
    @endforeach
</ul>

<a href="/example/create">Späť</a>

</body>
</html>
