<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testbed</title>
</head>
<body>
    <a href="{{ url('form') }}">Go to Insert Form Example</a>
    {!! $struct->render() !!}
    
    {!! Autocrud::assets() !!}
    {!! $struct->renderAsset() !!}

</body>
</html>