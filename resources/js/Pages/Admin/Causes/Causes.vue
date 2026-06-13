<template>
  <Head title="Manage Causes" />

  <AuthenticatedLayout>
    <div class="space-y-6">
      
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="relative w-full sm:max-w-md">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <input 
            v-model="searchQuery"
            type="text" 
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-ngo-orange focus:border-ngo-orange sm:text-sm transition-colors"
            placeholder="Search causes..."
          >
        </div>

        <button 
          @click="openPanel('add')"
          class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-ngo-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-orange dark:focus:ring-offset-gray-900 transition-colors"
        >
          <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Add Cause
        </button>
      </div>

      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto custom-scrollbar">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900/50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cause Details</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Funding Goal</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Raised</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              <tr v-for="cause in filteredCauses" :key="cause.id" class="even:bg-gray-50 dark:even:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="h-10 w-10 flex-shrink-0 mr-3 rounded-md overflow-hidden bg-gray-100 dark:bg-gray-700">
                      <img v-if="cause.image" :src="`/storage/${cause.image}`" alt="" class="h-full w-full object-cover">
                      <svg v-else class="h-full w-full text-gray-300 dark:text-gray-500 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                      <div class="text-sm font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg v-if="cause.featured" class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        {{ cause.title }}
                      </div>
                      <div class="text-xs text-gray-500 dark:text-gray-400">{{ cause.slug }}</div>
                    </div>
                  </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                  ${{ Number(cause.goal_amount).toLocaleString() }}
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-ngo-green">${{ Number(cause.raised_amount).toLocaleString() }}</div>
                  <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-1 overflow-hidden">
                    <div class="bg-ngo-green h-1.5 rounded-full" :style="{ width: Math.min((cause.raised_amount / cause.goal_amount) * 100, 100) + '%' }"></div>
                  </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <span :class="[
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    cause.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                    cause.status === 'completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 
                    'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'
                  ]">
                    {{ cause.status.charAt(0).toUpperCase() + cause.status.slice(1) }}
                  </span>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end space-x-3">
                    <button @click="openDetail(cause)" class="text-gray-400 hover:text-ngo-blue transition-colors" title="View Details">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                    <button @click="openPanel('edit', cause)" class="text-gray-400 hover:text-ngo-orange transition-colors" title="Edit">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button @click="confirmDelete(cause.id)" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <Teleport to="body">
        <transition enter-active-class="transition-opacity ease-linear duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition-opacity ease-linear duration-300" leave-from-class="opacity-100" leave-to-class="opacity-0">
          <div v-show="isPanelOpen" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm" @click="closePanel"></div>
        </transition>

        <transition enter-active-class="transition ease-in-out duration-500 transform" enter-from-class="translate-x-full" enter-to-class="translate-x-0" leave-active-class="transition ease-in-out duration-500 transform" leave-from-class="translate-x-0" leave-to-class="translate-x-full">
          <div v-show="isPanelOpen" class="fixed inset-y-0 right-0 z-50 flex pointer-events-none pl-10">
            <div :class="['pointer-events-auto h-full bg-white dark:bg-[#1e1e1e] shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col overflow-y-scroll custom-scrollbar transition-[max-width] duration-300 ease-in-out', isPanelExpanded ? 'w-screen max-w-3xl' : 'w-screen max-w-md']">
              
              <div class="bg-ngo-orange px-4 py-6 sm:px-6 shadow-md z-10 shrink-0">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium text-white" id="slide-over-title">
                    {{ isEditing ? 'Edit Cause' : 'Add New Cause' }}
                  </h2>
                  <div class="ml-3 flex h-7 items-center space-x-3">
                    <button @click="isPanelExpanded = !isPanelExpanded" class="rounded-md text-orange-200 hover:text-white focus:outline-none transition-colors">
                      <span class="sr-only">Toggle width</span>
                      <svg v-if="!isPanelExpanded" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                      <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h6m0 0v6m0-6l-7 7m17-11h-6m0 0V4m0 6l7-7m-7 17l7-7M4 4l7 7"></path></svg>
                    </button>
                    <button @click="closePanel" class="rounded-md text-orange-200 hover:text-white focus:outline-none transition-colors">
                      <span class="sr-only">Close panel</span>
                      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="relative flex-1 px-4 py-6 sm:px-6">
                <form class="space-y-6">
                  
                  <div :class="[isPanelExpanded ? 'grid grid-cols-2 gap-4' : 'space-y-6']">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cause Title</label>
                      <input v-model="form.title" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-orange focus:ring-ngo-orange sm:text-sm px-3 py-2 border transition-colors">
                      <p v-if="form.errors.title" class="mt-1 text-xs text-red-500">{{ form.errors.title }}</p>
                    </div>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea v-model="form.description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-orange focus:ring-ngo-orange sm:text-sm px-3 py-2 border transition-colors"></textarea>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cause Image</label>
                    <input 
                      type="file" 
                      @input="form.image = $event.target.files[0]"
                      accept="image/*"
                      class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-ngo-orange file:text-white hover:file:bg-orange-600 transition-colors cursor-pointer"
                    >
                    <div v-if="form.progress" class="w-full bg-gray-200 rounded-full h-1.5 mt-2 dark:bg-gray-700">
                      <div class="bg-ngo-orange h-1.5 rounded-full" :style="{ width: form.progress.percentage + '%' }"></div>
                    </div>
                  </div>

                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Goal Amount ($)</label>
                      <input v-model="form.goal_amount" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-orange focus:ring-ngo-orange sm:text-sm px-3 py-2 border transition-colors">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Raised Amount ($)</label>
                      <input v-model="form.raised_amount" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-orange focus:ring-ngo-orange sm:text-sm px-3 py-2 border transition-colors">
                    </div>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select v-model="form.status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-orange focus:ring-ngo-orange sm:text-sm px-3 py-2 border transition-colors">
                      <option value="active">Active</option>
                      <option value="paused">Paused</option>
                      <option value="completed">Completed</option>
                    </select>
                  </div>

                  <div class="flex items-center mt-4">
                    <input v-model="form.featured" id="featured" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-ngo-orange focus:ring-ngo-orange transition-colors">
                    <label for="featured" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Feature this cause on homepage</label>
                  </div>
                </form>
              </div>

              <div class="shrink-0 border-t border-gray-200 dark:border-gray-800 px-4 py-4 sm:px-6 bg-gray-50 dark:bg-[#121212]">
                <div class="flex justify-end space-x-3">
                  <button @click="closePanel" type="button" class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                    Cancel
                  </button>
                  <button @click="submitForm" :disabled="form.processing" type="button" class="inline-flex justify-center rounded-md border border-transparent bg-ngo-orange px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-ngo-orange focus:ring-offset-2 dark:focus:ring-offset-gray-900 disabled:opacity-50 transition-colors">
                    {{ form.processing ? 'Saving...' : (isEditing ? 'Save Changes' : 'Create Cause') }}
                  </button>
                </div>
              </div>
              
            </div>
          </div>
        </transition>
      </Teleport>

      <Teleport to="body">
        <transition enter-active-class="transition-opacity ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition-opacity ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
          <div v-show="isDetailModalOpen" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm" @click="closeDetail"></div>
        </transition>

        <transition enter-active-class="transition ease-out duration-300 transform" enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="transition ease-in duration-200 transform" leave-from-class="opacity-100 translate-y-0 sm:scale-100" leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
          <div v-show="isDetailModalOpen" class="fixed inset-0 z-[70] z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
            <div v-if="selectedCause" class="pointer-events-auto w-full max-w-2xl bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
              
              <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
                <div class="flex items-center space-x-3">
                  <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ selectedCause.title }}</h3>
                  <span :class="[
                    'px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full',
                    selectedCause.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                    selectedCause.status === 'completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 
                    'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'
                  ]">
                    {{ selectedCause.status.charAt(0).toUpperCase() + selectedCause.status.slice(1) }}
                  </span>
                </div>
                <button @click="closeDetail" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none transition-colors">
                  <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>

              <div class="px-6 py-6 overflow-y-auto custom-scrollbar space-y-6">
                <div class="w-full h-56 bg-gray-100 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                  <img v-if="selectedCause.image" :src="`/storage/${selectedCause.image}`" alt="Cause Image" class="w-full h-full object-cover" />
                  <svg v-else class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>

                <div>
                  <div class="flex justify-between items-end mb-2">
                    <div>
                      <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Funding Progress</p>
                      <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ Number(selectedCause.raised_amount).toLocaleString() }} <span class="text-sm font-normal text-gray-500 dark:text-gray-400">raised of ${{ Number(selectedCause.goal_amount).toLocaleString() }}</span></p>
                    </div>
                    <span class="text-sm font-bold text-ngo-green">{{ fundingProgress }}%</span>
                  </div>
                  <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-ngo-green h-2.5 rounded-full transition-all duration-1000 ease-out" :style="{ width: fundingProgress + '%' }"></div>
                  </div>
                </div>

                <div>
                  <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-2">About this Cause</h4>
                  <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">
                    {{ selectedCause.description || 'No detailed description available.' }}
                  </p>
                </div>
              </div>

              <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 flex justify-end space-x-3">
                <button @click="closeDetail" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors">
                  Close
                </button>
                <button @click="closeDetail(); openPanel('edit', selectedCause)" class="px-4 py-2 text-sm font-medium text-white bg-ngo-orange hover:bg-orange-600 rounded-md shadow-sm transition-colors flex items-center">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                  Edit Cause
                </button>
              </div>

            </div>
          </div>
        </transition>
      </Teleport>

      <ConfirmDeleteModal 
        :show="isDeleteModalOpen"
        title="Delete Cause"
        message="Are you sure you want to delete this cause? All associated data and funding history will be permanently removed."
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
import { Head, useForm, router } from '@inertiajs/vue3';
import ConfirmDeleteModal from '@/Components/ConfirmDeleteModal.vue';

