@props([
    'id' => 'chcks_multi',
    'values' => [],
    'checked' => [], 
    'grouped' => false,
])

@php
    
    $modules = [];
    $abillities = [];
    
    $class = 'w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600';

    if($grouped) {
        foreach ($values as $key => $value) {
            $a = explode('_', $value);        
            array_push($modules, $a[0]);
            if(count($a)>1) {
                array_shift($a);
                array_push($abillities, implode('_', $a));
            }
        }
    }

    $modules = array_unique($modules);
    $abillities = array_unique($abillities);

@endphp

@if($values)
<div class="overflow-y-auto h-[300px] lg:h-full">
    <div id="{{ $id }}" {{ $attributes->merge(['class' => 'p-2 grid grid-cols-1 gap-x-2']) }}>
    @foreach ($values as $key => $name)
        <label class="inline-flex gap-2 items-center">
            <input data-label="{{ $name }}" value="{{ $key }}" {{ $attributes->merge(['type' => 'checkbox', 'class' => $class]) }}
            {{ (in_array($name, $checked)) ? 'checked' : null }}>
            {{ $name }}
        </label>
    @endforeach
    </div>
</div>
<div class="border-t-2 border-gray-300">
    <div id="{{ $id }}_labels" class="p-2 inline-flex flex-wrap gap-x-4">
        
        @if(!in_array('all', $modules))
        <label class="inline-flex gap-2 items-center">
            <input type="checkbox" class="{{ $class }}" onchange="handleCheckboxes(this, 'all')">
            {{ __('All') }}
        </label>
        @endif
        
        @if(count($modules))
            @foreach ($modules as $modul)
                <label class="inline-flex gap-2 items-center">
                    <input type="checkbox" class="{{ $class }}" onchange="handleCheckboxes(this, '{{ $modul }}')">
                    {{ __(ucfirst($modul)) }}
                </label>   
            @endforeach
        @endif

        @if(count($abillities))
            @foreach ($abillities as $abillity)
                <label class="inline-flex gap-2 items-center">
                    <input type="checkbox" class="{{ $class }}" onchange="handleCheckboxes(this, '{{ $abillity }}')">
                    {{ __(ucfirst($abillity)) }}
                </label>   
            @endforeach
        @endif

    </div>
</div>
@else
    <div>No data</div>
@endif


@push('scripts')
<script>

let chcks = document.querySelectorAll('#{{ $id }} input');
let labels = document.querySelectorAll('#{{ $id }}_labels input');

function handleCheckboxes(e, label) { 
    chcks.forEach(ch => {
        if(label == 'all') {
            ch.checked = e.checked;
            labels.forEach(l => l.checked = e.checked);
        }        
        if(ch.dataset.label.includes(label)) {
            ch.checked = e.checked;
        }
    });
}

</script>    
@endpush