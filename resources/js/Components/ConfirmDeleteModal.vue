<template>
  <Teleport to="body">
    <transition 
      enter-active-class="transition-opacity ease-out duration-300" 
      enter-from-class="opacity-0" 
      enter-to-class="opacity-100" 
      leave-active-class="transition-opacity ease-in duration-200" 
      leave-from-class="opacity-100" 
      leave-to-class="opacity-0"
    >
      <div v-show="show" class="fixed inset-0 z-[80] bg-black/60 backdrop-blur-sm" @click="$emit('close')"></div>
    </transition>

    <transition 
      enter-active-class="transition ease-out duration-300 transform" 
      enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
      enter-to-class="opacity-100 translate-y-0 sm:scale-100" 
      leave-active-class="transition ease-in duration-200 transform" 
      leave-from-class="opacity-100 translate-y-0 sm:scale-100" 
      leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
      <div v-show="show" class="fixed inset-0 z-[90] flex items-center justify-center p-4 sm:p-6 pointer-events-none">
        
        <div class="pointer-events-auto w-full max-w-md bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-800">
          
          <div class="p-6 sm:p-8">
            <div class="flex items-start">
              
              <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              
              <div class="ml-4 sm:ml-5 flex-1">
                <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white">
                  {{ title }}
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ message }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-t border-gray-100 dark:border-gray-800 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
            <button 
              type="button" 
              @click="$emit('close')"
              :disabled="processing"
              class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 disabled:opacity-50 transition-colors"
            >
              Cancel
            </button>
            <button 
              type="button" 
              @click="$emit('confirm')"
              :disabled="processing"
              class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 disabled:opacity-50 transition-colors flex items-center"
            >
              <svg v-if="processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ processing ? 'Deleting...' : 'Yes, Delete' }}
            </button>
          </div>

        </div>
      </div>
    </transition>
  </Teleport>
</template>

<script setup>
defineProps({
  show: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: 'Confirm Delete'
  },
  message: {
    type: String,
    default: 'Are you sure you want to delete this item? This action cannot be undone.'
  },
  processing: {
    type: Boolean,
    default: false
  }
});

defineEmits(['close', 'confirm']);
</script>