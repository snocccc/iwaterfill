@extends('components.layoutDash')

@section('dash')
<section class="p-4 md:p-8 bg-gray-100">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Customer List</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-md">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Username
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Location
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Phone
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-3 border-b border-gray-200 text-sm">
                                {{ $user->username }}
                            </td>
                            <td class="px-4 py-3 border-b border-gray-200 text-sm">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-3 border-b border-gray-200 text-sm">
                                {{ $user->location }}
                            </td>
                            <td class="px-4 py-3 border-b border-gray-200 text-sm">
                                {{ $user->phone }}
                            </td>
                            <td class="px-4 py-3 border-b border-gray-200 text-sm">
                                <a href="#" class="text-blue-500 hover:underline">Edit</a>
                                <form action="#" method="post" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
