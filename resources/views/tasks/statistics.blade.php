<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                        <h3>Top User Has   Tasks </h3>
                </div>

            </div>
        </div>
    </div>
    <div class="container p-6 bg-white border-b border-gray-200">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Tasks Count</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($statistics) && $statistics->count())
                @foreach($statistics as $key => $value)
                    <tr>
                        <td>{{ $value->assigned_to_id }}</td>
                        <td>{{ $value->name}}</td>
                        <td>{{ $value->task_counts}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</x-app-layout>

