<template>
  <Head :title="event.title" />

  <PublicLayout>
    <div class="bg-gray-100 border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex text-sm font-medium text-gray-500">
          <Link href="/" class="hover:text-ngo-blue transition">Home</Link>
          <span class="mx-2">/</span>
          <Link href="/events" class="hover:text-ngo-blue transition">Events</Link>
          <span class="mx-2">/</span>
          <span class="text-gray-900 truncate">{{ event.title }}</span>
        </nav>
      </div>
    </div>

    <div class="relative w-full h-80 sm:h-96 lg:h-[450px] bg-gray-900">
      <img :src="getImageUrl(event.image)" :alt="event.title" class="w-full h-full object-cover opacity-60" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
      <div class="absolute bottom-0 left-0 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
            {{ event.title }}
          </h1>
        </div>
      </div>
    </div>

    <div class="bg-white py-12 sm:py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          
          <div class="lg:col-span-2 space-y-8">
            <h2 class="text-2xl font-bold text-gray-900">Event Details</h2>
            <div v-html="event.description || '<p>No description provided.</p>'" class="prose prose-lg text-gray-600 max-w-none prose-headings:text-ngo-blue prose-a:text-ngo-blue hover:prose-a:text-blue-600"></div>

            <hr class="border-gray-200 my-10" />

            <div class="space-y-8">
              <h3 class="text-2xl font-bold text-gray-900">Event Discussion ({{ event.comments?.length || 0 }})</h3>

              <div v-if="$page.props.auth.user" class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <form @submit.prevent="submitComment(null)">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Have a question or comment about this event?</label>
                  <textarea v-model="commentForm.body" rows="3" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm resize-none transition-colors" placeholder="Type your message here..."></textarea>
                  <p v-if="commentForm.errors.body" class="mt-1 text-sm text-red-600">{{ commentForm.errors.body }}</p>
                  
                  <div class="mt-4 flex justify-end">
                    <button type="submit" :disabled="commentForm.processing || !commentForm.body.trim()" class="inline-flex justify-center items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-ngo-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-blue disabled:opacity-50 transition-colors">
                      Post Comment
                    </button>
                  </div>
                </form>
              </div>

              <div v-else class="bg-blue-50 border border-blue-100 p-6 rounded-2xl flex items-center justify-between">
                <div>
                  <h4 class="text-blue-900 font-bold">Join the discussion</h4>
                  <p class="text-blue-700 text-sm mt-1">You must be logged in to leave a comment.</p>
                </div>
                <Link href="/login" class="bg-white text-ngo-blue font-semibold px-5 py-2 rounded-lg shadow-sm border border-blue-200 hover:bg-blue-50 transition">
                  Log In
                </Link>
              </div>

              <div class="space-y-6 mt-8">
                <div v-if="!event.comments || event.comments.length === 0" class="text-center py-8 text-gray-500">
                  No comments yet. Be the first to start the conversation!
                </div>
                
                <div v-else v-for="comment in event.comments" :key="comment.id" class="space-y-4">
                  <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                      <div class="h-10 w-10 rounded-full bg-ngo-orange text-white flex items-center justify-center font-bold text-lg">
                        {{ comment.user?.name?.charAt(0)?.toUpperCase() || '?' }}
                      </div>
                    </div>
                    <div class="flex-grow">
                      <div class="bg-gray-50 px-5 py-4 rounded-2xl rounded-tl-none border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                          <h5 class="text-sm font-bold text-gray-900">{{ comment.user.name }}</h5>
                          <span class="text-xs text-gray-500">{{ formatDate(comment.created_at) }}</span>
                        </div>
                        <p class="text-gray-700 text-sm whitespace-pre-line">{{ comment.body }}</p>
                      </div>
                      
                      <div class="mt-2 ml-2" v-if="$page.props.auth.user">
                        <button @click="activeReplyId = activeReplyId === comment.id ? null : comment.id" class="text-xs font-bold text-gray-500 hover:text-ngo-blue transition-colors flex items-center">
                          <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                          {{ activeReplyId === comment.id ? 'Cancel Reply' : 'Reply' }}
                        </button>
                      </div>

                      <div v-if="activeReplyId === comment.id" class="mt-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm ml-4">
                        <form @submit.prevent="submitComment(comment.id)">
                          <textarea v-model="commentForm.body" rows="2" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm resize-none" placeholder="Write a reply..."></textarea>
                          <div class="mt-3 flex justify-end">
                            <button type="submit" :disabled="commentForm.processing || !commentForm.body.trim()" class="px-4 py-1.5 border border-transparent text-xs font-bold rounded text-white bg-ngo-blue hover:bg-blue-700 disabled:opacity-50 transition-colors">
                              Post Reply
                            </button>
                          </div>
                        </form>
                      </div>

                      <div v-if="comment.replies && comment.replies.length > 0" class="mt-4 space-y-4 ml-6 border-l-2 border-gray-100 pl-4">
                        <div v-for="reply in comment.replies" :key="reply.id" class="flex space-x-3">
                          <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold text-sm">
                              {{ reply.user.name.charAt(0).toUpperCase() }}
                            </div>
                          </div>
                          <div class="flex-grow">
                            <div class="bg-gray-50 px-4 py-3 rounded-2xl rounded-tl-none border border-gray-100">
                              <div class="flex items-center justify-between mb-1">
                                <h5 class="text-xs font-bold text-gray-900">{{ reply.user.name }}</h5>
                                <span class="text-[10px] text-gray-500">{{ formatDate(reply.created_at) }}</span>
                              </div>
                              <p class="text-gray-700 text-sm whitespace-pre-line">{{ reply.body }}</p>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm sticky top-8">
              
              <h3 class="text-xl font-bold text-gray-900 mb-6">When & Where</h3>
              <ul class="space-y-4 mb-8">
                <li class="flex items-start">
                  <svg class="w-5 h-5 text-ngo-blue mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                  <div>
                    <p class="text-sm font-medium text-gray-500">Date & Time</p>
                    <p class="text-sm font-semibold text-gray-900">{{ formatFullDate(event.event_date) }}</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <svg class="w-5 h-5 text-ngo-blue mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                  <div>
                    <p class="text-sm font-medium text-gray-500">Location</p>
                    <p class="text-sm font-semibold text-gray-900">{{ event.location || 'Location TBA' }}</p>
                  </div>
                </li>
              </ul>

              <div v-if="event.goal_amount > 0" class="pt-6 border-t border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Event Fundraising</h3>
                <div class="mb-6">
                  <div class="flex justify-between items-end mb-2">
                    <span class="text-2xl font-extrabold text-ngo-blue">${{ Number(event.raised_amount).toLocaleString() }}</span>
                    <span class="text-xs font-medium text-gray-500 mb-1">of ${{ Number(event.goal_amount).toLocaleString() }}</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div class="bg-ngo-blue h-2 rounded-full transition-all duration-1000 ease-out" :style="{ width: progressPercentage + '%' }"></div>
                  </div>
                </div>
                <Link :href="`/donate?event=${event.id}`" class="w-full block text-center bg-ngo-blue hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-md hover:shadow-lg">
                  Donate to this Event
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
import { ref, computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
  event: { type: Object, required: true }
});

