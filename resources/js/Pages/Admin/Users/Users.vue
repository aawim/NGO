<template>
    <Head title="Manage Users" />

    <AuthenticatedLayout>
        <div class="space-y-6">

            <!-- Header & Search -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">User Management</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage roles, statuses, and permissions for all registered accounts.</p>
                </div>
                
                <div class="relative w-full sm:max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input v-model="searchQuery" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-ngo-blue focus:border-ngo-blue sm:text-sm transition-colors"
                        placeholder="Search by name or email...">
                </div>
            </div>

            <!-- Main Data Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User Details</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="user in filteredUsers" :key="user.id" class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">

                                <!-- User Details -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 mr-3 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center font-bold text-lg shadow-sm">
                                            {{ user.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white flex items-center">
                                                {{ user.name }}
                                                <span v-if="user.id === $page.props.auth.user.id" class="ml-2 px-2 py-0.5 text-[10px] bg-blue-100 text-blue-800 rounded-full font-bold">YOU</span>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400"><a :href="`mailto:${user.email}`" class="hover:text-ngo-blue">{{ user.email }}</a></div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Joined: {{ formatDate(user.created_at) }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role Dropdown -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <select v-model="user.role" @change="updateRole(user.id, $event.target.value)"
                                        :disabled="user.id === $page.props.auth.user.id"
                                        :class="[
                                            'text-xs font-bold rounded-full px-3 py-1 border-0 cursor-pointer shadow-sm focus:ring-0 appearance-none text-center',
                                            user.role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' :
                                            user.role === 'volunteer' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' :
                                            'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                            user.id === $page.props.auth.user.id ? 'opacity-50 cursor-not-allowed' : ''
                                        ]">
                                        <option value="user">User</option>
                                        <option value="volunteer">Volunteer</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </td>

                                <!-- Status Dropdown -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <select v-model="user.status" @change="updateStatus(user.id, $event.target.value)"
                                        :disabled="user.id === $page.props.auth.user.id"
                                        :class="[
                                            'text-xs font-bold rounded-full px-3 py-1 border-0 cursor-pointer shadow-sm focus:ring-0 appearance-none text-center',
                                            user.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            user.id === $page.props.auth.user.id ? 'opacity-50 cursor-not-allowed' : ''
                                        ]">
                                        <option value="active">Active</option>
                                        <option value="suspended">Suspended</option>
                                    </select>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button 
                                        @click="confirmDelete(user.id)" 
                                        :disabled="user.id === $page.props.auth.user.id"
                                        :class="['text-gray-400 hover:text-red-500 transition-colors', user.id === $page.props.auth.user.id ? 'opacity-30 cursor-not-allowed' : '']" 
                                        title="Delete User"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="filteredUsers.length === 0">
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No users found matching your search.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <ConfirmDeleteModal 
                :show="isDeleteModalOpen" 
                title="Delete User Account"
                message="Are you sure you want to permanently delete this user? All their associated data will be removed. This action cannot be undone."
                :processing="isDeleting" 
                @close="isDeleteModalOpen = false" 
                @confirm="executeDelete" 
            />

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import ConfirmDeleteModal from '@/Components/ConfirmDeleteModal.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true,
        default: () => []
    }
});

// State
const searchQuery = ref('');
const isDeleteModalOpen = ref(false);
const userToDelete = ref(null);
const isDeleting = ref(false);

// Computed
const filteredUsers = computed(() => {
    if (!searchQuery.value) return props.users;

    const query = searchQuery.value.toLowerCase();
    return props.users.filter(u =>
        (u.name || '').toLowerCase().includes(query) ||
        (u.email || '').toLowerCase().includes(query)
    );
});

// Helpers
const formatDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
};

// Actions
const updateRole = (id, newRole) => {
    router.patch(`/admin/users/${id}/role`, { role: newRole }, {
        preserveScroll: true,
        onError: (errors) => {
            alert(errors.error || 'Failed to update role.');
            router.reload(); // Reload to reset the dropdown if it failed
        }
    });
};

const updateStatus = (id, newStatus) => {
    router.patch(`/admin/users/${id}/status`, { status: newStatus }, {
        preserveScroll: true,
        onError: (errors) => {
            alert(errors.error || 'Failed to update status.');
            router.reload();
        }
    });
};

// Deletion
const confirmDelete = (id) => {
    userToDelete.value = id;
    isDeleteModalOpen.value = true;
};

const executeDelete = () => {
    isDeleting.value = true;
    router.delete(`/admin/users/${userToDelete.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            isDeleteModalOpen.value = false;
            isDeleting.value = false;
            userToDelete.value = null;
        },
        onError: () => {
            isDeleting.value = false;
        }
    });
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    height: 6px;
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.5);
    border-radius: 10px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(75, 85, 99, 0.5);
}
select {
    text-align-last: center;
}
</style>