// --- Props from Laravel ---
const props = defineProps({
  causes: {
    type: [Array, Object], 
    required: true,
    default: () => []
  }
});

// --- State ---
const searchQuery = ref('');
const isPanelOpen = ref(false);
const isPanelExpanded = ref(false);
const isEditing = ref(false);

// --- Detail Modal State ---
const isDetailModalOpen = ref(false);
const selectedCause = ref(null);

// --- Delete Modal State ---
const isDeleteModalOpen = ref(false);
const causeToDelete = ref(null);
const isDeleting = ref(false);

// --- Inertia Form (Synced with Causes DB Schema) ---
const form = useForm({
  id: null,
  title: '',
  slug: '',
  description: '',
  goal_amount: 0.00,
  raised_amount: 0.00,
  image: null,
  featured: false,
  status: 'active'
});

// --- Computed ---
const filteredCauses = computed(() => {
  const causeArray = Array.isArray(props.causes) ? props.causes : (props.causes?.data || []);
  if (!searchQuery.value) return causeArray;
  
  const lowerCaseQuery = searchQuery.value.toLowerCase();
  return causeArray.filter(cause => 
    (cause?.title || '').toLowerCase().includes(lowerCaseQuery)
  );
});

const fundingProgress = computed(() => {
  if (!selectedCause.value || !selectedCause.value.goal_amount) return 0;
  const percent = (selectedCause.value.raised_amount / selectedCause.value.goal_amount) * 100;
  return percent > 100 ? 100 : Math.round(percent);
});

