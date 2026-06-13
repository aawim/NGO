<template>
  <header class="bg-ngo-blue text-white sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
          <a href="/" class="flex items-center gap-3 text-white">

            <img :src="logo" alt="Logo" class="w-12 h-12 object-contain" />

            <div class="flex flex-col items-start leading-tight">
              <span class="text-1xl font-bold tracking-wider">
                World Vision Alience
              </span>

              <p class="text-xs -mt-1 text-white/80">
                building a resilient community
              </p>
            </div>

          </a>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-6 lg:space-x-8 items-center">
          <a href="/" class="hover:text-ngo-orange transition duration-200">Home</a>
          <a href="/about" class="hover:text-ngo-orange transition duration-200">About Us</a>
          <a href="/projects" class="hover:text-ngo-orange transition duration-200">Projects</a>
          <a href="/causes" class="hover:text-ngo-orange transition duration-200">Our Causes</a>
          <a href="/events" class="hover:text-ngo-orange transition duration-200">Events</a>
          <a href="/blog" class="hover:text-ngo-orange transition duration-200">Blog</a>

          <!-- Auth Links (Desktop) -->
          <div class="flex items-center space-x-4 border-l border-gray-600 pl-4 ml-4">

            <template v-if="$page.props.auth.user">

              <!-- Admin only -->
              <a v-if="$page.props.auth.user.role === 'admin'" href="/admin/dashboard"
                class="text-sm font-medium hover:text-ngo-orange transition duration-200">
                Admin Panel
              </a>

              <!-- Everyone logged in -->
              <a href="/logout" @click.prevent="logout"
                class="text-sm font-medium text-gray-300 hover:text-white transition duration-200 cursor-pointer">
                Logout
              </a>

            </template>

            <!-- Guest -->
            <template v-else>
              <a href="/login" class="text-sm font-medium hover:text-ngo-orange transition duration-200">
                Login
              </a>
            </template>

          </div>

          <!-- CTA Button -->
          <a href="/donate"
            class="bg-ngo-orange hover:bg-orange-600 text-white px-6 py-2 rounded-full font-semibold shadow-lg transition duration-300 transform hover:-translate-y-0.5">
            Donate Now
          </a>
        </nav>

        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center">
          <button @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="text-gray-300 hover:text-white focus:outline-none">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path v-if="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div v-show="isMobileMenuOpen" class="md:hidden bg-ngo-blue border-t border-gray-700">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="/" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 text-white">Home</a>
        <a href="/about" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 text-white">About
          Us</a>
        <a href="/causes"
          class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 text-white">Causes</a>

        <!-- Auth Links (Mobile) -->
        <div class="border-t border-gray-700 mt-2 pt-2">
          <template v-if="user">
            <a href="/admin/dashboard"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 text-white">Dashboard</a>
            <a href="/logout" @click.prevent="logout"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 cursor-pointer">Logout</a>
          </template>
          <template v-else>
            <a href="/login"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 text-white">Login</a>
          </template>
        </div>

        <a href="/donate"
          class="block px-3 py-2 mt-4 text-center rounded-md text-base font-medium bg-ngo-orange text-white">Donate
          Now</a>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import logo from '../../images/WVA.png'

const isMobileMenuOpen = ref(false);
const page = usePage();
const user = computed(() => page.props.auth?.user);

const logout = () => {
  router.post('/logout');
};
</script>