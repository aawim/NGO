<template>
  <Head :title="project.title" />

  <PublicLayout>
    <!-- Breadcrumbs -->
    <div class="bg-gray-100 border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex text-sm font-medium text-gray-500">
          <Link href="/" class="hover:text-ngo-blue transition">Home</Link>
          <span class="mx-2">/</span>
          <Link href="/projects" class="hover:text-ngo-blue transition">Projects</Link>
          <span class="mx-2">/</span>
          <span class="text-gray-900 truncate">{{ project.title }}</span>
        </nav>
      </div>
    </div>

    <!-- Hero Section -->
    <div class="relative w-full h-80 sm:h-96 lg:h-[450px] bg-gray-900">
      <img 
        :src="getImageUrl(project.image)" 
        :alt="project.title" 
        class="w-full h-full object-cover opacity-60"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
      
      <div class="absolute bottom-0 left-0 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
          <div class="flex items-center space-x-3 mb-4">
            <span 
              class="text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider text-white shadow-sm"
              :class="project.status === 'Completed' ? 'bg-ngo-green' : 'bg-ngo-orange'"
            >
              {{ project.status }}
            </span>
            <span v-if="project.location" class="flex items-center text-gray-300 text-sm font-medium">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
              {{ project.location }}
            </span>
          </div>
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
            {{ project.title }}
          </h1>
        </div>
      </div>
    </div>
 
    <!-- Content Section -->
    <div class="bg-white py-12 sm:py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
          
          <!-- Left Column: Story/Description -->
          <div class="lg:col-span-2 space-y-8">
            <h2 class="text-2xl font-bold text-ngo-blue">About the Project</h2>
            
            <!-- Fallback to short description if main description is empty -->
            <p v-if="!project.description" class="text-lg text-gray-600 leading-relaxed">
              {{ project.short_description }}
            </p>

            <!-- Render HTML description from the database safely -->
            <div 
              v-else 
              v-html="project.description" 
              class="prose prose-lg text-gray-600 max-w-none prose-headings:text-ngo-blue prose-a:text-ngo-orange hover:prose-a:text-orange-600"
            ></div>
          </div>

          <!-- Right Column: Sidebar (Funding & Details) -->
          <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm sticky top-8">
              
              <h3 class="text-xl font-bold text-gray-900 mb-6">Funding Progress</h3>
              
              <!-- Progress Bar -->
              <div class="mb-6">
                <div class="flex justify-between items-end mb-2">
                  <span class="text-3xl font-extrabold text-ngo-green">
                    ${{ Number(project.raised_amount).toLocaleString() }}
                  </span>
                  <span class="text-sm font-medium text-gray-500 mb-1">
                    raised of ${{ Number(project.budget).toLocaleString() }}
                  </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                  <div 
                    class="bg-ngo-green h-3 rounded-full transition-all duration-1000 ease-out" 
                    :style="{ width: progressPercentage + '%' }"
                  ></div>
                </div>
                <div class="mt-2 text-right text-sm font-bold text-gray-700">
                  {{ progressPercentage }}% Funded
                </div>
              </div>

              <!-- Quick Info List -->
              <ul class="space-y-4 mb-8 pt-6 border-t border-gray-200">
                <li class="flex items-start">
                  <svg class="w-5 h-5 text-ngo-blue mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                  <div>
                    <p class="text-sm font-medium text-gray-500">Timeline</p>
                    <p class="text-sm font-semibold text-gray-900">
                      {{ formatDate(project.start_date) }} &mdash; {{ formatDate(project.end_date) || 'Ongoing' }}
                    </p>
                  </div>
                </li>
              </ul>

              <!-- Donate Action -->
              <div v-if="project.status !== 'Completed'">
                <Link 
                  :href="`/donate?project=${project.id}`" 
                  class="w-full block text-center bg-ngo-orange hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-xl transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                >
                  Donate to this Project
                </Link>
                <p class="text-xs text-center text-gray-500 mt-3">
                  100% of your donation directly funds this initiative.
                </p>
              </div>
              
              <!-- Completed State -->
              <div v-else class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                <svg class="w-8 h-8 text-ngo-green mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold text-green-800">Fully Funded & Completed</p>
                <p class="text-sm text-green-600 mt-1">Thank you to all our donors!</p>
              </div>

            </div>
          </div>

