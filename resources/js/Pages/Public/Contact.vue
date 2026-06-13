<template>
  <Head title="Contact Us" />

  <PublicLayout>
    <!-- Header Section -->
    <div class="bg-ngo-blue py-16 sm:py-24">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-white tracking-tight sm:text-5xl">Get in Touch</h1>
        <p class="mt-4 text-xl text-blue-100 max-w-2xl mx-auto">
          Whether you have a question about volunteering, donations, or our projects, our team is here to help.
        </p>
      </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-50 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
          
          <!-- Left Column: Form -->
          <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sm:p-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
            
            <div v-if="successMessage" class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center">
              <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              {{ successMessage }}
            </div>

            <form @submit.prevent="submitForm" class="space-y-6">
              
              <!-- Smart Fields (Disabled if logged in) -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Full Name</label>
                  <input 
                    v-model="form.name" 
                    type="text" 
                    :disabled="isLoggedIn"
                    :class="['mt-1 block w-full rounded-lg shadow-sm sm:text-sm px-4 py-3', isLoggedIn ? 'bg-gray-100 border-transparent text-gray-500 cursor-not-allowed' : 'border-gray-300 focus:ring-ngo-blue focus:border-ngo-blue bg-white text-gray-900']"
                  >
                  <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</p>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Email Address</label>
                  <input 
                    v-model="form.email" 
                    type="email" 
                    :disabled="isLoggedIn"
                    :class="['mt-1 block w-full rounded-lg shadow-sm sm:text-sm px-4 py-3', isLoggedIn ? 'bg-gray-100 border-transparent text-gray-500 cursor-not-allowed' : 'border-gray-300 focus:ring-ngo-blue focus:border-ngo-blue bg-white text-gray-900']"
                  >
                  <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Phone Number (Optional)</label>
                  <input 
                    v-model="form.phone" 
                    type="text" 
                    :disabled="isLoggedIn && !!form.phone"
                    :class="['mt-1 block w-full rounded-lg shadow-sm sm:text-sm px-4 py-3', (isLoggedIn && !!form.phone) ? 'bg-gray-100 border-transparent text-gray-500 cursor-not-allowed' : 'border-gray-300 focus:ring-ngo-blue focus:border-ngo-blue bg-white text-gray-900']"
                  >
                  <p v-if="form.errors.phone" class="mt-1 text-xs text-red-500">{{ form.errors.phone }}</p>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Request Type</label>
                  <select v-model="form.request_type" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-ngo-blue focus:border-ngo-blue bg-white text-gray-900 sm:text-sm px-4 py-3">
                    <option value="" disabled>Select an option...</option>
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Donation Support">Donation Support</option>
                    <option value="Volunteer Opportunities">Volunteer Opportunities</option>
                    <option value="Partnership / Sponsorship">Partnership / Sponsorship</option>
                    <option value="Report an Issue">Report an Issue</option>
                  </select>
                  <p v-if="form.errors.request_type" class="mt-1 text-xs text-red-500">{{ form.errors.request_type }}</p>
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700">Your Message</label>
                <textarea 
                  v-model="form.message" 
                  rows="5" 
                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-ngo-blue focus:border-ngo-blue bg-white text-gray-900 sm:text-sm px-4 py-3 resize-none"
                  placeholder="How can we help you today?"
                ></textarea>
                <p v-if="form.errors.message" class="mt-1 text-xs text-red-500">{{ form.errors.message }}</p>
              </div>

              <!-- Basic Bot Protection Checkbox (Simulated reCAPTCHA UI) -->
              <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-center shadow-inner max-w-sm">
                <input 
                  id="bot_check" 
                  v-model="form.bot_check" 
                  type="checkbox" 
                  class="h-6 w-6 text-ngo-blue focus:ring-ngo-blue border-gray-300 rounded cursor-pointer transition duration-200"
                >
                <label for="bot_check" class="ml-3 block text-sm font-bold text-gray-700 cursor-pointer select-none flex-grow">
                  I'm not a bot
                </label>
                <!-- Fake recaptcha logo for UI purposes -->
                <div class="flex flex-col items-center ml-4 opacity-70">
                  <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z"/></svg>
                  <span class="text-[8px] text-gray-500 mt-1">reCAPTCHA</span>
                </div>
              </div>
              <p v-if="form.errors.bot_check" class="text-xs text-red-500 mt-1">Please verify you are human.</p>

              <div>
                <button 
                  type="submit" 
                  :disabled="form.processing"
                  class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-ngo-orange hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-orange shadow-md disabled:opacity-50 transition-colors"
                >
                  <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                  {{ form.processing ? 'Sending...' : 'Send Message' }}
                </button>
              </div>

            </form>
          </div>

          <!-- Right Column: Addresses -->
          <div class="lg:col-span-5 space-y-8">
            
            <!-- Global Headquarters -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
              <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-ngo-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Global Headquarters
              </h3>
              <p class="text-gray-600 mb-2">123 Impact Avenue, Suite 400<br>New York, NY 10001<br>United States</p>
              <div class="text-sm text-gray-500 space-y-1 mt-4">
                <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                <p><strong>Email:</strong> contact@ngo-org.com</p>
                <p><strong>Hours:</strong> Mon-Fri, 9am - 5pm EST</p>
              </div>
            </div>

            <!-- Regional Office: Africa -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
              <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-ngo-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                East Africa Hub
              </h3>
              <p class="text-gray-600 mb-2">45 Innovation Road, Westlands<br>Nairobi, 00800<br>Kenya</p>
              <div class="text-sm text-gray-500 space-y-1 mt-4">
                <p><strong>Phone:</strong> +254 20 123 4567</p>
                <p><strong>Email:</strong> africa@ngo-org.com</p>
              </div>
            </div>

             <!-- Regional Office: Asia -->
             <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
              <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-ngo-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                South Asia Hub
              </h3>
              <p class="text-gray-600 mb-2">Level 4, Tech Park<br>Mumbai, MH 400001<br>India</p>
              <div class="text-sm text-gray-500 space-y-1 mt-4">
                <p><strong>Phone:</strong> +91 22 1234 5678</p>
                <p><strong>Email:</strong> asia@ngo-org.com</p>
              </div>
            </div>

          </div>

        </div>

        <!-- FAQs Section -->
        <div class="mt-24 max-w-4xl mx-auto">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Frequently Asked Questions</h2>
            <p class="mt-4 text-gray-500">Can't find the answer you're looking for? Reach out to our customer support team.</p>
          </div>

          <div class="space-y-6">
            <!-- FAQ 1 -->
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
              <h4 class="text-lg font-bold text-gray-900">How can I become a volunteer?</h4>
              <p class="mt-2 text-gray-600">You can easily sign up by visiting our Volunteer page. Once registered, you can browse available opportunities based on your skills and location, or contact us using the form above by selecting "Volunteer Opportunities".</p>
            </div>
            <!-- FAQ 2 -->
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
              <h4 class="text-lg font-bold text-gray-900">Are my donations tax-deductible?</h4>
              <p class="mt-2 text-gray-600">Yes! We are a registered 501(c)(3) non-profit organization. All donations made through our platform will generate an automated tax receipt sent directly to your registered email address.</p>
            </div>
            <!-- FAQ 3 -->
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
              <h4 class="text-lg font-bold text-gray-900">How do I cancel my recurring monthly donation?</h4>
              <p class="mt-2 text-gray-600">If you have an account, you can manage your subscriptions directly from your user dashboard. Alternatively, select "Donation Support" in the form above, and our finance team will process the cancellation within 24 hours.</p>
            </div>
            <!-- FAQ 4 -->
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
              <h4 class="text-lg font-bold text-gray-900">Can my company sponsor a specific cause?</h4>
              <p class="mt-2 text-gray-600">Absolutely. Corporate partnerships are vital to our impact. Please select "Partnership / Sponsorship" from the request type dropdown, and our Corporate Relations Manager will reach out to schedule a meeting.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

// Access the currently logged-in user from Inertia props
const page = usePage();
const user = computed(() => page.props.auth.user);
const isLoggedIn = computed(() => !!user.value);
const successMessage = computed(() => page.props.flash?.message);

// Initialize form
// If the user is logged in, auto-fill their data
const form = useForm({
  name: user.value ? user.value.name : '',
  email: user.value ? user.value.email : '',
  phone: user.value?.phone || '', 
  request_type: '',
  message: '',
  bot_check: false // Simulated ReCAPTCHA boolean
});

const submitForm = () => {
  form.post('/contact', {
    preserveScroll: true,
    onSuccess: () => {
      // Reset only the message, type, and checkbox so they don't have to retype name/email if they send another
      form.reset('message', 'request_type', 'bot_check');
    }
  });
};
</script>