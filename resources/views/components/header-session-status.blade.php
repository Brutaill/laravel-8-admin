
@if(session('success'))
<div {{ $attributes->merge(['class' => 'bg-green-800 float-right text-sm px-3 py-1 mb-2 rounded text-white']) }}
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 3000)"
    >
    Success: {{ session('success') }}
</div>
@endif

@if(session('warning'))
<div {{ $attributes->merge(['class' => 'bg-orange-600 float-right text-sm px-3 py-1 mb-2 rounded text-white']) }}
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 3000)"
    >
    Warning: {{ session('warning') }}
</div>
@endif

@if(session('danger'))
<div {{ $attributes->merge(['class' => 'bg-red-800 float-right text-sm px-3 py-1 mb-2 rounded text-white']) }}
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 3000)"
    >
    Error: {{ session('danger') }}
</div>
@endif