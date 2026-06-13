<template>
  <Head :title="cause.title" />

  <PublicLayout>
    <div class="bg-gray-100 border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex text-sm font-medium text-gray-500">
          <Link href="/" class="hover:text-ngo-orange transition">Home</Link>
          <span class="mx-2">/</span>
          <Link href="/causes" class="hover:text-ngo-orange transition">Causes</Link>
          <span class="mx-2">/</span>
          <span class="text-gray-900 truncate">{{ cause.title }}</span>
        </nav>
      </div>
    </div>

    <div class="relative w-full h-80 sm:h-96 lg:h-[450px] bg-gray-900">
      <img :src="getImageUrl(cause.image)" :alt="cause.title" class="w-full h-full object-cover opacity-60" />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
      <div class="absolute bottom-0 left-0 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
          <div class="mb-4">
            <span class="text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider text-white shadow-sm" :class="cause.status === 'completed' ? 'bg-ngo-green' : 'bg-ngo-orange'">
              {{ cause.status }}
            </span>
          </div>
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
            {{ cause.title }}
          </h1>
        </div>
      </div>
    </div>

    <div class="bg-white py-12 sm:py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          
          <div class="lg:col-span-2 space-y-8">
            <h2 class="text-2xl font-bold text-gray-900">About this Cause</h2>
            <div v-html="cause.description" class="prose prose-lg text-gray-600 max-w-none prose-headings:text-ngo-orange prose-a:text-ngo-orange hover:prose-a:text-orange-600"></div>

            <hr class="border-gray-200 my-10" />

            <div class="space-y-8">
              <h3 class="text-2xl font-bold text-gray-900">Community Voices ({{ cause.comments?.length || 0 }})</h3>

              <div v-if="$page.props.auth.user" class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <form @submit.prevent="submitComment(null)">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Leave a comment</label>
                  <textarea v-model="commentForm.body" rows="3" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-ngo-orange focus:ring-ngo-orange sm:text-sm resize-none transition-colors" placeholder="Share why this cause matters to you..."></textarea>
                  <p v-if="commentForm.errors.body" class="mt-1 text-sm text-red-600">{{ commentForm.errors.body }}</p>
                  
                  <div class="mt-4 flex justify-end">
                    <button type="submit" :disabled="commentForm.processing || !commentForm.body.trim()" class="inline-flex justify-center items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-ngo-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-orange disabled:opacity-50 transition-colors">
                      Post Comment
                    </button>
                  </div>
                </form>
              </div>

              <div v-else class="bg-orange-50 border border-orange-100 p-6 rounded-2xl flex items-center justify-between">
                <div>
                  <h4 class="text-orange-900 font-bold">Join the conversation</h4>
                  <p class="text-orange-700 text-sm mt-1">You must be logged in to leave a comment.</p>
                </div>
                <Link href="/login" class="bg-white text-ngo-orange font-semibold px-5 py-2 rounded-lg shadow-sm border border-orange-200 hover:bg-orange-50 transition">
                  Log In
                </Link>
              </div>

              <div class="space-y-6 mt-8">
                <div v-if="!cause.comments || cause.comments.length === 0" class="text-center py-8 text-gray-500">
                  No comments yet. Be the first to speak up!
                </div>
                
                <div v-else v-for="comment in cause.comments" :key="comment.id" class="space-y-4">
                  <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                      <div class="h-10 w-10 rounded-full bg-ngo-blue text-white flex items-center justify-center font-bold text-lg">
                        {{ comment.user.name.charAt(0).toUpperCase() }}
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
                        <button @click="activeReplyId = activeReplyId === comment.id ? null : comment.id" class="text-xs font-bold text-gray-500 hover:text-ngo-orange transition-colors flex items-center">
                          <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                          {{ activeReplyId === comment.id ? 'Cancel Reply' : 'Reply' }}
                        </button>
                      </div>

                      <div v-if="activeReplyId === comment.id" class="mt-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm ml-4">
                        <form @submit.prevent="submitComment(comment.id)">
                          <textarea v-model="commentForm.body" rows="2" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-ngo-orange focus:ring-ngo-orange sm:text-sm resize-none" placeholder="Write a reply..."></textarea>
                          <div class="mt-3 flex justify-end">
                            <button type="submit" :disabled="commentForm.processing || !commentForm.body.trim()" class="px-4 py-1.5 border border-transparent text-xs font-bold rounded text-white bg-ngo-orange hover:bg-orange-600 disabled:opacity-50 transition-colors">
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
              <h3 class="text-xl font-bold text-gray-900 mb-6">Funding Goal</h3>
              
              <div class="mb-8">
                <div class="flex justify-between items-end mb-2">
                  <span class="text-3xl font-extrabold text-ngo-green">${{ Number(cause.raised_amount).toLocaleString() }}</span>
                  <span class="text-sm font-medium text-gray-500 mb-1">raised of ${{ Number(cause.goal_amount).toLocaleString() }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                  <div class="bg-ngo-green h-3 rounded-full transition-all duration-1000 ease-out" :style="{ width: progressPercentage + '%' }"></div>
                </div>
                <div class="mt-2 text-right text-sm font-bold text-gray-700">{{ progressPercentage }}% Funded</div>
              </div>

              <div v-if="cause.status !== 'completed'">
                <Link :href="`/donate?cause=${cause.id}`" class="w-full block text-center bg-ngo-orange hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-xl transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                  Support this Cause
                </Link>
              </div>
              <div v-else class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                <svg class="w-8 h-8 text-ngo-green mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold text-green-800">Goal Reached!</p>
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
  cause: { type: Object, required: true }
});

const progressPercentage = computed(() => {
  if (!props.cause.goal_amount || props.cause.goal_amount <= 0) return 0;
  return Math.min(Math.round((props.cause.raised_amount / props.cause.goal_amount) * 100), 100);
});

const getImageUrl = (path) => {
  if (!path) return 'https://via.placeholder.com/1200x600?text=Cause+Image';
  if (path.startsWith('http')) return path;
  return `/storage/${path}`;
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
  
  commentForm.post(`/causes/${props.cause.id}/comments`, {
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