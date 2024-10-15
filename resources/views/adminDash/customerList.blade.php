@extends('components.layoutDash')

@section('dash')
<section class="py-12 bg-[#caf0f8]">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-xl">
        <h1 class="text-2xl font-bold mb-6 text-[#03045e]">Customer List</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-md">
                <thead>
                    <tr class="bg-[#0077b6] text-white">
                        <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                            Username
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                            Location
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                            Phone
                        </th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b border-[#90e0ef] hover:bg-[#e6f8fc] transition duration-300">
                            <td class="px-4 py-3 text-sm">
                                {{ $user->username }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $user->location }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $user->phone }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a href="#" class="text-[#0077b6] hover:underline">Edit</a>
                                {{-- <form action="{{ route('payments.destroy') }}" method="post" class="inline-block"> --}}
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
