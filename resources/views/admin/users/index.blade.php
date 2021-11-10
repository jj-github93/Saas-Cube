<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Users')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="table w-full table-zebra">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th class="flex justify-between">
                                    <span class="pt-2">Action

                                    </span>
                                    @can('user-create')
                                        <a
                                            href="{{route('users.create')}}"
                                            class="btn btn-sm btn-tertiary tet-gray-50">
                                            Add User
                                        </a>
                                    @endcan
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @can('view-own-profile' && !'user-list')
                                <tr class="hover">
                                    <td>{{$users->id}}</td>
                                    <td>{{$users->name}}</td>
                                    <td>
                                        <span
                                            class="bg-green-400 text-green-900 text-sm font-medium mr-2 px-3 py-1 rounded-md">
                                            {{ $authUserRole }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{url('/admin/users/' . $users->id)}}"
                                           class="btn btn-sm btn-primary text-gray-50">Details</a>
                                        <a href="{{url('/admin/users/' . $users->id . '/edit')}}"
                                           class="btn btn-sm btn-secondary text-gray-50">Update</a>
                                    </td>
                                </tr>
                            @endcan
                            @can('user-list')
                                @foreach($users as $user)
                                    <?php $userRole = $user->roles()->pluck('name')->first() ?>
                                    <tr class="hover">
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>
                                        <span
                                            class="bg-green-400 text-green-900 text-sm font-medium mr-2 px-3 py-1 rounded-md">
                                            {{ $userRole }}
                                        </span>
                                        </td>
                                        <td>
                                            <a href="{{url('/admin/users/' . $user->id)}}"
                                               class="btn btn-sm btn-primary text-gray-50"
                                            >Details</a>
                                            @if($authUserRole == 'Admin' || $user->id == $authUser->id || ($authUserRole == 'Manager' && $userRole == 'Astronauta') )
                                                <a href="{{url('/admin/users/' . $user->id . '/edit')}}"
                                                   class="btn btn-sm btn-secondary text-gray-50"
                                                    {{$userRole == 'Admin' ? 'disabled' : ""}}
                                                >Update</a>
                                            @else
                                                <a href="{{url('/admin/users/' . $user->id . '/edit')}}"
                                                   class="btn btn-sm btn-secondary text-gray-50" disabled>Update</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">

                                    {{$users->onEachSide(1)->links()}}
                                    @endcan
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

