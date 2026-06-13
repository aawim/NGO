<template>
  <div class="relative w-full h-[600px] lg:h-[700px] overflow-hidden bg-ngo-black group">
    
    <transition-group name="fade" tag="div" class="relative w-full h-full">
      <div 
        v-for="(slide, index) in slides" 
        :key="slide.id"
        v-show="currentSlide === index"
        class="absolute inset-0 w-full h-full"
      >
        <div 
          class="absolute inset-0 bg-cover bg-center transition-transform duration-10000 ease-linear scale-105"
          :style="{ backgroundImage: `url(${slide.image})` }"
        ></div>
        <div class="absolute inset-0 bg-gradient-to-r from-ngo-blue/90 via-ngo-blue/60 to-transparent"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-start text-left">
          <span v-if="slide.badge" class="inline-block py-1 px-3 rounded-full bg-ngo-green text-white text-sm font-bold tracking-wide uppercase mb-4 shadow-md">
            {{ slide.badge }}
          </span>
          <h2 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-4 max-w-2xl leading-tight">
            {{ slide.title }}
          </h2>
          <p class="text-lg md:text-xl text-gray-200 max-w-xl mb-8">
            {{ slide.description }}
          </p>
          <div class="flex flex-wrap gap-4">
            <a :href="slide.primary_link" class="bg-ngo-orange hover:bg-orange-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg transition transform hover:-translate-y-1">
              {{ slide.primary_cta }}
            </a>
            <a v-if="slide.secondary_cta" :href="slide.secondary_link" class="bg-transparent border-2 border-white hover:bg-white hover:text-ngo-blue text-white px-8 py-4 rounded-full font-bold text-lg transition">
              {{ slide.secondary_cta }}
            </a>
          </div>
        </div>
      </div>
    </transition-group>

    <button @click="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-black/30 hover:bg-ngo-orange text-white rounded-full transition opacity-0 group-hover:opacity-100 focus:opacity-100 hidden sm:block">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    <button @click="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-black/30 hover:bg-ngo-orange text-white rounded-full transition opacity-0 group-hover:opacity-100 focus:opacity-100 hidden sm:block">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>

    <div class="absolute bottom-6 left-0 right-0 z-20 flex justify-center space-x-3">
      <button 
        v-for="(_, index) in slides" 
        :key="index"
        @click="goToSlide(index)"
        :class="['w-3 h-3 rounded-full transition-all duration-300', currentSlide === index ? 'bg-ngo-orange w-8' : 'bg-white/50 hover:bg-white']"
        :aria-label="'Go to slide ' + (index + 1)"
      ></button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// Carousel State
const currentSlide = ref(0);
let autoPlayInterval = null;

// Mock Slide Data (In a real app, this might come from Laravel via Inertia props)
const slides = ref([
  {
    id: 1,
    badge: 'Urgent Appeal',
    title: 'Clean Water for Every Village.',
    description: 'Millions lack access to safe drinking water. Your contribution can build a well that changes a community forever.',
    image: 'https://images.unsplash.com/photo-1538301252192-31121d5a7d97?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80',
    primary_cta: 'Donate Now',
    primary_link: '/donate',
    secondary_cta: 'Learn More',
    secondary_link: '/causes/clean-water'
  },
  {
    id: 2,
    badge: 'Disaster Relief',
    title: 'Rebuilding Lives After the Flood.',
    description: 'Emergency response teams are on the ground right now. We need your help to deliver food, medicine, and shelter.',
    image: 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80',
    primary_cta: 'Send Relief',
    primary_link: '/donate',
    secondary_cta: '',
    secondary_link: ''
  },
  {
    id: 3,
    badge: 'Get Involved',
    title: 'Become a Volunteer Today.',
    description: 'Money isn\'t the only way to help. By donating your time and skills, you become the heartbeat of our operations.',
    image: 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80',
    primary_cta: 'Join the Team',
    primary_link: '/volunteer',
    secondary_cta: 'View Events',
    secondary_link: '/events'
  }
]);

// Methods
const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.value.length;
  resetInterval();
};

const prevSlide = () => {
  currentSlide.value = currentSlide.value === 0 ? slides.value.length - 1 : currentSlide.value - 1;
  resetInterval();
};

const goToSlide = (index) => {
  currentSlide.value = index;
  resetInterval();
};

// Autoplay Logic
const startInterval = () => {
  autoPlayInterval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length;
  }, 6000); // Change slide every 6 seconds
};

const resetInterval = () => {
  clearInterval(autoPlayInterval);
  startInterval();
};

// Lifecycle Hooks
onMounted(() => {
  startInterval();
});

onUnmounted(() => {
  clearInterval(autoPlayInterval);
});
</script>

<style scoped>
/* Vue Transition Classes for a smooth fade effect */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s ease-in-out;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>