<!-- Left Column: Story/Description -->
          <div class="lg:col-span-2 space-y-8">
            <!-- <h2 class="text-2xl font-bold text-ngo-blue">About the Project</h2> -->
            
            <!-- <p v-if="!project.description" class="text-lg text-gray-600 leading-relaxed">
              {{ project.short_description }}
            </p>

            <div 
              v-else 
              v-html="project.description" 
              class="prose prose-lg text-gray-600 max-w-none prose-headings:text-ngo-blue prose-a:text-ngo-orange hover:prose-a:text-orange-600"
            ></div> -->

            <hr class="border-gray-200 my-10" />

            <!-- ======================================= -->
            <!-- COMMENTS SECTION START                  -->
            <!-- ======================================= -->
            <div class="space-y-8">
              <h3 class="text-2xl font-bold text-gray-900">Community Comments ({{ project.project_comments?.length || 0 }})</h3>

              <!-- Comment Form (Logged In) -->
              <div v-if="$page.props.auth.user" class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <form @submit.prevent="submitComment(null)">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Leave a comment</label>
                  <textarea 
                    v-model="commentForm.body" 
                    rows="3" 
                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm resize-none transition-colors"
                    placeholder="Share your thoughts or words of encouragement..."
                  ></textarea>
                  <p v-if="commentForm.errors.body" class="mt-1 text-sm text-red-600">{{ commentForm.errors.body }}</p>
                  
                  <div class="mt-4 flex justify-end">
                    <button 
                      type="submit" 
                      :disabled="commentForm.processing || !commentForm.body.trim()"
                      class="inline-flex justify-center items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-ngo-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-blue disabled:opacity-50 transition-colors"
                    >
                      <svg v-if="commentForm.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                      Post Comment
                    </button>
                  </div>
                </form>
              </div>

              <!-- Login Prompt (Logged Out) -->
              <div v-else class="bg-blue-50 border border-blue-100 p-6 rounded-2xl flex items-center justify-between">
                <div>
                  <h4 class="text-blue-900 font-bold">Join the conversation</h4>
                  <p class="text-blue-700 text-sm mt-1">You must be logged in to leave a comment.</p>
                </div>
                <Link href="/login" class="bg-white text-ngo-blue font-semibold px-5 py-2 rounded-lg shadow-sm border border-blue-200 hover:bg-blue-50 transition">
                  Log In
                </Link>
              </div>
 
              <!-- Comments List -->
              <div class="space-y-6 mt-8">
                <div v-if="!project.project_comments || project.project_comments.length === 0" class="text-center py-8 text-gray-500">
                  No comments yet. Be the first to share your thoughts!
                </div>
                
                <div v-else v-for="comment in project.project_comments" :key="comment.id" class="space-y-4">
                  <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                      <div class="h-10 w-10 rounded-full bg-ngo-green text-white flex items-center justify-center font-bold text-lg">
                        {{ comment.user.name.charAt(0).toUpperCase() }}
                      </div>
                    </div>
                    <div class="flex-grow">
                      <div class="bg-gray-50 px-5 py-4 rounded-2xl rounded-tl-none border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                          <h5 class="text-sm font-bold text-gray-900">{{ comment.user.name }}</h5>
                          <span class="text-xs text-gray-500">{{ formatCommentDate(comment.created_at) }}</span>
                        </div>
                        <p class="text-gray-700 text-sm whitespace-pre-line">{{ comment.body }}</p>
                      </div>
                      
                      <div class="mt-2 ml-2" v-if="$page.props.auth.user">
                        <button 
                          @click="activeReplyId = activeReplyId === comment.id ? null : comment.id"
                          class="text-xs font-bold text-gray-500 hover:text-ngo-blue transition-colors flex items-center"
                        >
                          <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                          {{ activeReplyId === comment.id ? 'Cancel Reply' : 'Reply' }}
                        </button>
                      </div>

                      <div v-if="activeReplyId === comment.id" class="mt-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm ml-4">
                        <form @submit.prevent="submitComment(comment.id)">
                          <textarea 
                            v-model="commentForm.body" 
                            rows="2" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm resize-none"
                            placeholder="Write a reply..."
                          ></textarea>
                          <div class="mt-3 flex justify-end">
                            <button 
                              type="submit" 
                              :disabled="commentForm.processing || !commentForm.body.trim()"
                              class="px-4 py-1.5 border border-transparent text-xs font-bold rounded text-white bg-ngo-blue hover:bg-blue-700 disabled:opacity-50 transition-colors"
                            >
                              Post Reply
                            </button>
                          </div>
                        </form>
                      </div>

                      <div v-if="comment.replies && comment.replies.length > 0" class="mt-4 space-y-4 ml-6 border-l-2 border-gray-100 pl-4">
                        <div v-for="reply in comment.replies" :key="reply.id" class="flex space-x-3">
                          <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-ngo-orange text-white flex items-center justify-center font-bold text-sm">
                              {{ reply.user.name.charAt(0).toUpperCase() }}
                            </div>
                          </div>
                          <div class="flex-grow">
                            <div class="bg-gray-50 px-4 py-3 rounded-2xl rounded-tl-none border border-gray-100">
                              <div class="flex items-center justify-between mb-1">
                                <h5 class="text-xs font-bold text-gray-900">{{ reply.user.name }}</h5>
                                <span class="text-[10px] text-gray-500">{{ formatCommentDate(reply.created_at) }}</span>
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



        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { computed,ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

// The project data passed from PublicController
const props = defineProps({
  project: {
    type: Object,
    required: true
  }
});


// --- Comment Logic ---
const commentForm = useForm({
  body: '',
  parent_id: null
});

const activeReplyId = ref(null);

const submitComment = (parentId = null) => {
   if (parentId instanceof Event) {
    parentId = null;
  }
    commentForm.parent_id = parentId;

  commentForm.post(`/projects/${props.project.id}/comments`, {
    preserveScroll: true,
    onSuccess: () => {
      commentForm.reset('body', 'parent_id'); // Clear the textarea on success
      activeReplyId.value = null; // Close the reply box
    }
  });
};

// Formats comments to look like "2 hours ago" or "Jun 12, 2026"
const formatCommentDate = (dateString) => {
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('en-US', {
    month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit'
  }).format(date);
};



// Calculate funding percentage safely
const progressPercentage = computed(() => {
  if (!props.project.budget || props.project.budget <= 0) return 0;
  const percent = (props.project.raised_amount / props.project.budget) * 100;
  return Math.min(Math.round(percent), 100); // Caps at 100% visually
});

// Helper for local vs external images
const getImageUrl = (path) => {
  if (!path) return 'https://via.placeholder.com/1200x600?text=Project+Image';
  if (path.startsWith('http://') || path.startsWith('https://')) return path;
  return `/storage/${path}`;
};

// Date formatter
const formatDate = (dateString) => {
  if (!dateString) return null;
  return new Date(dateString).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  });
};
</script>

<style scoped>
/* 
  If you use Tailwind's Typography plugin (@tailwindcss/typography), 
  the 'prose' class handles HTML styling automatically. 
  If you don't have it installed, these fallback styles ensure 
  your WYSIWYG database content looks good! 
*/
:deep(.prose p) {
  margin-bottom: 1.5em;
}
:deep(.prose ul) {
  list-style-type: disc;
  padding-left: 1.5em;
  margin-bottom: 1.5em;
}
:deep(.prose h3) {
  font-size: 1.5rem;
  font-weight: bold;
  margin-top: 2em;
  margin-bottom: 1em;
}
</style>