// --- Methods: Panel ---
const openPanel = (mode, causeData = null) => {
  if (mode === 'edit' && causeData) {
    isEditing.value = true;
    form.id = causeData.id;
    form.title = causeData.title;
    form.slug = causeData.slug;
    form.description = causeData.description;
    form.goal_amount = causeData.goal_amount;
    form.raised_amount = causeData.raised_amount;
    form.image = null; // Do not bind string path to file input
    form.featured = !!causeData.featured;
    form.status = causeData.status;
  } else {
    isEditing.value = false;
    form.reset(); 
  }
  isPanelOpen.value = true;
};

const closePanel = () => {
  isPanelOpen.value = false;
  setTimeout(() => {
    form.reset();
    form.clearErrors();
    isPanelExpanded.value = false;
  }, 300);
};

// --- Methods: Form Submission ---
const submitForm = () => {
  if (isEditing.value) {
    form.transform((data) => ({
      ...data,
      _method: 'put',
    })).post(`/admin/causes/${form.id}`, {
      preserveScroll: true,
      onSuccess: () => closePanel(),
    });
  } else {
    form.post('/admin/causes', {
      preserveScroll: true,
      onSuccess: () => closePanel(),
    });
  }
};

// --- Methods: Details ---
const openDetail = (cause) => {
  selectedCause.value = cause;
  isDetailModalOpen.value = true;
};

const closeDetail = () => {
  isDetailModalOpen.value = false;
  setTimeout(() => {
    selectedCause.value = null;
  }, 300);
};

// --- Methods: Deletion ---
const confirmDelete = (id) => {
  causeToDelete.value = id;
  isDeleteModalOpen.value = true;
};

const executeDelete = () => {
  isDeleting.value = true;
  router.delete(`/admin/causes/${causeToDelete.value}`, {
    preserveScroll: true,
    onSuccess: () => {
      isDeleteModalOpen.value = false;
      isDeleting.value = false;
      causeToDelete.value = null;
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
</style>