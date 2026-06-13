<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Carousel from '@/Components/HeroCarousel.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}


const impactStats = [
  { label: 'Funds Raised', value: '$2.4M' },
  { label: 'Active Projects', value: '42' },
  { label: 'Volunteers', value: '1,250' },
  { label: 'People Helped', value: '85k+' },
];

const featuredCauses = [
  {
    id: 1,
    title: 'Clean Water Initiative',
    slug: 'clean-water-initiative',
    description: 'Providing sustainable access to safe drinking water in drought-affected rural communities.',
    goal_amount: 50000,
    raised_amount: 32500,
    image: 'https://images.unsplash.com/photo-1538301252192-31121d5a7d97?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
  },
  {
    id: 2,
    title: 'Emergency Food Relief',
    slug: 'emergency-food-relief',
    description: 'Delivering urgent food supplies and nutritional support to families displaced by recent floods.',
    goal_amount: 25000,
    raised_amount: 22000,
    image: 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
  },
  {
    id: 3,
    title: 'Rural Education Fund',
    slug: 'rural-education-fund',
    description: 'Building classrooms and providing learning materials to children who have no access to schools.',
    goal_amount: 100000,
    raised_amount: 15000,
    image: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
  }
];

const upcomingEvents = [
  { id: 1, title: 'Annual Charity Gala', location: 'Grand Hotel, Downtown', month: 'Oct', day: '15' },
  { id: 2, title: 'Community Tree Planting', location: 'Westside City Park', month: 'Oct', day: '22' },
  { id: 3, title: 'Volunteer Training Session', location: 'NGO Headquarters', month: 'Nov', day: '05' },
];

// Helper method for progress bars
const calculateProgress = (raised, goal) => {
  if (goal === 0) return 0;
  const percentage = (raised / goal) * 100;
  return percentage > 100 ? 100 : Math.round(percentage);
};


</script>

<template>
    <PublicLayout>
<div>
    <section class="relative bg-ngo-blue text-white overflow-hidden">
      <div class="absolute inset-0 z-0 opacity-30 bg-cover bg-center" style="background-image: url('/images/hero-bg.jpg');"></div>
  
<Carousel/>

    </section>

    <section class="bg-white py-12 border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div v-for="stat in impactStats" :key="stat.label">
            <p class="text-4xl font-extrabold text-ngo-blue mb-2">{{ stat.value }}</p>
            <p class="text-gray-500 font-medium uppercase tracking-wide text-sm">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-ngo-black mb-4">Urgent Causes</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">Your immediate support can help us reach our goals and provide critical relief to these active campaigns.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="cause in featuredCauses" :key="cause.id" class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
            <div class="h-48 bg-gray-300 relative">
              <img :src="cause.image" :alt="cause.title" class="w-full h-full object-cover" />
              <div class="absolute top-4 right-4 bg-ngo-black text-white text-xs font-bold px-3 py-1 rounded-full">
                Urgent
              </div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
              <h3 class="text-xl font-bold text-ngo-blue mb-2">{{ cause.title }}</h3>
              <p class="text-gray-600 text-sm mb-6 line-clamp-3">{{ cause.description }}</p>
              
              <div class="mt-auto">
                <div class="flex justify-between text-sm font-medium mb-2">
                  <span class="text-ngo-green font-bold">${{ cause.raised_amount.toLocaleString() }}</span>
                  <span class="text-gray-500">of ${{ cause.goal_amount.toLocaleString() }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
                  <div class="bg-ngo-green h-2 rounded-full" :style="{ width: calculateProgress(cause.raised_amount, cause.goal_amount) + '%' }"></div>
                </div>
                
                <a :href="`/causes/${cause.slug}`" class="block w-full text-center border-2 border-ngo-orange text-ngo-orange hover:bg-ngo-orange hover:text-white font-bold py-3 rounded-xl transition">
                  Support This Cause
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        
        <div>
          <h2 class="text-3xl font-bold text-ngo-black mb-8">Upcoming Events</h2>
          <div class="space-y-6">
            <div v-for="event in upcomingEvents" :key="event.id" class="flex items-start space-x-4 p-4 border rounded-xl hover:border-ngo-blue transition group cursor-pointer">
              <div class="bg-ngo-blue text-white rounded-lg p-3 text-center min-w-[70px] group-hover:bg-ngo-orange transition">
                <p class="text-sm uppercase font-bold">{{ event.month }}</p>
                <p class="text-2xl font-extrabold">{{ event.day }}</p>
              </div>
              <div>
                <h4 class="text-lg font-bold text-ngo-black group-hover:text-ngo-orange transition">{{ event.title }}</h4>
                <p class="text-gray-500 text-sm flex items-center mt-1">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                  {{ event.location }}
                </p>
              </div>
            </div>
          </div>
          <a href="/events" class="inline-block mt-6 text-ngo-blue font-bold hover:text-ngo-orange transition">View all events &rarr;</a>
        </div>

        <div class="bg-ngo-blue rounded-3xl p-10 text-white relative overflow-hidden shadow-2xl">
          <div class="absolute -top-24 -right-24 w-64 h-64 bg-ngo-green opacity-20 rounded-full blur-3xl"></div>
          <h2 class="text-3xl font-bold mb-4 relative z-10">We Need Your Hands</h2>
          <p class="text-gray-300 mb-8 relative z-10 text-lg">
            Money isn't the only way to help. By donating your time and skills, you become the heartbeat of our on-the-ground operations. 
          </p>
          <ul class="space-y-3 mb-8 relative z-10">
            <li class="flex items-center"><svg class="w-5 h-5 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Flexible hours</li>
            <li class="flex items-center"><svg class="w-5 h-5 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Gain field experience</li>
            <li class="flex items-center"><svg class="w-5 h-5 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Certificate of appreciation</li>
          </ul>
          <a href="/volunteer" class="block w-full sm:w-auto text-center bg-white text-ngo-blue font-bold py-3 px-6 rounded-xl hover:bg-gray-100 transition relative z-10">
            Apply to Volunteer
          </a>
        </div>
        
      </div>
    </section>
  </div>

    </PublicLayout>
</template>
