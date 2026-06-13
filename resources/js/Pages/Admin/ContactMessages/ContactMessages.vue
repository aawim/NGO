<template>
    <Head title="Inbox & Messages" />

    <AuthenticatedLayout>
        <div class="space-y-6">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="relative w-full sm:max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input v-model="searchQuery" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-ngo-blue focus:border-ngo-blue sm:text-sm transition-colors"
                        placeholder="Search by name, email, or request type...">
                </div>

                <div class="flex space-x-2">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400 border border-orange-200 dark:border-orange-800">
                        {{ unreadCount }} New
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Sender</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Request Type & Preview</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="msg in filteredMessages" :key="msg.id" :class="[
                                'transition-colors hover:bg-gray-50 dark:hover:bg-gray-700',
                                msg.status === 'new' ? 'bg-blue-50/50 dark:bg-blue-900/10 font-semibold' : 'even:bg-gray-50 dark:even:bg-gray-800/50'
                            ]">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 flex-shrink-0 mr-3 rounded-full bg-ngo-blue text-white flex items-center justify-center font-bold text-lg shadow-sm">
                                            {{ msg.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-900 dark:text-white flex items-center">
                                                {{ msg.name }}
                                                <svg v-if="msg.user_id" class="w-4 h-4 ml-1.5 text-blue-500"
                                                    fill="currentColor" viewBox="0 0 20 20" title="Registered User">
                                                    <path fill-rule="evenodd"
                                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400"><a
                                                    :href="`mailto:${msg.email}`" class="hover:text-ngo-blue">{{
                                                    msg.email }}</a></div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{
                                                formatDate(msg.created_at) }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 cursor-pointer" @click="openMessage(msg)">
                                    <div class="text-xs font-bold text-ngo-orange uppercase tracking-wider mb-1">{{
                                        msg.request_type }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 truncate max-w-xs xl:max-w-md">
                                        {{ msg.message }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <select v-model="msg.status" @change="updateStatus(msg.id, $event.target.value)"
                                        :class="[
                                            'text-xs font-bold rounded-full px-3 py-1 border-0 cursor-pointer shadow-sm focus:ring-0 appearance-none text-center',
                                            msg.status === 'new' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' :
                                                msg.status === 'read' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' :
                                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                        ]">
                                        <option value="new">New</option>
                                        <option value="read">Read</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button @click="openMessage(msg)"
                                            class="text-gray-400 hover:text-ngo-blue transition-colors"
                                            title="Read Message">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button @click="confirmDelete(msg.id)"
                                            class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="filteredMessages.length === 0">
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Inbox is empty. No messages found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <Teleport to="body">
                <transition enter-active-class="transition-opacity ease-out duration-300" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="transition-opacity ease-in duration-200"
                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <div v-show="isModalOpen" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm"
                        @click="closeModal"></div>
                </transition>

                <transition enter-active-class="transition ease-out duration-300 transform"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="transition ease-in duration-200 transform"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="isModalOpen"
                        class="fixed inset-0 z-[70] z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
                        
                        <div v-if="selectedMessage"
                            class="pointer-events-auto w-full max-w-2xl bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

                            <div
                                class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50 shrink-0">
                                <div class="flex items-center">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mr-3">Message Details
                                    </h3>
                                    <span
                                        class="px-2 py-0.5 text-xs font-bold uppercase tracking-wider rounded border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300">{{
                                        selectedMessage.request_type }}</span>
                                </div>
                                <button @click="closeModal"
                                    class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-1">

                                <div
                                    class="flex items-start justify-between mb-6 pb-6 border-b border-gray-100 dark:border-gray-800">
                                    <div class="flex items-center">
                                        <div
                                            class="h-12 w-12 rounded-full bg-ngo-blue text-white flex items-center justify-center font-bold text-xl mr-4 shadow-sm">
                                            {{ selectedMessage.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{
                                                selectedMessage.name }}</h4>
                                            <p class="text-sm text-ngo-blue font-medium"><a
                                                    :href="`mailto:${selectedMessage.email}`" class="hover:underline">{{
                                                    selectedMessage.email }}</a></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                                                v-if="selectedMessage.phone">Phone: {{ selectedMessage.phone }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{
                                            formatFullDate(selectedMessage.created_at) }}</p>
                                        <div v-if="selectedMessage.user_id"
                                            class="mt-2 inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Registered User
                                        </div>
                                    </div>
                                </div>

                                <div class="prose dark:prose-invert max-w-none mb-8">
                                    <p
                                        class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed text-sm md:text-base bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                                        {{ selectedMessage.message }}</p>
                                </div>

                                <div v-if="selectedMessage.replies && selectedMessage.replies.length > 0" class="mt-6 space-y-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Conversation History</h4>
                                    
                                    <div v-for="reply in selectedMessage.replies" :key="reply.id" class="flex items-start ml-4 sm:ml-12">
                                        
                                        <div class="flex-shrink-0 mr-4 mt-1">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center font-bold text-xs shadow-sm">
                                                {{ reply.user?.name?.charAt(0)?.toUpperCase() || 'A' }}
                                            </div>
                                        </div>
                                        
                                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl rounded-tl-none p-4 flex-1 border border-blue-100 dark:border-blue-800/50">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-xs font-bold text-ngo-blue dark:text-blue-400">{{ reply.user?.name || 'Admin' }} <span class="font-normal text-gray-500">(Admin)</span></span>
                                                <span class="text-[10px] text-gray-500">{{ formatFullDate(reply.created_at) }}</span>
                                            </div>
                                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ reply.body }}</p>
                                        </div>

                                    </div>
                                </div>

                                <div v-if="isReplying" class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-ngo-blue" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                        </svg>
                                        Reply to {{ selectedMessage.name }}
                                    </h4>
                                    <textarea v-model="replyForm.reply_message" rows="5"
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-4 py-3 resize-none transition-colors"
                                        placeholder="Type your reply here. This will be sent directly to their email..."></textarea>
                                    <p v-if="replyForm.errors.reply_message" class="mt-1 text-xs text-red-500">{{
                                        replyForm.errors.reply_message }}</p>
                                </div>

                            </div>

                            <div
                                class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center shrink-0">

                                <button v-if="!isReplying" @click="isReplying = true"
                                    class="text-ngo-blue hover:text-blue-700 font-bold text-sm flex items-center transition-colors">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    Reply via Email
                                </button>
                                <div v-else></div> <div class="flex space-x-3">
                                    <button @click="closeModal"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition-colors">
                                        {{ isReplying ? 'Cancel' : 'Close' }}
                                    </button>

                                    <button v-if="!isReplying && selectedMessage.status !== 'resolved'"
                                        @click="markResolvedAndClose"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-500 hover:bg-green-600 rounded-md shadow-sm transition-colors flex items-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Mark as Resolved
                                    </button>

                                    <button v-if="isReplying" @click="sendReply"
                                        :disabled="replyForm.processing || !replyForm.reply_message.trim()"
                                        class="px-4 py-2 text-sm font-medium text-white bg-ngo-blue hover:bg-blue-700 rounded-md shadow-sm transition-colors flex items-center disabled:opacity-50">
                                        <svg v-if="replyForm.processing"
                                            class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <svg v-else class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        {{ replyForm.processing ? 'Sending...' : 'Send Reply' }}
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                </transition>
            </Teleport>

            <ConfirmDeleteModal :show="isDeleteModalOpen" title="Delete Message"
                message="Are you sure you want to permanently delete this message? This action cannot be undone."
                :processing="isDeleting" @close="isDeleteModalOpen = false" @confirm="executeDelete" />

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import ConfirmDeleteModal from '@/Components/ConfirmDeleteModal.vue';

const props = defineProps({
    messages: {
        type: Array,
        required: true,
        default: () => []
    }
});

// State
const searchQuery = ref('');
const isModalOpen = ref(false);
const selectedMessage = ref(null);
const isReplying = ref(false);

const isDeleteModalOpen = ref(false);
const messageToDelete = ref(null);
const isDeleting = ref(false);

// Forms
const replyForm = useForm({
    reply_message: ''
});

// Computed
const filteredMessages = computed(() => {
    if (!searchQuery.value) return props.messages;

    const query = searchQuery.value.toLowerCase();
    return props.messages.filter(m =>
        (m.name || '').toLowerCase().includes(query) ||
        (m.email || '').toLowerCase().includes(query) ||
        (m.request_type || '').toLowerCase().includes(query)
    );
});

const unreadCount = computed(() => {
    return props.messages.filter(m => m.status === 'new').length;
});

// Helpers
const formatDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
};

const formatFullDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
};

