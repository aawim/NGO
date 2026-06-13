<template>
  <!-- Main wrapper with dynamic dark mode class -->
  <div :class="{'dark': isDarkMode}">
    <div class="flex h-screen bg-gray-100 dark:bg-ngo-black font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">
      
      <!-- Mobile Sidebar Overlay -->
      <div 
        v-if="isSidebarOpen" 
        @click="isSidebarOpen = false" 
        class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden backdrop-blur-sm transition-opacity"
      ></div>

      <!-- Sidebar -->
      <aside 
        :class="[
          'fixed inset-y-0 left-0 flex flex-col bg-ngo-blue text-gray-300 w-64 transform transition-transform duration-300 z-30 lg:translate-x-0 lg:static lg:inset-0', 
          isSidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'
        ]"
      >
        <!-- Logo Area -->
        <div class="flex items-center justify-center h-20 bg-black/20 border-b border-white/10 shrink-0">
          <span class="text-2xl font-extrabold tracking-wider text-white">
            NGO<span class="text-ngo-orange">Admin</span>
          </span>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto mt-4 px-3 space-y-1 custom-scrollbar pb-6">
          <!-- Dashboard Link -->
          <a href="/admin/dashboard" 
             class="flex items-center px-4 py-3 bg-white/10 border-l-4 border-ngo-green text-white rounded-r-lg shadow-sm mb-6 transition-all hover:bg-white/20">
            <svg class="w-5 h-5 mr-3 text-ngo-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="font-medium">Dashboard</span>
          </a>

          <!-- Manage Section Header -->
          <div class="px-4 pb-2 pt-4">
            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Manage</p>
          </div>

          <!-- Dynamic Navigation Links -->
          <a 
            v-for="item in manageLinks" 
            :key="item.name"
            :href="item.href" 
            class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all group"
          >
            <div v-html="item.icon" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-ngo-orange transition-colors"></div>
            {{ item.name }}
          </a>
        </nav>
      </aside>

      <!-- Main Content Area -->
      <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Header -->
        <header class="bg-white dark:bg-gray-900 shadow-sm dark:shadow-gray-800/50 h-20 flex items-center justify-between px-6 z-10 transition-colors duration-300">
          
          <!-- Mobile Menu Button & Breadcrumbs -->
          <div class="flex items-center">
            <button @click="isSidebarOpen = true" class="lg:hidden text-gray-500 hover:text-ngo-orange focus:outline-none mr-4 transition-colors">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>

            <div class="hidden sm:flex text-sm font-medium text-gray-500 dark:text-gray-400">
              Admin <span class="mx-2">/</span> <span class="text-ngo-blue dark:text-white">Dashboard</span>
            </div>
          </div>

          <!-- Header Right Actions -->
          <div class="flex items-center space-x-4">
            
            <!-- Dark Mode Toggle -->
            <button 
              @click="toggleTheme" 
              class="p-2 rounded-full text-gray-400 hover:text-ngo-orange hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none"
            >
              <svg v-if="!isDarkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
            </button>

            <!-- User Profile -->
            <div class="flex items-center pl-4 border-l border-gray-200 dark:border-gray-700">
              <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 mr-3 hidden md:block">Admin User</span>
              <div class="h-10 w-10 rounded-full bg-ngo-green text-white flex items-center justify-center font-bold shadow-md cursor-pointer hover:ring-2 hover:ring-ngo-orange hover:ring-offset-2 dark:hover:ring-offset-gray-900 transition-all">
                A
              </div>
            </div>
          </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-[#121212] transition-colors duration-300">
          <div class="max-w-7x7 mx-auto">
            <slot />
          </div>
        </main>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isSidebarOpen = ref(false);
const isDarkMode = ref(false);

// Toggle Dark Mode function
const toggleTheme = () => {
  isDarkMode.value = !isDarkMode.value;
  // Optional: Save preference to localStorage
  localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
};

// Check for saved theme preference on load
onMounted(() => {
  if (localStorage.getItem('theme') === 'dark' || 
     (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDarkMode.value = true;
  }
});

// Navigation Links Array (Heroicons used for SVGs)
const manageLinks = [
  { 
    name: 'Projects', 
    href: '/admin/projects', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>'
  },
  { 
    name: 'About', 
    href: '/admin/about', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' 
  },
  { 
    name: 'Causes', 
    href: '/admin/causes', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>' 
  },
  { 
    name: 'Events', 
    href: '/admin/events', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>' 
  },
   { 
    name: 'News & Story', 
    href: '/admin/news-stories', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>' 
  },
  { 
    name: 'Blogs', 
    href: '/admin/blogs', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>' 
  },
  { 
    name: 'Donations', 
    href: '/admin/donations', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' 
  },
  { 
    name: 'Contacts', 
    href: '/admin/contacts', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>' 
  },
  { 
    name: 'Users', 
    href: '/admin/users', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>' 
  },
  { 
    name: 'Volunteers', 
    href: '/admin/volunteers', 
    icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>' 
  }
];
</script>

<style scoped>
/* Optional styling to make the sidebar scrollbar sleek */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.2);
}
</style>