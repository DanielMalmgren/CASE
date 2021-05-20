<html>
<head></head>
<body>
@if($lesson != 'null')
    <p>@lang('Avser lektion:') {{$lesson}}</p>
@endif
<p>{{$content}}</p>
<hr>
<p>@lang('Detta meddelande har skickats via feedback-funktionen i CASE lärplattform. Nedan följer information om den som skickat')<p>
<p>@lang('Namn'): {{$name}}</p>
<p>@lang('E-post'): {{$email}}</p>
<p>@lang('Land'): {{$country}}</p>
@if($contacted)
    @lang('Personen önskar bli kontaktad gällande detta!')
@endif
</body>
</html>
