<template>
  <Head title="Our Causes" />
  
  <PublicLayout>
    <div class="bg-gray-50 py-16 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
          <h1 class="text-4xl font-extrabold text-ngo-orange">Our Causes</h1>
          <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">Discover the core initiatives driving our mission and find a cause you believe in.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-if="causes.length === 0" class="col-span-full text-center py-12 text-gray-500">
            No causes available at the moment.
          </div>

          <div v-for="cause in causes" :key="cause.id" class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden flex flex-col">
            <div class="h-56 relative group">
              <img :src="getImageUrl(cause.image)" :alt="cause.title" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
              <div class="absolute inset-0 bg-ngo-orange opacity-0 group-hover:opacity-20 transition duration-300"></div>
              <div class="absolute top-4 right-4 text-white text-xs font-bold px-3 py-1 rounded-full uppercase shadow-sm" :class="cause.status === 'completed' ? 'bg-ngo-green' : 'bg-ngo-orange'">
                {{ cause.status }}
              </div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
              <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ cause.title }}</h2>
              
              <div class="mb-4">
                <div class="flex justify-between items-end mb-1">
                  <span class="text-sm font-bold text-ngo-green">${{ Number(cause.raised_amount).toLocaleString() }}</span>
                  <span class="text-xs text-gray-500">of ${{ Number(cause.goal_amount).toLocaleString() }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                  <div class="bg-ngo-green h-2 rounded-full" :style="{ width: getProgress(cause) + '%' }"></div>
                </div>
              </div>

              <p class="text-gray-600 mb-6 line-clamp-3 text-sm" v-html="stripHtml(cause.description)"></p>
              
              <div class="mt-auto">
                <Link :href="`/causes/${cause.slug}`" class="inline-block w-full text-center bg-gray-100 hover:bg-ngo-orange hover:text-white text-ngo-orange font-bold py-3 rounded-xl transition">
                  Learn More
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

const props = defineProps({
  causes: { type: Array, required: true, default: () => [] }
});

const getProgress = (cause) => {
  if (!cause.goal_amount || cause.goal_amount <= 0) return 0;
  return Math.min(Math.round((cause.raised_amount / cause.goal_amount) * 100), 100);
};

const getImageUrl = (path) => {
  if (!path) return 'https://via.placeholder.com/800x600?text=No+Image';
  if (path.startsWith('http')) return path;
  return `/storage/${path}`;
};

// Quick helper to safely strip HTML tags from the WYSIWYG editor for the card preview
const stripHtml = (html) => {
  if (!html) return '';
  const doc = new DOMParser().parseFromString(html, 'text/html');
  return doc.body.textContent || "";
};
</script>