const progressPercentage = computed(() => {
  if (!props.event.goal_amount || props.event.goal_amount <= 0) return 0;
  return Math.min(Math.round((props.event.raised_amount / props.event.goal_amount) * 100), 100);
});

const getImageUrl = (path) => {
  if (!path) return 'https://via.placeholder.com/1200x600?text=Event+Image';
  if (path.startsWith('http')) return path;
  return `/storage/${path}`;
};

const formatFullDate = (dateString) => {
  if (!dateString) return 'TBA';
  return new Intl.DateTimeFormat('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' }).format(new Date(dateString));
};

const formatDate = (dateString) => {
  if (!dateString) return null;
  return new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' }).format(new Date(dateString));
};

// Comment Logic
const commentForm = useForm({
  body: '',
  parent_id: null
});

const activeReplyId = ref(null);

const submitComment = (parentId = null) => {
  if (parentId instanceof Event) parentId = null; // Safety check
  commentForm.parent_id = parentId;
  
  commentForm.post(`/events/${props.event.id}/comments`, {
    preserveScroll: true,
    onSuccess: () => {
      commentForm.reset('body', 'parent_id');
      activeReplyId.value = null; 
    }
  });
};
</script>

<style scoped>
:deep(.prose p) { margin-bottom: 1.5em; }
:deep(.prose ul) { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1.5em; }
:deep(.prose h3) { font-size: 1.5rem; font-weight: bold; margin-top: 2em; margin-bottom: 1em; }
</style>