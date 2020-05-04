<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Document</title>
</head>
    <body>
        <hr>
       
            @foreach ($cats as $value)
                <h3 class="text-center">{{$value}}</h3>
            @endforeach

            <div >
                <p class="text-center">Total website visits: {{$total}}</p>
                <p class="text-center">Page {{$page}} visits: {{$pageStats}}</p>
            </div>
        <hr>
    </body>
</html>