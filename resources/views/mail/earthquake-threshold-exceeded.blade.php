<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Earthquake events</title>
</head>
<body>
    <h1>Hi {{ $user->name }}</h1>
    <h2>Please check out list of recent earthquakes that have magnitude larger than your set treeshold {{ $user->config->magnitude_threshold }}</h2>
    <table>
        <tr style="margin: 25px">
            <th>Magnitude</th>
            <th>Location</th>
            <th>Time</th>
            <th>Url</th>
        </tr>
        @foreach ($earthquakes as $earthquake)
            <tr>
                <td>{{ $earthquake->magnitude }}</td>
                <td>{{ $earthquake->place }}</td>
                <td>{{ $earthquake->time->format('Y-m-d H:i:s') }}</td>
                <td>{{ $earthquake->url }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
