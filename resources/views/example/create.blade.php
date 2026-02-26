<!DOCTYPE html>
<html>
<head>
    <title>Create</title>
</head>
<body>

<h1>Zadaj číslo n</h1>

<form method="POST" action="/example/result">
    @csrf
    <input type="number" name="n" required>
    <button type="submit">Odoslať</button>
</form>

</body>
</html>
