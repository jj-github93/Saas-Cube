<x-guest-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Users')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Index
                    <div class="overflow-x-auto">
                        <table class="table w-full table-zebra">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Last Logged In</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key=>$user)
                                <tr class="hover">
                                    <td class="small">{{$key+1}}</td>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td> - </td>
                                    <td>
                                        <a href="{{url('/admin/users/' . $user->id)}}" class="btn btn-sm btn-primary text-gray-50">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    {{$users->onEachSide(1)->links()}}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
