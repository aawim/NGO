<template>
  <PublicLayout>
    <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:px-8 min-h-screen">
      <div class="max-w-3xl mx-auto">
        <div class="text-center mb-10">
          <h1 class="text-4xl font-extrabold text-ngo-blue">Make a Difference Today</h1>
          <p class="mt-4 text-lg text-gray-600">100% of your donation goes directly to funding our field projects.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-ngo-orange">
          <div class="p-8">
            <form @submit.prevent="submitDonation">
              
              <div class="flex justify-center mb-8 bg-gray-100 p-1 rounded-full">
                <button type="button" @click="form.type = 'one-time'" :class="form.type === 'one-time' ? 'bg-white shadow text-ngo-blue font-bold' : 'text-gray-500 hover:text-ngo-blue'" class="w-1/2 py-2 rounded-full transition">One-Time</button>
                <button type="button" @click="form.type = 'monthly'" :class="form.type === 'monthly' ? 'bg-white shadow text-ngo-blue font-bold' : 'text-gray-500 hover:text-ngo-blue'" class="w-1/2 py-2 rounded-full transition">Monthly</button>
              </div>

              <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <button v-for="amount in presetAmounts" :key="amount" type="button" 
                  @click="form.amount = amount"
                  :class="form.amount === amount ? 'bg-ngo-blue text-white border-ngo-blue' : 'bg-white text-gray-700 border-gray-300 hover:border-ngo-blue'"
                  class="border-2 rounded-xl py-4 text-xl font-bold transition flex items-center justify-center">
                  ${{ amount }}
                </button>
              </div>

              <div class="mb-8 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <span class="text-gray-500 text-xl font-bold">$</span>
                </div>
                <input v-model="form.amount" type="number" min="1" placeholder="Custom Amount" class="pl-10 w-full border-2 border-gray-300 rounded-xl py-4 text-xl font-bold text-gray-700 focus:outline-none focus:border-ngo-orange focus:ring-0 transition" />
              </div>

              <h3 class="text-lg font-bold text-ngo-blue mb-4 border-b pb-2">Your Details</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                  <input v-model="form.first_name" type="text" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-ngo-orange focus:ring-ngo-orange" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                  <input v-model="form.last_name" type="text" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-ngo-orange focus:ring-ngo-orange" />
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                  <input v-model="form.email" type="email" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-ngo-orange focus:ring-ngo-orange" />
                </div>
              </div>

              <button :disabled="form.processing || !form.amount" type="submit" class="w-full bg-ngo-orange hover:bg-orange-600 text-white font-bold py-4 rounded-xl text-xl shadow-lg transition disabled:opacity-50">
                <span v-if="form.processing">Processing...</span>
                <span v-else>Donate ${{ form.amount || '0' }}</span>
              </button>

              <p class="text-center text-xs text-gray-500 mt-4 flex items-center justify-center">
                <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                Secure payment encrypted by Stripe
              </p>
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

const presetAmounts = [25, 50, 100, 250];

const form = useForm({
  type: 'one-time',
  amount: 50,
  first_name: '',
  last_name: '',
  email: '',
  cause_id: null, // Can be populated if referred from a specific cause page
});

const submitDonation = () => {
  form.post('/donations/process'); // Submits to Laravel controller for Stripe/PayPal
};
</script>