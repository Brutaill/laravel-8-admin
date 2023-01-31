@props([
    'links' => null,
])
<div class="max-w-full pt-6">
    <div class="flex flex-col">
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden w-full">
            {{ $slot }}
            </div>
        </div>            
    </div> 
    <div class="py-4 px-4">
        {{ $links }} 
    </div>       
</div>
</div>