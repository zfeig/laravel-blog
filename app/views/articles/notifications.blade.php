@if ($errors->any())
<div class="error">
    {{--<h2>{{ count($errors->all()) }} errors find!</h2>--}}
    <ul>
    @foreach ($errors->all() as $message)
      <li>{{ $message }}</li>
    @endforeach
    </ul>
  </div>
@endif