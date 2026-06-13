<script setup>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

// Define the incoming props from the controller
const props = defineProps({
  stats: {
    type: Object,
    required: true,
    default: () => ({})
  }
});

const isDarkMode = ref(false);

const toggleTheme = () => {
  isDarkMode.value = !isDarkMode.value;
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  }
};

onMounted(() => {
  if (localStorage.getItem('theme') === 'dark' || 
     (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDarkMode.value = true;
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="flex h-screen bg-gray-50 dark:bg-[#121212] font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">
      <main class="flex-1 overflow-y-auto p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
          
          <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Here is a summary of your NGO's current activities and impact.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md">
              <div class="p-3 rounded-full bg-blue-50 dark:bg-blue-900/30 text-ngo-blue mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Projects</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.projects?.total || 0 }}</h3>
                <p class="text-xs font-medium text-green-500 mt-1">+{{ stats.projects?.new_this_month || 0 }} this month</p>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md">
              <div class="p-3 rounded-full bg-orange-50 dark:bg-orange-900/30 text-ngo-orange mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Causes</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.causes?.active || 0 }}</h3>
                <p class="text-xs font-medium text-gray-400 mt-1">Requiring immediate funding</p>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md">
              <div class="p-3 rounded-full bg-green-50 dark:bg-green-900/30 text-ngo-green mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Donations Raised</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ Number(stats.donations?.total_raised || 0).toLocaleString() }}</h3>
                <p class="text-xs font-medium text-green-500 mt-1">Across all initiatives</p>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md">
              <div class="p-3 rounded-full bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Volunteers</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.people?.total_volunteers || 0 }}</h3>
                <p class="text-xs font-medium text-ngo-orange mt-1">{{ stats.people?.pending_volunteers || 0 }} pending approvals</p>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md">
              <div class="p-3 rounded-full bg-red-50 dark:bg-red-900/30 text-red-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming Events</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.events?.upcoming || 0 }}</h3>
                <p class="text-xs font-medium text-gray-400 mt-1">Scheduled community gatherings</p>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md">
              <div class="p-3 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Published Articles</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.news?.published || 0 }}</h3>
                <p class="text-xs font-medium text-gray-400 mt-1">Live news and impact stories</p>
              </div>
            </div>

          </div>

          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
             <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
               <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Task Activity</h2>
             </div>
             <div class="p-6 text-center text-gray-500 dark:text-gray-400 py-12">
               <p>Your recent projects and donations will appear here.</p>
             </div>
          </div>

        </div>
      </main>
    </div>
  </AuthenticatedLayout>
</template>