@extends('components.layoutDash')

@section('dash')
<div class="p-4 sm:p-6 bg-[#caf0f8] min-h-screen">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-4 sm:p-6 bg-gradient-to-r from-[#03045e] to-[#0077b6]">
            <h1 class="text-xl sm:text-2xl font-bold text-white">Customer List</h1>
        </div>

        <div class="p-4 sm:p-6">
            <div class="mb-4 flex flex-col sm:flex-row justify-between items-center">
                <div class="relative w-full sm:w-auto mb-2 sm:mb-0">
                    <input type="text" placeholder="Search customers..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00b4d8] w-full">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button class="bg-[#00b4d8] text-white px-4 py-2 rounded-lg hover:bg-[#0077b6] transition duration-300 flex items-center">
                    <i class="ri-add-line mr-2"></i> Add Customer
                </button>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->username }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->location }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->phone }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                <button class="text-[#0077b6] hover:text-[#00b4d8] mr-3 transition duration-300">
                                    <i class="ri-edit-line"></i> Edit
                                </button>
                                <button class="text-red-600 hover:text-red-800 transition duration-300">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-center">
                <!-- Pagination component here -->
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <i class="ri-arrow-left-s-line"></i>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    // Additional JavaScript can be added here
</script>
@endsection
