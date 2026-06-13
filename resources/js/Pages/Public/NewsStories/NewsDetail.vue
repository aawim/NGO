<template>
  <Head :title="story.title" />
  <PublicLayout>
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      
      <div class="text-center mb-10">
        <span class="text-sm font-bold text-ngo-orange uppercase tracking-widest">{{ story.type.replace('_', ' ') }}</span>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mt-4 mb-6">{{ story.title }}</h1>
        <div class="flex items-center justify-center text-gray-500 text-sm space-x-4">
          <span>By {{ story.user?.name || 'Editorial Team' }}</span>
          <span>•</span>
          <span>{{ formatDate(story.published_at) }}</span>
          <span>•</span>
          <span>{{ story.views }} Views</span>
        </div>
      </div>

      <div class="w-full h-[400px] rounded-2xl overflow-hidden mb-12 shadow-lg">
        <img :src="story.featured_image ? `/storage/${story.featured_image}` : 'https://via.placeholder.com/1200x600'" class="w-full h-full object-cover">
      </div>

      <div class="prose prose-lg max-w-none text-gray-700" v-html="story.content"></div>

      <div v-if="story.tags && story.tags.length" class="mt-12 pt-8 border-t border-gray-200">
        <h4 class="text-sm font-bold text-gray-900 mb-3">Tagged under:</h4>
        <div class="flex flex-wrap gap-2">
          <span v-for="tag in story.tags" :key="tag" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium uppercase">
            {{ tag }}
          </span>
        </div>
      </div>

    </article>
  </PublicLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

defineProps({ story: Object });
const formatDate = (date) => new Date(date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
</script>

<style scoped>
/* Standard Prose Fallbacks for WYSIWYG Content */
:deep(.prose p) { margin-bottom: 1.5em; line-height: 1.8; }
:deep(.prose h2) { font-size: 2rem; font-weight: bold; color: #111827; margin-top: 2em; margin-bottom: 1em; }
:deep(.prose h3) { font-size: 1.5rem; font-weight: bold; color: #111827; margin-top: 1.5em; margin-bottom: 0.5em; }
:deep(.prose ul) { list-style-type: disc; padding-left: 2em; margin-bottom: 1.5em; }
:deep(.prose a) { color: #2563eb; text-decoration: underline; }
:deep(.prose img) { border-radius: 0.75rem; margin-top: 2em; margin-bottom: 2em; width: 100%; }
</style>