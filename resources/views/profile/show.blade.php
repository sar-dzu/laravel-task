<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zobrazenie dát</title>
</head>
<body>

<p><strong>Meno:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Vek:</strong> {{ $data['age'] }}</p>
<p><strong>Rola:</strong> {{ $additional_data['roleLabel'] }}</p>

<p>
    <strong>Plnoletosť:</strong>
    @if ($additional_data['isAdult'])
        plnoletý/á
    @else
        neplnoletý/á
    @endif
</p>

<p>
    <strong>Zručnosti ({{ $additional_data['skillsCount'] }}):</strong>
</p>

@if (count($data['skills']) === 0)
    <p>Žiadne zručnosti neboli zadané.</p>
@else
    <ul>
        @foreach ($data['skills'] as $skill)
            <li>{{ $skill }}</li>
        @endforeach
    </ul>
@endif

<p>
    <a href="/profile/create">Späť na formulár</a>
</p>

</body>
</html>
