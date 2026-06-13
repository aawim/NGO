<template>
  <Head title="Upcoming Events" />
  
  <PublicLayout>
    <div class="bg-gray-50 py-16 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
          <h1 class="text-4xl font-extrabold text-ngo-blue">Upcoming Events</h1>
          <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">Join us at our upcoming gatherings, fundraisers, and community programs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-if="events.length === 0" class="col-span-full text-center py-12 text-gray-500">
            No upcoming events scheduled. Check back soon!
          </div>

          <div v-for="event in events" :key="event.id" class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden flex flex-col">
            <div class="h-56 relative group">
              <img :src="getImageUrl(event.image)" :alt="event.title" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
              <div class="absolute inset-0 bg-ngo-blue opacity-0 group-hover:opacity-20 transition duration-300"></div>
              
              <div class="absolute top-4 left-4 bg-white text-center rounded-xl overflow-hidden shadow-md w-16">
                <div class="bg-ngo-blue text-white text-xs font-bold py-1 uppercase tracking-wider">
                  {{ getMonth(event.event_date) }}
                </div>
                <div class="text-gray-900 font-extrabold text-2xl py-2">
                  {{ getDay(event.event_date) }}
                </div>
              </div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
              <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ event.title }}</h2>
              
              <div class="text-sm font-medium text-gray-500 mb-4 space-y-2">
                <p class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-ngo-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                  {{ formatTime(event.event_date) }}
                </p>
                <p class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-ngo-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                  <span class="truncate">{{ event.location || 'Location TBA' }}</span>
                </p>
              </div>

              <p class="text-gray-600 mb-6 line-clamp-3 text-sm" v-html="stripHtml(event.description)"></p>
              
              <div class="mt-auto">
                <Link :href="`/events/${event.id}`" class="inline-block w-full text-center bg-gray-100 hover:bg-ngo-blue hover:text-white text-ngo-blue font-bold py-3 rounded-xl transition">
                  Event Details
                </Link>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
  events: { type: Array, required: true, default: () => [] }
});

const getImageUrl = (path) => {
  if (!path) return 'https://via.placeholder.com/800x600?text=Event+Image';
  if (path.startsWith('http')) return path;
  return `/storage/${path}`;
};

// Date Helpers for the Calendar Badge
const getMonth = (dateString) => {
  if (!dateString) return 'TBA';
  return new Date(dateString).toLocaleDateString('en-US', { month: 'short' });
};
const getDay = (dateString) => {
  if (!dateString) return '-';
  return new Date(dateString).toLocaleDateString('en-US', { day: 'numeric' });
};
const formatTime = (dateString) => {
  if (!dateString) return 'Time TBA';
  return new Date(dateString).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
};

const stripHtml = (html) => {
  if (!html) return '';
  const doc = new DOMParser().parseFromString(html, 'text/html');
  return doc.body.textContent || "";
};
</script>