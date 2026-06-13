<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Carousel from '@/Components/HeroCarousel.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    stats: { type: Object, default: () => ({}) },
    featuredCauses: { type: Array, default: () => [] },
    upcomingEvents: { type: Array, default: () => [] },
    latestNews: { type: Array, default: () => [] }, // New prop!
});

// Dynamically map the database stats
const impactStats = computed(() => [
  { label: 'Funds Raised', value: '$' + Number(props.stats?.total_raised || 0).toLocaleString() },
  { label: 'Active Projects', value: props.stats?.active_projects || '0' },
  { label: 'Volunteers', value: props.stats?.total_volunteers || '0' },
  { label: 'People Helped', value: '85k+' }, // Static placeholder for scale
]);

// Helper method for progress bars
const calculateProgress = (raised, goal) => {
  if (!goal || goal === 0) return 0;
  const percentage = (raised / goal) * 100;
  return percentage > 100 ? 100 : Math.round(percentage);
};

// Date formatters
const getMonth = (dateString) => {
  if (!dateString) return '';
  return new Date(dateString).toLocaleString('default', { month: 'short' }); 
};

const getDay = (dateString) => {
  if (!dateString) return '';
  return new Date(dateString).getDate().toString().padStart(2, '0'); 
};

// Strip HTML for news excerpts
const stripHtml = (html) => {
  if (!html) return '';
  return new DOMParser().parseFromString(html, 'text/html').body.textContent || "";
};
</script>

