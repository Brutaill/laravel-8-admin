@props([
    'cols' ?? []
])

<table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
    <thead class="bg-gray-300 dark:bg-gray-700">
        <tr class="dark:bg-gray-700">
            
            <th scope="col" class="p-3">
                <div class="flex items-center">
                    <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-all" class="sr-only">checkbox</label>
                </div>
            </th>

            @foreach($cols as $col)
                <th scope="col" class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">{{ $col }}</th>
            @endforeach
            <th scope="col" class="p-4 px-4">...</th>            
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
    {{ $slot }}
    </tbody>
</table>