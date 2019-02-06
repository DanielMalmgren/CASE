<form method="post" name="question" action="{{action('WorkplaceController@store')}}" accept-charset="UTF-8">
    @csrf

    <input type="hidden" name="workplace_id" value="{{$workplace->id}}">

    <H2>Typ av arbetsplats</H2>
    <select class="custom-select d-block w-100" id="workplace_type" name="workplace_type" required="">
        @foreach($workplace_types as $workplace_type)
            <option value="{{$workplace_type->id}}" {{$workplace->workplace_type_id==$workplace_type->id?"selected":""}}>{{$workplace_type->name}}</option>
        @endforeach
    </select>

    <H2>Obligatoriska spår</H2>
    @if(count($tracks) > 0)
        @foreach($tracks as $track)
            <div class="checkbox">
                @if($workplace->tracks->contains('id', $track->id))
                    <label><input type="checkbox" name="tracks[]" value="{{$track->id}}" id="{{$track->id}}" checked>{{$track->translateOrDefault(App::getLocale())->name}}</label>
                @else
                    <label><input type="checkbox" name="tracks[]" value="{{$track->id}}" id="{{$track->id}}">{{$track->translateOrDefault(App::getLocale())->name}}</label>
                @endif
            </div>
        @endforeach
    @endif

    <br><br>

    <button class="btn btn-primary btn-lg btn-block" id="submit" name="submit" type="submit">@lang('Spara')</button>
</form>
