@props(['errors'])

@if ($errors->any())
<div class="text-red-600 mb-4 p-4 rouded">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif 