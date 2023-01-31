@props([
    'data' => [],
    'options' => [],
])

<tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
    <td class="p-3 w-4">
        <div class="flex items-center">
            <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="checkbox-table-1" class="sr-only">checkbox</label>
        </div>
    </td>
    @if($data)
        @foreach($data as $row)
            <td class="py-3 px-4 text-sm font-medium text-gray-900 xl:whitespace-nowrap dark:text-white">{{ $row }}</td>
        @endforeach        
    @endif
    <td class="py-3 px-4 text-sm font-medium text-right lg:whitespace-nowrap">
        @if($options)
            <div class="flex-row gap-1/5">
            
            @if($options['show'])
            <x-anchor class="px-2 py-1" href="{{ $options['show'] }}">{{ __('show') }}</x-anchor>
            @endif

            @if($options['edit'])
            <x-anchor class="px-2 py-1" href="{{ $options['edit'] }}">{{ __('edit') }}</x-anchor>
            @endif

            @if($options['delete'])
                <form class="inline-flex" action="{{ $options['delete'] }}" method="POST" onsubmit="return confirm('{{ __('Are you sure to delete ') . ($options['delete-name'] ?? 'item') }}?')">
                    @csrf
                    @method('DELETE')
                    <x-button class="px-2 py-1">{{ __('delete') }}</x-button>
                </form>
            @endif

            </div>        
        @endif
    </td>
</tr>