<template>
  <Head title="Become a Volunteer" />

  <PublicLayout>
    <div class="relative bg-ngo-blue py-20 sm:py-32 overflow-hidden">
      <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-ngo-blue to-blue-900"></div>
      </div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl lg:text-6xl tracking-tight mb-6">Make a Real Difference</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto leading-relaxed">
          Join our global community of changemakers. Give your time, share your skills, and help us build a better future for those who need it most.
        </p>
      </div>
    </div>

    <div class="bg-gray-50 py-16 sm:py-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
          
          <div class="lg:col-span-5 space-y-12">
            <div>
              <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Why Volunteer With Us?</h2>
              <p class="text-lg text-gray-600 mb-8">Volunteering is more than just giving back; it’s about connecting with your community, learning new skills, and being part of a movement.</p>
              
              <ul class="space-y-6">
                <li class="flex items-start">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-ngo-blue">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-xl font-bold text-gray-900">Global Impact</h4>
                    <p class="mt-1 text-gray-600">Your efforts directly support our on-the-ground initiatives across multiple regions.</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-orange-100 text-ngo-orange">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-xl font-bold text-gray-900">Skill Development</h4>
                    <p class="mt-1 text-gray-600">Gain hands-on experience in project management, logistics, and community outreach.</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-green-100 text-ngo-green">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-xl font-bold text-gray-900">Community Network</h4>
                    <p class="mt-1 text-gray-600">Work alongside passionate individuals who share your drive to make the world better.</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10 overflow-hidden relative">
              
              <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-blue-50 opacity-50 pointer-events-none"></div>

              <h3 class="text-2xl font-bold text-gray-900 mb-2 relative z-10">Application Form</h3>
              <p class="text-gray-500 mb-8 text-sm relative z-10">Fill out the details below and we will be in touch shortly.</p>
              
              <div v-if="successMessage" class="mb-8 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-start">
                <svg class="w-6 h-6 mr-3 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                  <h4 class="font-bold text-green-900">Application Received!</h4>
                  <p class="text-sm mt-1">{{ successMessage }}</p>
                </div>
              </div>

              <form v-else @submit.prevent="submitForm" class="space-y-6 relative z-10">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-sm font-semibold text-gray-700">Full Name *</label>
                    <input v-model="form.name" type="text" required :disabled="isLoggedIn" :class="['mt-2 block w-full rounded-xl shadow-sm sm:text-sm px-4 py-3 border', isLoggedIn ? 'bg-gray-100 border-transparent text-gray-500 cursor-not-allowed' : 'border-gray-200 focus:ring-ngo-blue focus:border-ngo-blue bg-gray-50/50']">
                    <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-gray-700">Email Address *</label>
                    <input v-model="form.email" type="email" required :disabled="isLoggedIn" :class="['mt-2 block w-full rounded-xl shadow-sm sm:text-sm px-4 py-3 border', isLoggedIn ? 'bg-gray-100 border-transparent text-gray-500 cursor-not-allowed' : 'border-gray-200 focus:ring-ngo-blue focus:border-ngo-blue bg-gray-50/50']">
                    <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-sm font-semibold text-gray-700">Phone Number</label>
                    <input v-model="form.phone" type="text" :disabled="isLoggedIn && !!form.phone" :class="['mt-2 block w-full rounded-xl shadow-sm sm:text-sm px-4 py-3 border', (isLoggedIn && !!form.phone) ? 'bg-gray-100 border-transparent text-gray-500 cursor-not-allowed' : 'border-gray-200 focus:ring-ngo-blue focus:border-ngo-blue bg-gray-50/50']">
                    <p v-if="form.errors.phone" class="mt-1 text-xs text-red-500">{{ form.errors.phone }}</p>
                  </div>
                  <div>
                    <label class="block text-sm font-semibold text-gray-700">Availability *</label>
                    <select v-model="form.availability" required class="mt-2 block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:ring-ngo-blue focus:border-ngo-blue sm:text-sm px-4 py-3">
                      <option value="" disabled>Select your availability...</option>
                      <option value="Anytime">Anytime / Highly Flexible</option>
                      <option value="Weekdays">Weekdays (Mon-Fri)</option>
                      <option value="Weekends">Weekends Only</option>
                      <option value="Evenings">Evenings Only</option>
                      <option value="Project Based">Project Based (Occasional)</option>
                    </select>
                    <p v-if="form.errors.availability" class="mt-1 text-xs text-red-500">{{ form.errors.availability }}</p>
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-3">Your Skills & Expertise</label>
                  <p class="text-xs text-gray-500 mb-4">Select all areas where you can contribute.</p>
                  
                  <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <label v-for="skill in predefinedSkills" :key="skill" class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors" :class="{'bg-blue-50 border-blue-200': form.skills.includes(skill)}">
                      <input type="checkbox" :value="skill" v-model="form.skills" class="h-4 w-4 text-ngo-blue focus:ring-ngo-blue border-gray-300 rounded">
                      <span class="ml-2 text-sm text-gray-700 font-medium select-none">{{ skill }}</span>
                    </label>
                  </div>
                  <p v-if="form.errors.skills" class="mt-2 text-xs text-red-500">{{ form.errors.skills }}</p>
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-700">Profile Photo (Optional)</label>
                  <div class="mt-2 flex items-center">
                    <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200 mr-4">
                      <img v-if="imagePreview" :src="imagePreview" class="h-full w-full object-cover">
                      <svg v-else class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input 
                      type="file" 
                      @input="handleImageUpload" 
                      accept="image/*"
                      class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-ngo-blue hover:file:bg-blue-100 transition-colors cursor-pointer"
                    >
                  </div>
                  <p v-if="form.errors.image" class="mt-2 text-xs text-red-500">{{ form.errors.image }}</p>
                </div>

                <div class="pt-4">
                  <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="w-full inline-flex justify-center items-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-ngo-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-blue shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none transition-all duration-200"
                  >
                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    {{ form.processing ? 'Submitting Application...' : 'Submit Application' }}
                  </button>
                </div>

              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const isLoggedIn = computed(() => !!user.value);
const successMessage = computed(() => page.props.flash?.message);

const predefinedSkills = [
  'Medical / First Aid',
  'Teaching / Education',
  'IT / Tech Support',
  'Logistics / Driving',
  'Event Planning',
  'Fundraising',
  'Marketing / Social Media',
  'Translation',
  'Manual Labor'
];

const imagePreview = ref(null);

const form = useForm({
  name: user.value ? user.value.name : '',
  email: user.value ? user.value.email : '',
  phone: user.value?.phone || '', 
  availability: '',
  skills: [], // Initializes as an empty array for the checkboxes!
  image: null
});

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  form.image = file;
  
  // Create a quick local preview of the image
  if (file) {
    imagePreview.value = URL.createObjectURL(file);
  } else {
    imagePreview.value = null;
  }
};

const submitForm = () => {
  form.post('/volunteer', {
    preserveScroll: true,
  });
};
</script>