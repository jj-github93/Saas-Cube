<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('User Details')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <dl class="grid grid-cols-6 gaps-2">
                        <dt class="col-span-1 mb-2">ID</dt>
                        <dd class="col-span-5 mb-2">{{$user->id}}</dd>
                        <dt class="col-span-1 mb-2">Name</dt>
                        <dd class="col-span-5 mb-2">{{$user->name}}</dd>
                        <dt class="col-span-1 mb-2">Role</dt>
                        <dd class="col-span-5 mb-2">
                            <span class="bg-green-400 text-green-900 text-sm font-medium mr-2 px-3 py-1 rounded-md">
                                {{$userRole ?? 'No role set'}}
                            </span>
                        </dd>

                        <dt class="col-span-1 mb-2">Email</dt>
                        <dd class="col-span-5 mb-2">{{$user->email}}</dd>
                        <dt class="col-span-1 mb-2">Playlists</dt>
                        @if($user->playlist->count() != 0)

                            <dt class="col-span-5 mb-2">
                                <table class="table table-zebra">
                                    <thead>
                                    <tr>
                                        <th>Playlist Name</th>
                                        <th>Tracks</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->playlist as $playlist)
                                        <tr>
                                            <td>{{$playlist->name}}</td>
                                            <td>{{$playlist->tracks->count()}}</td>
                                            <td>
                                                @if($authUserRole == 'Admin' || $authUser->id == $user->id || $playlist->protected == 0)
                                                    <a href="{{route('playlists.show', ['playlist'=>$playlist])}}"
                                                       class="btn-primary p-2 rounded-md"
                                                    >View</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </dt>
                        @else
                            <dd class="col-span-5 mb-2">-</dd>

                        @endif
                        <dt class="col-span-1 mb-2">Added</dt>
                        <dd class="col-span-5 mb-2">{{$user->created_at}}</dd>
                        <dt class="col-span-1 mb-2">Last Logged In</dt>
                        <dd class="col-span-5 mb-2">{{ '-' }}</dd>
                        <dt class="col-span-1 mb-2">Actions</dt>
                        <dd class="col-span-5 mb-2">
                            <form
                                action="{{route('users.destroy',['user'=>$user])}}"
                                method="post">
                                @csrf
                                @method('delete')
                                <a href="{{route('users.edit',['user'=>$user->id])}}"
                                   class="btn btn-sm btn-primary text-gray-50"
                                    {{$userRole == 'Admin' ? 'disabled' : ""}}

                                    {{$user->id == $authUser->id || $authUserRole == 'Admin' || ($userRole == 'Astronaut' && $authUserRole == 'Manager') }}
                                >Update</a>
                                @if($authUserRole == 'Admin' || ($authUserRole == 'Manager' && $userRole == 'Astronaut'))
                                    <button class="btn btn-sm btn-secondary text-gray-50"
                                            {{$userRole == 'Admin' ? 'disabled' : ""}}

                                    >Delete
                                    </button>
                                @endif

                            </form>

                        </dd>
                    </dl>
                    <p class="pt-6">
                        <a href="{{url('/admin/users')}}" class="btn btn-sm btn-accent">
                            Back To Users
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
