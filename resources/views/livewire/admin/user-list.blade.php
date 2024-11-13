<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Users
        </h2>
    </x-slot>

    <x-slot name="title">
        Users
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="w-16 bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">ID</span>
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Name</span>
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Email</span>
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Session Time Left</span>
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">IP Address</span>
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Status</span>
                                    </th>
                                    <th class="bg-gray-50 px-6 py-3 text-left">
                                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Actions</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($users as $user)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if($editingUserId === $user->id)
                                                <input type="text" 
                                                    wire:model="editingUsername" 
                                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    wire:keydown.enter="saveUsername"
                                                    wire:keydown.escape="cancelEdit"
                                                >
                                            @else
                                                {{ $user->name }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $this->getSessionTimeLeft($user) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $user->ip_address ?? 'Not recorded' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if($this->isUserOnline($user))
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Online</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Offline</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 whitespace-no-wrap">
                                            @if($editingUserId === $user->id)
                                                <button wire:click="saveUsername"
                                                    class="mr-2 rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs uppercase text-white hover:bg-gray-700">
                                                    Save
                                                </button>
                                                <button wire:click="cancelEdit"
                                                    class="rounded-md border border-transparent bg-gray-200 px-4 py-2 text-xs uppercase text-gray-500 hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                            @else
                                                <button wire:click="editUser({{ $user->id }})"
                                                    class="mr-2 rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs uppercase text-white hover:bg-gray-700">
                                                    Edit
                                                </button>
                                                <button wire:click="delete({{ $user->id }})"
                                                    class="rounded-md border border-transparent bg-red-200 px-4 py-2 text-xs uppercase text-red-500 hover:bg-red-300 hover:text-red-700">
                                                    Delete
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center leading-5 text-gray-900 whitespace-no-wrap">
                                            No users were found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>