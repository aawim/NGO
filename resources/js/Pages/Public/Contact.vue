<template>
  <PublicLayout>
    <div class="bg-gray-50 py-16 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
          
          <div>
            <h1 class="text-4xl font-extrabold text-ngo-blue mb-6">Get in Touch</h1>
            <p class="text-lg text-gray-600 mb-10">Have questions about our causes, volunteering, or corporate partnerships? We would love to hear from you.</p>
            
            <div class="space-y-6">
              <div class="flex items-start">
                <div class="flex-shrink-0 bg-ngo-green rounded-full p-3 text-white">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-bold text-ngo-blue">Headquarters</h3>
                  <p class="text-gray-600">123 Charity Ave, Suite 100<br>New York, NY 10001</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="flex-shrink-0 bg-ngo-green rounded-full p-3 text-white">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-bold text-ngo-blue">Email Us</h3>
                  <p class="text-gray-600">contact@ourngo.org<br>support@ourngo.org</p>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 border-t-4 border-ngo-blue">
            <form @submit.prevent="submitContact" class="space-y-6">
              <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input v-model="form.name" type="text" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-ngo-blue focus:ring-ngo-blue" />
                <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="form.email" type="email" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-ngo-blue focus:ring-ngo-blue" />
                <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700">Message</label>
                <textarea v-model="form.message" rows="5" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-ngo-blue focus:ring-ngo-blue"></textarea>
                <div v-if="form.errors.message" class="text-red-500 text-xs mt-1">{{ form.errors.message }}</div>
              </div>

              <button :disabled="form.processing" type="submit" class="w-full bg-ngo-blue hover:bg-gray-800 text-white font-bold py-4 rounded-xl text-lg shadow transition disabled:opacity-50">
                <span v-if="form.processing">Sending...</span>
                <span v-else>Send Message</span>
              </button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  message: ''
});

const submitContact = () => {
  form.post('/contact', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      alert('Thank you for your message. We will get back to you shortly!');
    }
  });
};
</script>