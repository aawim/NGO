<script setup>
import { ref, computed, reactive,onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import ConfirmDeleteModal from '@/Components/ConfirmDeleteModal.vue';

// --- Props from Laravel ---
const props = defineProps({
  projects: {
    type: Array,
    required: true,
    default: () => []
  }
});


// --- Theme Logic ---
const isDarkMode = ref(false);

const toggleTheme = () => {
  isDarkMode.value = !isDarkMode.value;
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  }
};




// Check for saved theme preference on load
onMounted(() => {
  if (localStorage.getItem('theme') === 'dark' || 
     (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDarkMode.value = true;
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
});

// --- State ---
const searchQuery = ref('');
const isPanelOpen = ref(false);
const isPanelExpanded = ref(false);
const isEditing = ref(false);

// --- Detail Modal State ---
const isDetailModalOpen = ref(false);
const selectedProject = ref(null);

const openDetail = (project) => {
  selectedProject.value = project;
  isDetailModalOpen.value = true;
};

const closeDetail = () => {
  isDetailModalOpen.value = false;
  // Delay clearing the data so the exit animation stays populated
  setTimeout(() => {
    selectedProject.value = null;
  }, 300);
};

// Helper to calculate the funding progress bar width
const fundingProgress = computed(() => {
  if (!selectedProject.value || !selectedProject.value.budget) return 0;
  const percent = (selectedProject.value.raised_amount / selectedProject.value.budget) * 100;
  return percent > 100 ? 100 : Math.round(percent);
});

// --- Delete Modal State ---
const isDeleteModalOpen = ref(false);
const projectToDelete = ref(null);
const isDeleting = ref(false); // To show the loading spinner on the button




// Form Object (Matches your requested columns)
const defaultForm = {
id: null,
  title: '',
  slug: '',
  short_description: '',
  description: '',
  image: null,
  location: '',
  budget: 0, // Using 0 as default for decimal fields
  raised_amount: 0,
  status: 'draft', // Matches your DB default
  start_date: '',
  end_date: '',
  featured: false   
};

const form = useForm({...defaultForm });


// --- Computed: Bulletproof Filtering ---
const filteredProjects = computed(() => {
    const projectArray = Array.isArray(props.projects)
        ? props.projects
        : (props.projects?.data || []);

    return projectArray
        .filter(project => project) // remove undefined/null items
        .filter(project => {
            if (!searchQuery.value) return true;

            const query = searchQuery.value.toLowerCase();

            return (
                (project.title || '').toLowerCase().includes(query) ||
                (project.location || '').toLowerCase().includes(query)
            );
        });
});

// --- Methods ---
const openPanel = (mode, projectData = null) => {
  if (mode === 'edit' && projectData) {
    isEditing.value = true;
    
    // Map existing data, matching the new DB columns
    form.id = projectData.id;
    form.title = projectData.title;
    form.slug = projectData.slug;
    form.short_description = projectData.short_description;
    form.description = projectData.description;
    form.image = null; // Don't bind the existing string file path to a file input
    form.location = projectData.location;
    form.budget = projectData.budget;
    form.raised_amount = projectData.raised_amount;
    form.status = projectData.status;
    form.start_date = projectData.start_date;
    form.end_date = projectData.end_date;
    form.featured = !!projectData.featured; 
  } else {
    isEditing.value = false;
    form.reset(); 
  }
  isPanelOpen.value = true;
};



const closePanel = () => {
  isPanelOpen.value = false;
  setTimeout(() => {
    form.reset();
    form.clearErrors();
    isPanelExpanded.value = false;
  }, 300);
};

// --- CRUD Actions ---
const submitForm = () => {
  if (isEditing.value) {
    // UPDATE


    form.transform((data) => ({
      ...data,
      _method: 'put',
    })).post(`/admin/projects/${form.id}`, {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => closePanel(),
    });




    // form.put(`/admin/projects/${form.id}`, {
    //   preserveScroll: true,
    //   forceFormData: true,
    //   onSuccess: () => closePanel(),
    // });
  } else {
    // CREATE
    form.post('/admin/projects', {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => closePanel(),
    });
  }
};

// const deleteProject = (id) => {
//   if (confirm('Are you sure you want to delete this project?')) {
//     router.delete(`/admin/projects/${id}`, {
//       preserveScroll: true,
//     });
//   }
// };

const confirmDelete = (id) => {
  projectToDelete.value = id;
  isDeleteModalOpen.value = true;
};

const executeDelete = () => {
  isDeleting.value = true;
  
  router.delete(`/admin/projects/${projectToDelete.value}`, {
    preserveScroll: true,
    onSuccess: () => {
      isDeleteModalOpen.value = false;
      isDeleting.value = false;
      projectToDelete.value = null;
    },
    onError: () => {
      isDeleting.value = false;
    }
  });
};

 

</script>
  
<style scoped>
/* Optional: Consistent scrollbar styling matching your layout */
.custom-scrollbar::-webkit-scrollbar {
  height: 6px;
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(156, 163, 175, 0.5);
  border-radius: 10px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(75, 85, 99, 0.5);
}
</style>


<template>
    <Head title="Manage Projects" />

 <AuthenticatedLayout>
 <div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="relative w-full sm:max-w-md">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input 
          v-model="searchQuery"
          type="text" 
          class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-ngo-green focus:border-ngo-green sm:text-sm transition-colors"
          placeholder="Search projects..."
        >
      </div>

      <button 
        @click="openPanel('add')"
        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-ngo-green hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-green dark:focus:ring-offset-gray-900 transition-colors"
      >
        <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Project
      </button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
      <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-900/50">
            <tr>
                
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Project Details</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Funding</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Timeline</th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr v-for="project in filteredProjects" :key="project?.id"  class="even:bg-gray-50 dark:even:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
              
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <svg v-if="project.featured" class="w-5 h-5 text-yellow-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                  </svg>
                  <div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ project?.title || 'Untitled Project' }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate w-48">{{ project.description }}</div>
                  </div>
                </div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                {{ project.location }}
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">Goal: ${{ project.budget.toLocaleString() }}</div>
                <div class="text-sm text-ngo-green font-medium">Raised: ${{ project.raised_amount.toLocaleString() }}</div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                <div>Start: {{ project.start_date }}</div>
                <div>End: {{ project.end_date }}</div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <span :class="[
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                  project.status === 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                  project.status === 'Completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 
                  'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'
                ]">
                  {{ project.status }}
                </span>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end space-x-3">
                  <!-- <button class="text-gray-400 hover:text-ngo-blue transition-colors" title="View Details">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                  </button> -->
                 <button @click="openDetail(project)" class="text-gray-400 hover:text-ngo-blue transition-colors" title="View Details">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
                 
                  <button @click="openPanel('edit', project)" class="text-gray-400 hover:text-ngo-orange transition-colors" title="Edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                  </button>
                  <!-- <button class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                  </button> -->

                  <button @click="confirmDelete(project.id)" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between sm:px-6">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-gray-700 dark:text-gray-300">
              Showing <span class="font-medium text-gray-900 dark:text-white">1</span> to <span class="font-medium text-gray-900 dark:text-white">10</span> of <span class="font-medium text-gray-900 dark:text-white">42</span> results
            </p>
          </div>
          <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
              <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                <span class="sr-only">Previous</span>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
              </button>
              <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">1</button>
              <button class="relative inline-flex items-center px-4 py-2 border border-ngo-green bg-green-50 dark:bg-green-900/20 text-sm font-medium text-ngo-green z-10">2</button>
              <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">3</button>
              <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                <span class="sr-only">Next</span>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
              </button>
            </nav>
          </div>
        </div>
      </div>
    </div>

