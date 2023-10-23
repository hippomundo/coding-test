<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="flex-1 flex flex-col py-6" id="kanban-content">
        <kanban-board></kanban-board>
    </div>
</x-app-layout>