<template>
    <PublicLayout>
        <div>
            <!-- 1. Hero Section -->
            <section class="relative bg-ngo-blue text-white overflow-hidden">
                <div class="absolute inset-0 z-0 opacity-30 bg-cover bg-center" style="background-image: url('/images/hero-bg.jpg');"></div>
                <Carousel/>
            </section>

            <!-- 2. Impact Stats -->
            <section class="bg-white py-12 border-b border-gray-200 shadow-sm relative z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
                        <div v-for="stat in impactStats" :key="stat.label" class="px-4">
                            <p class="text-4xl font-extrabold text-ngo-blue mb-2">{{ stat.value }}</p>
                            <p class="text-gray-500 font-bold uppercase tracking-wider text-xs">{{ stat.label }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. About Us Snippet (New Layout Addition) -->
            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="relative rounded-2xl overflow-hidden shadow-xl aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Volunteers helping" class="object-cover w-full h-full">
                            <div class="absolute inset-0 bg-ngo-blue mix-blend-multiply opacity-20"></div>
                        </div>
                        <div class="lg:pl-8">
                            <h4 class="text-ngo-orange font-bold tracking-wider uppercase mb-2">Who We Are</h4>
                            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Building resilient communities, together.</h2>
                            <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                                World Vision Alliance is a global non-profit dedicated to providing immediate disaster relief, sustainable clean water solutions, and educational opportunities to the most vulnerable regions on earth.
                            </p>
                            <ul class="space-y-4 mb-8">
                                <li class="flex items-center text-gray-700 font-medium">
                                    <svg class="w-6 h-6 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    100% of public donations go straight to the field.
                                </li>
                                <li class="flex items-center text-gray-700 font-medium">
                                    <svg class="w-6 h-6 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Partnering with local leaders for sustainable impact.
                                </li>
                            </ul>
                            <a href="/about" class="inline-block bg-gray-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition shadow-md">
                                Learn More About Us
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. Urgent Causes (Real Data) -->
            <section class="py-24 bg-gray-50 border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                        <div class="max-w-2xl">
                            <h4 class="text-ngo-orange font-bold tracking-wider uppercase mb-2">How You Can Help</h4>
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Urgent Causes</h2>
                            <p class="text-gray-600">Your immediate support provides critical relief to these active campaigns.</p>
                        </div>
                        <a href="/causes" class="hidden md:inline-block text-ngo-blue font-bold hover:text-ngo-orange transition">View all causes &rarr;</a>
                    </div>

                    <div v-if="featuredCauses.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div v-for="cause in featuredCauses" :key="cause.id" class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group border border-gray-100">
                            <div class="h-56 bg-gray-300 relative overflow-hidden">
                                <img :src="cause.image ? `/storage/${cause.image}` : 'https://images.unsplash.com/photo-1538301252192-31121d5a7d97?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'" :alt="cause.title" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" />
                                <div class="absolute top-4 right-4 bg-ngo-black text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Urgent</div>
                            </div>
                            
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-ngo-blue transition">{{ cause.title }}</h3>
                                <p class="text-gray-600 text-sm mb-6 line-clamp-3">{{ cause.excerpt || cause.description || 'Help us make a difference by contributing to this cause.' }}</p>
                                
                                <div class="mt-auto">
                                    <div class="flex justify-between text-sm font-medium mb-2">
                                        <span class="text-ngo-green font-bold">${{ Number(cause.raised_amount || 0).toLocaleString() }}</span>
                                        <span class="text-gray-500">of ${{ Number(cause.goal_amount || 0).toLocaleString() }}</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2 mb-6 overflow-hidden">
                                        <div class="bg-ngo-green h-2 rounded-full" :style="{ width: calculateProgress(cause.raised_amount, cause.goal_amount) + '%' }"></div>
                                    </div>
                                    <a :href="`/causes/${cause.slug}`" class="block w-full text-center border-2 border-gray-200 text-gray-700 hover:border-ngo-orange hover:bg-ngo-orange hover:text-white font-bold py-3 rounded-xl transition">
                                        Support This Cause
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center text-gray-500 py-12 bg-white rounded-2xl border border-gray-200">
                        Currently, there are no urgent causes. Check back soon!
                    </div>
                    
                    <a href="/causes" class="md:hidden block text-center mt-8 text-ngo-blue font-bold hover:text-ngo-orange transition">View all causes &rarr;</a>
                </div>
            </section>

            <!-- 5. Events & Volunteer CTA (Preserved Design) -->
            <section class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    
                    <!-- Events -->
                    <div>
                        <h4 class="text-ngo-orange font-bold tracking-wider uppercase mb-2">Get Involved</h4>
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Upcoming Events</h2>
                        
                        <div v-if="upcomingEvents.length > 0" class="space-y-6">
                            <div v-for="event in upcomingEvents" :key="event.id" class="flex items-start space-x-4 p-4 border border-gray-100 rounded-xl hover:border-ngo-blue hover:shadow-md transition group cursor-pointer bg-gray-50 hover:bg-white">
                                <div class="bg-ngo-blue text-white rounded-lg p-3 text-center min-w-[75px] group-hover:bg-ngo-orange transition shadow-sm">
                                    <p class="text-sm uppercase font-bold">{{ getMonth(event.event_date) }}</p>
                                    <p class="text-2xl font-extrabold">{{ getDay(event.event_date) }}</p>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-ngo-orange transition">{{ event.title }}</h4>
                                    <p class="text-gray-500 text-sm flex items-center mt-2">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ event.location || 'Location TBA' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-gray-500 py-6 border border-dashed border-gray-300 rounded-xl text-center">
                            No upcoming events scheduled at this time.
                        </div>
                        <a href="/events" class="inline-block mt-8 text-ngo-blue font-bold hover:text-ngo-orange transition">View all events &rarr;</a>
                    </div>

                    <!-- Call to Action Card -->
                    <div class="bg-ngo-blue rounded-3xl p-10 sm:p-12 text-white relative overflow-hidden shadow-2xl">
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-ngo-green opacity-20 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 right-0 w-32 h-32 bg-ngo-orange opacity-20 rounded-tl-full blur-2xl"></div>
                        
                        <h2 class="text-3xl font-bold mb-4 relative z-10">We Need Your Hands</h2>
                        <p class="text-blue-100 mb-8 relative z-10 text-lg leading-relaxed">
                            Money isn't the only way to help. By donating your time and skills, you become the heartbeat of our on-the-ground operations. 
                        </p>
                        <ul class="space-y-4 mb-10 relative z-10">
                            <li class="flex items-center text-white font-medium"><svg class="w-6 h-6 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Flexible hours</li>
                            <li class="flex items-center text-white font-medium"><svg class="w-6 h-6 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Gain field experience</li>
                            <li class="flex items-center text-white font-medium"><svg class="w-6 h-6 text-ngo-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Certificate of appreciation</li>
                        </ul>
                        <a href="/volunteer" class="block w-full sm:w-auto text-center bg-white text-ngo-blue font-bold py-4 px-8 rounded-xl hover:bg-gray-100 shadow-lg transform hover:-translate-y-1 transition duration-200 relative z-10">
                            Apply to Volunteer
                        </a>
                    </div>
                    
                </div>
            </section>

            <!-- 6. Latest News (New Layout Addition) -->
            <section class="py-24 bg-gray-50 border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h4 class="text-ngo-orange font-bold tracking-wider uppercase mb-2">Our Impact</h4>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Latest News & Stories</h2>
                    </div>

                    <div v-if="latestNews.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <a v-for="story in latestNews" :key="story.id" :href="`/news-stories/${story.slug}`" class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group">
                            <div class="h-48 overflow-hidden bg-gray-200">
                                <img :src="story.featured_image ? `/storage/${story.featured_image}` : 'https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <span class="text-xs font-bold text-ngo-orange uppercase tracking-wider mb-2">{{ story.type.replace('_', ' ') }}</span>
                                <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-ngo-blue transition line-clamp-2">{{ story.title }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">{{ story.excerpt || stripHtml(story.content) }}</p>
                                <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100">
                                    <span class="text-xs text-gray-400 font-medium">{{ getMonth(story.published_at) }} {{ getDay(story.published_at) }}, {{ new Date(story.published_at).getFullYear() }}</span>
                                    <span class="text-ngo-blue font-bold text-sm group-hover:text-ngo-orange transition">Read More &rarr;</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-else class="text-center text-gray-500 py-6">
                        No news stories published yet.
                    </div>
                </div>
            </section>
            
        </div>
    </PublicLayout>
</template>