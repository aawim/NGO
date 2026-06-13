<template>
  <Head title="Our Projects" />
  
  <PublicLayout>
    <div class="bg-gray-50 py-16 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
          <h1 class="text-4xl font-extrabold text-ngo-blue">Our Projects</h1>
          <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">Explore how we are putting your donations to work in communities around the world.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Empty State -->
          <div v-if="projects.length === 0" class="col-span-full text-center py-12 text-gray-500">
            No projects available at the moment. Check back soon!
          </div>

          <!-- Project Cards -->
          <div v-for="project in projects" :key="project.id" class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden flex flex-col">
            <div class="h-56 relative group">
              <img 
                :src="getImageUrl(project.image)" 
                :alt="project.title" 
                class="w-full h-full object-cover group-hover:scale-105 transition duration-500" 
              />
              <div class="absolute inset-0 bg-ngo-blue opacity-0 group-hover:opacity-20 transition duration-300"></div>
              <div
                class="absolute top-4 right-4 text-white text-xs font-bold px-3 py-1 rounded-full uppercase shadow-sm"
                :class="project.status === 'completed' ? 'bg-ngo-green' : 'bg-ngo-orange'"
              >
                {{ project.status }}
              </div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
              <h2 class="text-2xl font-bold text-ngo-blue mb-2">{{ project.title }}</h2>
              <p class="text-gray-500 text-sm mb-4 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                {{ project.location }}
              </p>
              <p class="text-gray-600 mb-6 line-clamp-3">{{ project.short_description }}</p>
              
              <div class="mt-auto">
                <!-- Using Inertia Link for SPA navigation -->
                <Link :href="`/projects/${project.slug}`" class="inline-block w-full text-center bg-gray-100 hover:bg-ngo-blue hover:text-white text-ngo-blue font-bold py-3 rounded-xl transition">
                  View Details
                </Link>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

// Supplied by Laravel Controller
const props = defineProps({
  projects: {
    type: Array,
    required: true,
    default: () => []
  }
});

// Helper to calculate progress (Ready for you to use in the template if needed!)
const getProgress = (project) => {
  if (!project.budget || project.budget == 0) return 0;
  return Math.min(Math.round((project.raised_amount / project.budget) * 100), 100);
};

// Helper to handle both external URLs (mock data) and local uploads (admin panel)
const getImageUrl = (path) => {
  if (!path) return 'https://via.placeholder.com/800x600?text=No+Image'; // Fallback image
  if (path.startsWith('http://') || path.startsWith('https://')) return path;
  return `/storage/${path}`;
};
</script>