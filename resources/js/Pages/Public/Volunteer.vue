
<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useForm } from '@inertiajs/vue3';

const availableSkills = [
  'Event Management', 'Fundraising', 'Medical/First Aid', 
  'IT & Web Support', 'Teaching/Tutoring', 'Construction', 
  'Social Media', 'Logistics/Driving', 'Grant Writing'
];

const form = useForm({
  name: '',
  email: '',
  phone: '',
  skills: [], // Stores as JSON array for Laravel
  availability: ''
});

const submitApplication = () => {
  form.post('/volunteer/apply', {
    preserveScroll: true,
    onSuccess: () => alert('Application received! We will contact you soon.')
  });
};
</script>
<template>
  <PublicLayout>
    <div class="bg-ngo-blue py-20 min-h-screen">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
          <h1 class="text-4xl font-extrabold text-white">Join Our Volunteer Network</h1>
          <p class="mt-4 text-lg text-gray-300">We need your hands, your skills, and your passion. Sign up to get involved.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
          <form @submit.prevent="submitApplication" class="space-y-8">
            
            <div>
              <h3 class="text-xl font-bold text-ngo-blue mb-4 border-b pb-2">Personal Information</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Full Name</label>
                  <input v-model="form.name" type="text" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-ngo-green focus:border-ngo-green" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                  <input v-model="form.phone" type="tel" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-ngo-green focus:border-ngo-green" />
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700">Email Address</label>
                  <input v-model="form.email" type="email" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-ngo-green focus:border-ngo-green" />
                </div>
              </div>
            </div>

            <div>
              <h3 class="text-xl font-bold text-ngo-blue mb-4 border-b pb-2">How can you help? (Select all that apply)</h3>
              <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <label v-for="skill in availableSkills" :key="skill" class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                  <input type="checkbox" :value="skill" v-model="form.skills" class="h-5 w-5 text-ngo-green focus:ring-ngo-green border-gray-300 rounded" />
                  <span class="text-gray-700 font-medium">{{ skill }}</span>
                </label>
              </div>
            </div>

            <div>
              <h3 class="text-xl font-bold text-ngo-blue mb-4 border-b pb-2">Availability</h3>
              <select v-model="form.availability" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-ngo-green focus:border-ngo-green">
                <option value="" disabled>Select your general availability...</option>
                <option value="weekdays">Weekdays (Mon-Fri)</option>
                <option value="weekends">Weekends Only</option>
                <option value="evenings">Evenings</option>
                <option value="flexible">Flexible / Remote</option>
              </select>
            </div>

            <button :disabled="form.processing" type="submit" class="w-full bg-ngo-green hover:bg-green-700 text-white font-bold py-4 rounded-xl text-xl shadow-lg transition disabled:opacity-50">
              <span v-if="form.processing">Submitting...</span>
              <span v-else>Submit Application</span>
            </button>

          </form>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>

