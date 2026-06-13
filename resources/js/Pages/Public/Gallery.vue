<template>
  <PublicLayout>
    <div class="bg-ngo-black py-16 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
          <h1 class="text-4xl font-extrabold text-white">Impact Gallery</h1>
          <p class="mt-4 text-lg text-gray-400">A visual journey of our work around the world.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <div v-for="item in gallery" :key="item.id" class="group relative overflow-hidden rounded-xl h-64 bg-gray-800">
            <img :src="item.file_path" :alt="item.caption" class="w-full h-full object-cover group-hover:scale-110 transition duration-500 ease-in-out" />
            
            <div class="absolute inset-0 bg-gradient-to-t from-ngo-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">
              <div v-if="item.caption" class="p-4 text-white">
                <p class="text-sm font-medium">{{ item.caption }}</p>
              </div>
            </div>
            
            <div v-if="item.type === 'video'" class="absolute inset-0 flex items-center justify-center">
               <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                 <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
               </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';

defineProps({
  gallery: Array
});
</script>