<!-- Slide-over Panel -->
    <Teleport to="body">
      
      <transition 
        enter-active-class="transition-opacity ease-linear duration-300" 
        enter-from-class="opacity-0" 
        enter-to-class="opacity-100" 
        leave-active-class="transition-opacity ease-linear duration-300" 
        leave-from-class="opacity-100" 
        leave-to-class="opacity-0"
      >
        <div v-show="isPanelOpen" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm" @click="closePanel"></div>
      </transition>

      <transition 
        enter-active-class="transition ease-in-out duration-500 transform" 
        enter-from-class="translate-x-full" 
        enter-to-class="translate-x-0" 
        leave-active-class="transition ease-in-out duration-500 transform" 
        leave-from-class="translate-x-0" 
        leave-to-class="translate-x-full"
      >
        <div v-show="isPanelOpen" class="fixed inset-y-0 right-0 z-50 flex pointer-events-none pl-10">
          
          <div :class="['pointer-events-auto h-full bg-white dark:bg-[#1e1e1e] shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col overflow-y-scroll custom-scrollbar transition-[max-width] duration-300 ease-in-out', isPanelExpanded ? 'w-screen max-w-3xl' : 'w-screen max-w-md']">
            
            <div class="bg-ngo-blue px-4 py-6 sm:px-6 shadow-md z-10 shrink-0">
              <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-white" id="slide-over-title">
                  {{ isEditing ? 'Edit Project' : 'Add New Project' }}
                </h2>
                <div class="ml-3 flex h-7 items-center space-x-3">
                  <button @click="isPanelExpanded = !isPanelExpanded" class="rounded-md text-blue-200 hover:text-white focus:outline-none transition-colors">
                    <span class="sr-only">Toggle width</span>
                    <svg v-if="!isPanelExpanded" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h6m0 0v6m0-6l-7 7m17-11h-6m0 0V4m0 6l7-7m-7 17l7-7M4 4l7 7"></path></svg>
                  </button>
                  <button @click="closePanel" class="rounded-md text-blue-200 hover:text-white focus:outline-none transition-colors">
                    <span class="sr-only">Close panel</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                  </button>
                </div>
              </div>
            </div>

            <div class="relative flex-1 px-4 py-6 sm:px-6">
              <form class="space-y-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Title</label>
                  <input v-model="form.title" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors">
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                  <textarea v-model="form.description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors"></textarea>
                </div>

                <div :class="[isPanelExpanded ? 'grid grid-cols-2 gap-4' : 'space-y-6']">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                    <input v-model="form.location" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors">
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select v-model="form.status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors">
                      <option>Active</option>
                      <option>Planned</option>
                      <option>Completed</option>
                    </select>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Budget ($)</label>
                    <input v-model="form.budget" type="number" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors">
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Raised ($)</label>
                    <input v-model="form.raised_amount" type="number" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors">
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                    <input v-model="form.start_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors">
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                    <input v-model="form.end_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300 shadow-sm focus:border-ngo-green focus:ring-ngo-green sm:text-sm px-3 py-2 border transition-colors">
                  </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Image</label>
                    <input 
                        type="file" 
                         @change="form.image = $event.target.files[0]"
                        accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-ngo-green file:text-white hover:file:bg-green-600 transition-colors cursor-pointer"
                    >
                    <div v-if="form.progress" class="w-full bg-gray-200 rounded-full h-1.5 mt-2 dark:bg-gray-700">
                        <div class="bg-ngo-blue h-1.5 rounded-full" :style="{ width: form.progress.percentage + '%' }"></div>
                    </div>
                    </div>


                <div class="flex items-center mt-4">
                  <input v-model="form.featured" id="featured" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-ngo-green focus:ring-ngo-green transition-colors">
                  <label for="featured" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Feature this project on homepage</label>
                </div>
              </form>
            </div>

            <div class="shrink-0 border-t border-gray-200 dark:border-gray-800 px-4 py-4 sm:px-6 bg-gray-50 dark:bg-[#121212]">
              <div class="flex justify-end space-x-3">
                <button @click="closePanel" type="button" class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-ngo-blue transition-colors">
                  Cancel
                </button>
            <button 
            @click="submitForm" 
            :disabled="form.processing"
            type="button" 
            class="inline-flex justify-center rounded-md border border-transparent bg-ngo-green px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none disabled:opacity-50 transition-colors"
            >
            {{ form.processing ? 'Saving...' : (isEditing ? 'Save Changes' : 'Create Project') }}
            </button>
              </div>
            </div>
            
          </div>
        </div>
      </transition>
    </Teleport>
  </div>

 <!--  Detaidl Model -->

 <Teleport to="body">
      <transition 
        enter-active-class="transition-opacity ease-out duration-300" 
        enter-from-class="opacity-0" 
        enter-to-class="opacity-100" 
        leave-active-class="transition-opacity ease-in duration-200" 
        leave-from-class="opacity-100" 
        leave-to-class="opacity-0"
      >
        <div v-show="isDetailModalOpen" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm" @click="closeDetail"></div>
      </transition>

      <transition 
        enter-active-class="transition ease-out duration-300 transform" 
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
        enter-to-class="opacity-100 translate-y-0 sm:scale-100" 
        leave-active-class="transition ease-in duration-200 transform" 
        leave-from-class="opacity-100 translate-y-0 sm:scale-100" 
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      >
        <div v-show="isDetailModalOpen" class="fixed inset-0 z-[70] z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
          
          <div v-if="selectedProject" class="pointer-events-auto w-full max-w-2xl bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
              <div class="flex items-center space-x-3">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ selectedProject.title }}</h3>
                <span :class="[
                  'px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full',
                  selectedProject.status === 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                  selectedProject.status === 'Completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 
                  'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'
                ]">
                  {{ selectedProject.status }}
                </span>
              </div>
              <button @click="closeDetail" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>

            <div class="px-6 py-6 overflow-y-auto custom-scrollbar space-y-6">
              
              <div class="w-full h-48 bg-gray-100 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                <img v-if="selectedProject.image" :src="`/storage/${selectedProject.image}`" alt="Project Image" class="w-full h-full object-cover" />
                <svg v-else class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                  <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</p>
                  <p class="mt-1 font-semibold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-4 h-4 mr-1 text-ngo-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ selectedProject.location || 'N/A' }}
                  </p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-800">
                  <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Timeline</p>
                  <p class="mt-1 font-semibold text-gray-900 dark:text-white flex items-center text-sm">
                    <svg class="w-4 h-4 mr-1 text-ngo-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ selectedProject.start_date || 'TBD' }} &rarr; {{ selectedProject.end_date || 'TBD' }}
                  </p>
                </div>
              </div>

              <div>
                <div class="flex justify-between items-end mb-2">
                  <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Funding Progress</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ Number(selectedProject.raised_amount).toLocaleString() }} <span class="text-sm font-normal text-gray-500 dark:text-gray-400">raised of ${{ Number(selectedProject.budget).toLocaleString() }}</span></p>
                  </div>
                  <span class="text-sm font-bold text-ngo-green">{{ fundingProgress }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                  <div class="bg-ngo-green h-2.5 rounded-full transition-all duration-1000 ease-out" :style="{ width: fundingProgress + '%' }"></div>
                </div>
              </div>

              <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-2">About this Project</h4>
                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-line">
                  {{ selectedProject.description || selectedProject.description || 'No detailed description available.' }}
                </p>
              </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 flex justify-end space-x-3">
              <button @click="closeDetail" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors">
                Close
              </button>
              <button @click="closeDetail(); openPanel('edit', selectedProject)" class="px-4 py-2 text-sm font-medium text-white bg-ngo-blue hover:bg-blue-700 rounded-md shadow-sm transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Project
              </button>
            </div>

          </div>
        </div>
      </transition>
    </Teleport>



    <ConfirmDeleteModal 
  :show="isDeleteModalOpen"
  title="Delete Project"
  message="Are you sure you want to delete this project? All associated data, including images and funding history, will be permanently removed."
  :processing="isDeleting"
  @close="isDeleteModalOpen = false"
  @confirm="executeDelete"
/>


    </AuthenticatedLayout>
</template>
