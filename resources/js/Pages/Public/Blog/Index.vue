<template>
  <PublicLayout>
    <div class="bg-gray-50 py-16 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
          <h1 class="text-4xl font-extrabold text-ngo-blue">News & Updates</h1>
          <p class="mt-4 text-xl text-gray-600">Stories from the field, organizational updates, and impact reports.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
          <article v-for="post in blogs" :key="post.id" class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition overflow-hidden">
            <a :href="`/blog/${post.slug}`" class="block">
              <img :src="post.featured_image" :alt="post.title" class="w-full h-56 object-cover" />
              <div class="p-6">
                <p class="text-ngo-orange text-sm font-bold mb-2">{{ new Date(post.published_at).toLocaleDateString() }}</p>
                <h2 class="text-xl font-bold text-ngo-blue mb-3 hover:text-ngo-orange transition">{{ post.title }}</h2>
                <p class="text-gray-600 line-clamp-3 mb-4">{{ post.excerpt || stripHtml(post.content) }}</p>
                <span class="text-ngo-blue font-bold flex items-center">Read Article <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>
              </div>
            </a>
          </article>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';

defineProps({
  blogs: Array
});

// Helper to strip HTML tags for the preview excerpt if needed
const stripHtml = (html) => {
  let doc = new DOMParser().parseFromString(html, 'text/html');
  return doc.body.textContent || "";
};
</script>