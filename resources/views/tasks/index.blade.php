<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto flex overflow-auto sm:px-6 lg:px-8">
            <div class="flex flex-grow overflow-auto shadow-lg">
                <div class="text-gray-900">
                    <div class="w-full mb-6">
                        <button class="bg-green-700 text-zinc-100 font-bold px-4 py-2 rounded-lg shadow-lg">Add Task</button>
                    </div>
                    <div class="flex overflow-x-auto space-x-4">
                        @foreach ($phases as $phase)
                        <div class="w-[300px] bg-sky-950 rounded-lg shadow-lg">
                            <div class="p-4">
                                <h2 class="text-lg text-zinc-100 font-black mb-3">{{ $phase['name'] }}</h2>
                                @foreach ($phase['tasks'] as $task)
                                    <div class="w-full bg-white text-gray-900 shadow-md rounded-lg p-3 pb-8 mb-4 relative">
                                        {{ $task['name'] }}<br>
                                        <div class="text-xs text-gray-500 absolute bottom-2 ">{{ $task->user->name }}</div>
                                        <img 
                                            class="w-10 h-10 shadow-lg rounded-full absolute bottom-0 right-0 -mr-2 -mb-2 border-2 border-white" 
                                            src="{{ $task->user->profile_picture_url }}" 
                                            alt="{{ $task->user->name }}" 
                                        />
                                    </div>
                                    
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
