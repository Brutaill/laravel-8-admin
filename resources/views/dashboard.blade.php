<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-card-table>
        <x-table :cols="['#', 'Message', 'Created_at', 'Read']">
            @foreach ($notifications as $i => $notification)
                <x-table-row 
                :model="$notification"
                :data="[
                    $i+$loop->iteration,
                    $notification->data['message'], 
                    $notification->created_at,                   
                    $notification->read_at,
                ]"
                >
                    <x-link href="{{ route('dashboard.update', $notification->id) }}">mark as read</x-link>
                </x-table-row>
            @endforeach            
        </x-table>
        <x-slot name="links">
            {{ $notifications->links() }}
        </x-slot>
    </x-card-table>
</x-app-layout>