// Actions
const updateStatus = (id, newStatus) => {
    router.patch(`/admin/messages/${id}/status`, { status: newStatus }, {
        preserveScroll: true,
    });
};

const openMessage = (msg) => {
    selectedMessage.value = msg;
    isModalOpen.value = true;
    isReplying.value = false;
    replyForm.reset();

    // UX Auto-Read Feature
    if (msg.status === 'new') {
        msg.status = 'read'; // Optimistic UI update
        updateStatus(msg.id, 'read'); // Send to server
    }
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => {
        selectedMessage.value = null;
        isReplying.value = false;
        replyForm.reset();
        replyForm.clearErrors();
    }, 300);
};

const markResolvedAndClose = () => {
    if (selectedMessage.value) {
        selectedMessage.value.status = 'resolved'; // Optimistic
        updateStatus(selectedMessage.value.id, 'resolved');
        closeModal();
    }
};

const sendReply = () => {
    replyForm.post(`/admin/messages/${selectedMessage.value.id}/reply`, {
        preserveScroll: true,
        onSuccess: () => {
            // Automatically mark resolved and close on success
            if (selectedMessage.value) selectedMessage.value.status = 'resolved';
            closeModal();
        }
    });
};

// Deletion
const confirmDelete = (id) => {
    messageToDelete.value = id;
    isDeleteModalOpen.value = true;
};

const executeDelete = () => {
    isDeleting.value = true;
    router.delete(`/admin/messages/${messageToDelete.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            isDeleteModalOpen.value = false;
            isDeleting.value = false;
            messageToDelete.value = null;
            if (isModalOpen.value) closeModal();
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

/* For the select dropdown in the table */
select {
    text-align-last: center;
}
</style>