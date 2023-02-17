@props([
    'model' => null,
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
            <td class="py-3 px-4 text-sm font-medium text-gray-900 dark:text-white">
                @if(is_array($row))
                    @foreach ($row as $i => $item)
                        @if($i < 1)
                            <div class="font-semibold">{{ $item }}</div>
                        @else
                            <span class="text-sm">{{ $item }}</span>
                        @endif
                    @endforeach
                @else
                {{ $row }}
                @endif
            </td>
        @endforeach        
    @endif
    <td class="py-3 px-4 text-sm font-medium text-right lg:whitespace-nowrap">
        @if($options ?? false)
            <div class="flex-row gap-1/5">
            
            @can('view', $model)
                @if($options['show'] ?? false)
                <x-anchor class="px-2 py-1" href="{{ $options['show'] }}">{{ __('show') }}</x-anchor>
                @endif
            @endcan

            @can('update', $model)
                @if($options['edit'] ?? false)
                <x-anchor class="px-2 py-1" href="{{ $options['edit'] }}">{{ __('edit') }}</x-anchor>
                @endif
            @endcan

            @can('restore', $model)
                @if($options['restore'] ?? false)
                <form class="inline-flex" action="{{ $options['restore'] }}" method="POST" onsubmit="return confirm('{{ __('Are you sure to restore') }}?')">
                    @csrf
                    @method('PUT')
                    <x-button flag="warning" class="px-2 py-1">{{ __('restore') }}</x-button>
                </form>
                @endif
            @endcan

            @can('delete', $model)
                @if($options['delete'] ?? false)
                    <form class="inline-flex" action="{{ $options['delete'] }}" method="POST" onsubmit="return confirm('{{ __('Are you sure to delete') }}?')">
                        @csrf
                        @method('DELETE')
                        <x-button flag="danger" class="px-2 py-1">{{ __('delete') }}</x-button>
                    </form>
                @endif
            @endcan         

            </div>        
        @endif

        {{ $slot }}
    </td>
</tr>