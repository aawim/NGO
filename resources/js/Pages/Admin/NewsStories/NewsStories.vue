<template>
  <Head title="News & Stories" />

  <AuthenticatedLayout>
    <div class="space-y-6">
      
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="relative w-full sm:max-w-md">
          <input 
            v-model="searchQuery"
            type="text" 
            class="block w-full pl-4 pr-3 py-2 border border-gray-300 rounded-lg text-sm"
            placeholder="Search articles..."
          >
        </div>
        <button @click="openPanel('add')" class="px-4 py-2 text-white bg-ngo-blue hover:bg-blue-700 rounded-lg text-sm font-medium">
          Create Post
        </button>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type / Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="story in filteredStories" :key="story.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="text-sm font-bold text-gray-900">{{ story.title }}</div>
                <div class="text-xs text-gray-500">By {{ story.user?.name || 'System' }} • {{ formatDate(story.created_at) }}</div>
              </td>
              <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 uppercase mr-2">{{ story.type.replace('_', ' ') }}</span>
                <span :class="[
                  'px-2 py-1 text-xs font-semibold rounded-full uppercase',
                  story.status === 'published' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800'
                ]">{{ story.status }}</span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ story.views }}</span>
              </td>
              <td class="px-6 py-4 text-right text-sm font-medium">
                <button @click="openPanel('edit', story)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button @click="deleteStory(story.id)" class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <Teleport to="body">
        <div v-show="isPanelOpen" class="fixed inset-0 z-50 flex justify-end">
          <div class="fixed inset-0 bg-black/50" @click="closePanel"></div>
          <div class="relative w-full max-w-2xl bg-white h-full overflow-y-auto z-10 flex flex-col shadow-2xl">
            <div class="p-6 bg-ngo-blue text-white flex justify-between">
              <h2 class="text-xl font-bold">{{ isEditing ? 'Edit Post' : 'New Post' }}</h2>
              <button @click="closePanel">✕</button>
            </div>
            
            <form class="p-6 space-y-6 flex-1">
              <div>
                <label class="block text-sm font-bold text-gray-700">Headline</label>
                <input v-model="form.title" type="text" class="w-full mt-1 border-gray-300 rounded-lg">
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-bold text-gray-700">Type</label>
                  <select v-model="form.type" class="w-full mt-1 border-gray-300 rounded-lg">
                    <option value="news">News</option>
                    <option value="story">Impact Story</option>
                    <option value="press_release">Press Release</option>
                    <option value="event_update">Event Update</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700">Status</label>
                  <select v-model="form.status" class="w-full mt-1 border-gray-300 rounded-lg">
                    <option value="draft">Draft</option>
                    <option value="review">Needs Review</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                  </select>
                </div>
              </div>

              <div>
                <label class="block text-sm font-bold text-gray-700">Article Content (HTML supported)</label>
                <textarea v-model="form.content" rows="8" class="w-full mt-1 border-gray-300 rounded-lg"></textarea>
              </div>
              
              <div>
                <label class="block text-sm font-bold text-gray-700">Short Excerpt</label>
                <textarea v-model="form.excerpt" rows="2" class="w-full mt-1 border-gray-300 rounded-lg text-sm" placeholder="Brief summary for the preview card..."></textarea>
              </div>

              <div>
                <label class="block text-sm font-bold text-gray-700">Tags (Comma Separated)</label>
                <input v-model="form.tags" type="text" placeholder="e.g. education, water, africa" class="w-full mt-1 border-gray-300 rounded-lg">
              </div>

              <div class="flex items-center space-x-2">
                <input v-model="form.featured" type="checkbox" id="featured" class="rounded text-ngo-blue">
                <label for="featured" class="text-sm font-medium text-gray-700">Feature this story on the homepage</label>
              </div>

              <div>
                <label class="block text-sm font-bold text-gray-700">Featured Image</label>
                <input type="file" @input="form.featured_image = $event.target.files[0]" class="mt-1">
              </div>
            </form>

            <div class="p-6 border-t bg-gray-50 flex justify-end space-x-3">
              <button @click="closePanel" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Cancel</button>
              <button @click="submitForm" class="px-4 py-2 bg-ngo-blue text-white rounded-lg hover:bg-blue-700">Save Post</button>
            </div>
          </div>
        </div>
      </Teleport>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ stories: Array });
const searchQuery = ref('');
const isPanelOpen = ref(false);
const isEditing = ref(false);

const form = useForm({
  id: null,
  title: '',
  type: 'news',
  status: 'draft',
  content: '',
  excerpt: '',
  tags: '',
  featured: false,
  featured_image: null
});

const filteredStories = computed(() => {
  if (!searchQuery.value) return props.stories;
  return props.stories.filter(s => s.title.toLowerCase().includes(searchQuery.value.toLowerCase()));
});

const openPanel = (mode, data = null) => {
  if (mode === 'edit') {
    isEditing.value = true;
    form.id = data.id;
    form.title = data.title;
    form.type = data.type;
    form.status = data.status;
    form.content = data.content;
    form.excerpt = data.excerpt;
    form.tags = data.tags ? data.tags.join(', ') : '';
    form.featured = !!data.featured;
    form.featured_image = null;
  } else {
    isEditing.value = false;
    form.reset();
  }
  isPanelOpen.value = true;
};

const closePanel = () => { isPanelOpen.value = false; form.reset(); };

const submitForm = () => {
  if (isEditing.value) {
    form.transform(data => ({ ...data, _method: 'put' }))
        .post(`/admin/news-stories/${form.id}`, { onSuccess: () => closePanel() });
  } else {
    form.post('/admin/news-stories', { onSuccess: () => closePanel() });
  }
};

const deleteStory = (id) => {
  if (confirm('Are you sure you want to delete this post?')) {
    router.delete(`/admin/news-stories/${id}`);
  }
};

const formatDate = (date) => new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
</script>