<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BaseRepository Docs</title>
    <style>
    body {
        font-family: sans-serif;
        padding: 20px;
    }

    h1 {
        margin-bottom: 20px;
    }

    h2 {
        margin-top: 30px;
    }

    pre {
        background: #f4f4f4;
        padding: 10px;
        border-radius: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background: #eee;
    }
    </style>
</head>

<body>
    <h1>{{ $docs['title'] }}</h1>
    <p>{{ $docs['description'] }}</p>

    @foreach($docs['methods'] as $method => $info)
    <h2>{{ $method }}</h2>
    <p>{{ $info['description'] }}</p>

    @if(isset($info['params']))
    <h3>Parameters:</h3>
    <ul>
        @foreach($info['params'] as $param)
        <li>{{ $param }}</li>
        @endforeach
    </ul>
    @endif

    <h3>Examples:</h3>
    @if(isset($info['examples']) && is_array($info['examples']))
    @foreach($info['examples'] as $exampleTitle => $exampleCode)
    <h4>{{ ucfirst($exampleTitle) }}:</h4>
    <pre>{{ $exampleCode }}</pre>
    @endforeach
    @elseif(isset($info['example']))
    <pre>{{ $info['example'] }}</pre>
    @endif
    @endforeach

    <h2>Filters</h2>
    <h3>Formats:</h3>
    <ul>
        @foreach($docs['filters']['formats'] as $format => $example)
        <li><strong>{{ ucfirst($format) }}:</strong>
            <pre>{{ var_export($example, true) }}</pre>
        </li>
        @endforeach
    </ul>

    <h2>Joins</h2>
    <pre>{{ var_export($docs['joins']['example'], true) }}</pre>

    <h2>With</h2>
    <pre>{{ var_export($docs['with']['example'], true) }}</pre>

    <h2>Order By</h2>
    <pre>{{ var_export($docs['orderBy']['example'], true) }}</pre>
</body>

</html>