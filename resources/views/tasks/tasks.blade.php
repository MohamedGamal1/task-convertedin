<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <h3>All Tasks </h3>
                    <a class="ml-3" href="{{ route('create_task') }}" style="margin-left: 0.75rem;
    padding: 10px;
    background: #333;
    color: #fff;
    float: right;
}">
                        {{ __('Assign Task') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div class="container p-6 bg-white border-b border-gray-200">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Admin NAme</th>
                <th>Assigned To</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($tasks) && $tasks->count())
                @foreach($tasks as $key => $value)
                    <tr>
                        <td>{{ $value->title }}</td>
                        <td>{{ $value->description}}</td>
                        <td>{{ $value->admin_name}}</td>
                        <td>{{ $value->user_name}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
            @endif
            </tbody>
        </table>

        {!! $tasks->links() !!}
    </div>
</x-app-layout>

