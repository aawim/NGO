<script setup>
// import GuestLayout from '@/Layouts/GuestLayout.vue';
// import InputError from '@/Components/InputError.vue';
// import InputLabel from '@/Components/InputLabel.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
// import TextInput from '@/Components/TextInput.vue';
// import { Head, Link, useForm } from '@inertiajs/vue3';

import PublicLayout from '@/Layouts/PublicLayout.vue'; // Adjust path
import { useForm } from '@inertiajs/vue3';


const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
  <PublicLayout>
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border-t-4 border-ngo-green">
        
        <div class="text-center mb-8">
          <h2 class="text-3xl font-extrabold text-ngo-blue">Join Our Mission</h2>
          <p class="mt-2 text-sm text-gray-600">
            Create an account to track donations and volunteer.
          </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
          <!-- Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <div class="mt-1">
              <input v-model="form.name" id="name" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ngo-green focus:border-ngo-green sm:text-sm" />
              <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
            </div>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <div class="mt-1">
              <input v-model="form.email" id="email" type="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ngo-green focus:border-ngo-green sm:text-sm" />
              <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
            </div>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1">
              <input v-model="form.password" id="password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ngo-green focus:border-ngo-green sm:text-sm" />
              <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
            </div>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <div class="mt-1">
              <input v-model="form.password_confirmation" id="password_confirmation" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ngo-green focus:border-ngo-green sm:text-sm" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-2">
            <button :disabled="form.processing" type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-ngo-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-green transition disabled:opacity-50">
              <span v-if="form.processing">Creating Account...</span>
              <span v-else>Register</span>
            </button>
          </div>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
          Already have an account? 
          <a href="/login" class="font-medium text-ngo-blue hover:text-gray-800">Sign in</a>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
