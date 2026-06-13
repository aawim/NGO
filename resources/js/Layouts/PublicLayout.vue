<template>
  <div class="min-h-screen flex flex-col bg-gray-50 text-ngo-black font-sans">
    <!-- Extracted Navbar Component -->
    <Navbar />
    <!-- Main Content injected here (About, Login, Home, etc.) -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Extracted Footer Component -->
    <Footer />

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue'; // Adjust the path based on your folder structure
import Footer from '@/Components/Footer.vue';
const isMobileMenuOpen = ref(false);

// Grab the authenticated user from Laravel's shared Inertia props
const page = usePage();
const user = computed(() => page.props.auth?.user);

// Handle the logout POST request
const logout = () => {
  router.post('/logout');
};
</script>