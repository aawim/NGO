<script setup>
// import Checkbox from '@/Components/Checkbox.vue';
// import GuestLayout from '@/Layouts/GuestLayout.vue';
// import InputError from '@/Components/InputError.vue';
// import InputLabel from '@/Components/InputLabel.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
// import TextInput from '@/Components/TextInput.vue';
// import { Head, Link, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue'; // Adjust path
import { useForm } from '@inertiajs/vue3';
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <PublicLayout>
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border-t-4 border-ngo-blue">
        
        <div class="text-center mb-8">
          <h2 class="text-3xl font-extrabold text-ngo-blue">Welcome Back</h2>
          <p class="mt-2 text-sm text-gray-600">
            Sign in to manage your donations or volunteer profile.
          </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <div class="mt-1">
              <input v-model="form.email" id="email" type="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ngo-blue focus:border-ngo-blue sm:text-sm" />
              <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
            </div>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1">
              <input v-model="form.password" id="password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-ngo-blue focus:border-ngo-blue sm:text-sm" />
              <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
            </div>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input v-model="form.remember" id="remember-me" type="checkbox" class="h-4 w-4 text-ngo-blue focus:ring-ngo-blue border-gray-300 rounded" />
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>
            <div class="text-sm">
              <a href="/forgot-password" class="font-medium text-ngo-orange hover:text-orange-600">Forgot password?</a>
            </div>
          </div>

          <!-- Submit Button -->
          <div>
            <button :disabled="form.processing" type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-ngo-blue hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-blue transition disabled:opacity-50">
              <span v-if="form.processing">Signing in...</span>
              <span v-else>Sign In</span>
            </button>
          </div>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
          Don't have an account? 
          <a href="/register" class="font-medium text-ngo-green hover:text-green-600">Register here</a>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
