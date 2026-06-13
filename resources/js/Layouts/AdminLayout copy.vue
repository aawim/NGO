<template>
  <div class="flex h-screen bg-gray-100 font-sans">
    
    <div v-if="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 bg-ngo-black bg-opacity-50 z-20 lg:hidden"></div>

    <aside :class="['fixed inset-y-0 left-0 bg-ngo-blue text-gray-300 w-64 transform transition-transform duration-300 z-30 lg:translate-x-0 lg:static lg:inset-0', isSidebarOpen ? 'translate-x-0' : '-translate-x-full']">
      <div class="flex items-center justify-center h-20 bg-gray-900 border-b border-gray-800">
        <span class="text-2xl font-bold text-white">NGO<span class="text-ngo-orange">Admin</span></span>
      </div>
      
      <nav class="mt-6 px-4 space-y-2">
        <a href="/admin/dashboard" class="flex items-center px-4 py-3 bg-gray-800 border-l-4 border-ngo-green text-white rounded-r-md">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
          Dashboard
        </a>
        <a href="/admin/donations" class="flex items-center px-4 py-3 hover:bg-gray-800 hover:text-white rounded-md transition">
          <svg class="w-5 h-5 mr-3 text-ngo-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          Donations
        </a>
        <a href="/admin/projects" class="flex items-center px-4 py-3 hover:bg-gray-800 hover:text-white rounded-md transition">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
          Projects & Causes
        </a>
            <a href="/admin/projects" class="flex items-center px-4 py-3 hover:bg-gray-800 hover:text-white rounded-md transition">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
          Projects & Causes
        </a>
      </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
      
      <header class="bg-white shadow-sm h-20 flex items-center justify-between px-6 z-10">
        <button @click="isSidebarOpen = true" class="lg:hidden text-gray-500 focus:outline-none">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <div class="hidden sm:block text-gray-500 font-medium">
          Admin / <span class="text-ngo-black">Dashboard</span>
        </div>

        <div class="flex items-center space-x-4">
          <span class="text-sm font-medium text-gray-700">Admin User</span>
          <div class="h-10 w-10 rounded-full bg-ngo-green text-white flex items-center justify-center font-bold">
            A
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
        <slot />
      </main>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
const isSidebarOpen = ref(false);
</script>