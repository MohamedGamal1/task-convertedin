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
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ route('store_task') }}">
                    @csrf

                    <!-- Name -->

                        <div class="form-group">
                            <label for="assigned_by_id">Admins</label>
                                <select class="block mt-1 w-full" name="assigned_by_id">
                                    @foreach($data['admins'] as  $admin)
                                        <option value="{{$admin->id}}">
                                            {{$admin->name}}
                                        </option>
                                    @endforeach
                                </select>

                        </div>
                        <div>
                            <label for="">Task Title</label>

                            <input id="title" class="block mt-1 w-full" type="text" name="title"
                                     required autofocus />
                        </div>
                        <div>
                            <label for="">Task Description</label>
                            <textarea name="description" class="block mt-1 w-full">

                            </textarea>

                        </div>

                        <div class="form-group">
                            <label for="assigned_to_id">Users</label>
                                <select class="block mt-1 w-full" name="assigned_to_id">
                                    @foreach($data['users'] as  $user)
                                        <option value="{{$user->id}}">
                                            {{$user->name}}
                                        </option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Assign Task') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
