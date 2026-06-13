<template>
  <Head title="News & Impact Stories" />
  <PublicLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <h1 class="text-4xl font-extrabold text-ngo-blue mb-2">Latest Updates</h1>
      <p class="text-xl text-gray-600 mb-12">Read about our latest impact, events, and community stories.</p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="story in stories" :key="story.id" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition">
          <img :src="story.featured_image ? `/storage/${story.featured_image}` : 'https://via.placeholder.com/600x400'" class="h-48 w-full object-cover">
          <div class="p-6 flex-1 flex flex-col">
            <span class="text-xs font-bold text-ngo-orange uppercase tracking-wider mb-2">{{ story.type.replace('_', ' ') }}</span>
            <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">{{ story.title }}</h2>
            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ story.excerpt || stripHtml(story.content) }}</p>
            <div class="mt-auto flex justify-between items-center">
              <span class="text-xs text-gray-400">{{ formatDate(story.published_at) }}</span>
              <Link :href="`/news-stories/${story.slug}`" class="text-ngo-blue font-bold text-sm hover:underline">Read More →</Link>
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

defineProps({ stories: Array });
const stripHtml = (html) => new DOMParser().parseFromString(html, 'text/html').body.textContent || "";
const formatDate = (date) => new Date(date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
</script>