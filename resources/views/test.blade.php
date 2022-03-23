<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testbed</title>
</head>
<body>
    <div class="container my-5">
        <x-autocrud-input::select name="test" :source="[
            1 => 'Yes',
            2 => 'OK Sih',
            3 => 'Better',
        ]" />
    </div>

    {!! $struct->renderTable() !!}
    
    {!! Autocrud::assets() !!}
    {!! $struct->renderAsset() !!}

</body>
</html>