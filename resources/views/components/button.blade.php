@props(['flag' => 'primary'])

@php
    
    switch ($flag) {
        case 'success':
            $class = ' bg-green-600 hover:bg-green-700 active:bg-green-900';
            break;        

        case 'info':
            $class = ' bg-blue-600 hover:bg-blue-700 active:bg-blue-900';
            break;        

        case 'warning':
            $class = ' bg-orange-600 hover:bg-orange-700 active:bg-orange-900';
            break;
        
        case 'danger':
            $class = ' bg-red-600 hover:bg-red-700 active:bg-red-900';
            break;
        
        default:
            $class = ' bg-gray-800 hover:bg-gray-700 active:bg-gray-900';
            break;
    }    
    
    
    $classes = 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150';


@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes . $class]) }}>
    {{ $slot }}
</button>
