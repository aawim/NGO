<template>
    <PublicLayout>
  <div>
    <section class="relative bg-ngo-blue text-white py-20 lg:py-28 overflow-hidden">
      <div class="absolute inset-0 z-0 opacity-20">
        <svg class="absolute left-0 top-0 h-full w-full" preserveAspectRatio="xMidYMid slice" fill="none" viewBox="0 0 1463 800">
          <path class="text-gray-400" fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" />
          <path class="text-ngo-green opacity-40" fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" />
        </svg>
      </div>
      
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6">
          Who We Are
        </h1>
        <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto">
          We are a global community of volunteers, donors, and advocates dedicated to breaking the cycle of poverty and responding to crises where we are needed most.
        </p>
      </div>
    </section>

    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
          
          <div class="bg-gray-50 rounded-2xl p-10 border-t-4 border-ngo-orange shadow-sm hover:shadow-md transition">
            <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mb-6">
              <svg class="w-8 h-8 text-ngo-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-ngo-blue mb-4">Our Mission</h2>
            <p class="text-gray-600 leading-relaxed">
              To empower marginalized communities by providing sustainable access to education, clean water, and emergency relief. We believe that local action drives global change, and we work hand-in-hand with the communities we serve.
            </p>
          </div>

          <div class="bg-gray-50 rounded-2xl p-10 border-t-4 border-ngo-green shadow-sm hover:shadow-md transition">
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-6">
              <svg class="w-8 h-8 text-ngo-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-ngo-blue mb-4">Our Vision</h2>
            <p class="text-gray-600 leading-relaxed">
              A world where every individual, regardless of where they are born, has the resources and opportunity to thrive, live with dignity, and build a resilient future for the next generation.
            </p>
          </div>

        </div>
      </div>
    </section>

    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
          <div class="w-full lg:w-1/2">
            <div class="relative rounded-2xl overflow-hidden shadow-xl">
              <img src="https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Volunteers working together" class="w-full h-auto object-cover" />
              <div class="absolute inset-0 bg-ngo-blue opacity-10"></div>
            </div>
          </div>
          
          <div class="w-full lg:w-1/2">
            <h2 class="text-3xl font-bold text-ngo-black mb-6">How It All Started</h2>
            <div class="space-y-4 text-gray-600 text-lg leading-relaxed">
              <p>
                Founded in 2012 by a small group of passionate volunteers, our organization began with a simple belief: that no one should have to walk miles just to find clean drinking water.
              </p>
              <p>
                What started as a single well-drilling project in a rural village has since grown into a global movement. Over the past decade, we have expanded our reach to over 15 countries, shifting our focus to holistic community development encompassing education, healthcare, and disaster resilience.
              </p>
              <p>
                Today, thanks to the radical generosity of our donors, we are proud to have impacted the lives of over 85,000 people. But our work is far from finished.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-ngo-black mb-4">Meet Our Leadership</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Dedicated professionals bringing decades of experience in humanitarian aid, finance, and community development.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
          <div v-for="member in team" :key="member.id" class="text-center group">
            <div class="relative w-40 h-40 mx-auto mb-6 rounded-full overflow-hidden shadow-md group-hover:shadow-xl transition-shadow duration-300">
              <img :src="member.image" :alt="member.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
            </div>
            <h3 class="text-xl font-bold text-ngo-blue">{{ member.name }}</h3>
            <p class="text-ngo-orange font-medium text-sm mb-3">{{ member.role }}</p>
            <p class="text-gray-500 text-sm px-4">{{ member.bio }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-ngo-blue py-16">
      <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Be a Part of Our Story</h2>
        <p class="text-gray-300 text-lg mb-10">
          Whether you can give your time, your voice, or your financial support, you have the power to create lasting change.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a href="/donate" class="bg-ngo-orange hover:bg-orange-600 text-white px-8 py-3 rounded-full font-bold text-lg shadow-lg transition transform hover:-translate-y-1">
            Donate Today
          </a>
          <a href="/volunteer" class="bg-transparent border-2 border-ngo-green text-ngo-green hover:bg-ngo-green hover:text-white px-8 py-3 rounded-full font-bold text-lg transition">
            Join as a Volunteer
          </a>
        </div>
      </div>
    </section>

  </div>
   </PublicLayout>
</template>

<script setup>
import { ref } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue'; // Adjust path
// Mock data for the leadership team
// In a real application, you might fetch this from your Laravel backend (e.g., a 'Team' model)
const team = ref([
  {
    id: 1,
    name: 'Sarah Jenkins',
    role: 'Executive Director',
    bio: 'Sarah has 15+ years of experience leading international aid programs across Africa and Southeast Asia.',
    image: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60'
  },
  {
    id: 2,
    name: 'Marcus Chen',
    role: 'Head of Operations',
    bio: 'Former logistics specialist who ensures that our resources reach the frontlines efficiently and safely.',
    image: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60'
  },
  {
    id: 3,
    name: 'Dr. Amina Rossi',
    role: 'Director of Health Initiatives',
    bio: 'Amina oversees all medical relief programs, bringing her expertise from years working in crisis zones.',
    image: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60'
  },
  {
    id: 4,
    name: 'David Okafor',
    role: 'Community Outreach Lead',
    bio: 'David works directly with local leaders to ensure our projects are culturally respectful and sustainable.',
    image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60'
  }
]);
</script>