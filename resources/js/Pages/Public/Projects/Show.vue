
<script setup>
import { computed } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
  project: Object
});
const project = {
  id: 1,
  title: "Clean Water Well Installation",
  slug: "clean-water-well-installation",
  short_description: "Providing a sustainable source of clean drinking water to over 5,000 residents, reducing waterborne diseases by 80%.",
  description: "<p>This project aims to drill three deep-water wells and install solar-powered pumps...</p>",
  image: "https://rafsun.com",
  location: "Nairobi, Kenya",
  budget: 45000.00,
  raised_amount: 32500.00,
  status: "active",
  start_date: "2024-01-15",
  end_date: "2024-08-30",
  featured: true
};
// const project = 
//   {
//     id: 1,
//     title: "Clean Water Well Installation",
//     slug: "clean-water-well-installation",
//     short_description: "Providing a sustainable source of clean drinking water to over 5,000 residents, reducing waterborne diseases by 80%.",
//     description: "<p>This project aims to drill three deep-water wells and install solar-powered pumps...</p>",
//     image: "https://www.rafsun.com/wp-content/uploads/2025/12/How-to-Make-a-Well-Produce-More-Water-Increase-Well-Yield-with-RAFSUN-Submersible-Pumps.jpg",
//     location: "Nairobi, Kenya",
//     budget: 45000.00,
//     raised_amount: 32500.00,
//     status: "active",
//     start_date: "2024-01-15",
//     end_date: "2024-08-30",
//     featured: true
//   };


// const project = [
//   {
//     id: 1,
//     title: "Clean Water Well Installation",
//     slug: "clean-water-well-installation",
//     short_description: "Providing a sustainable source of clean drinking water to over 5,000 residents, reducing waterborne diseases by 80%.",
//     description: "<p>This project aims to drill three deep-water wells and install solar-powered pumps...</p>",
//     image: "https://www.rafsun.com/wp-content/uploads/2025/12/How-to-Make-a-Well-Produce-More-Water-Increase-Well-Yield-with-RAFSUN-Submersible-Pumps.jpg",
//     location: "Nairobi, Kenya",
//     budget: 45000.00,
//     raised_amount: 32500.00,
//     status: "active",
//     start_date: "2024-01-15",
//     end_date: "2024-08-30",
//     featured: true
//   },
//  {
//     id: 2,
//     title: "Rural School Rebuilding",
//     slug: "rural-school-rebuilding",
//     short_description: "Reconstructing a primary school destroyed by the earthquake, complete with 6 classrooms and a library.",
//     description: "<p>Education is the foundation of recovery. We are working with local contractors to build earthquake-resistant classrooms...</p>",
//     image: "https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80",
//     location: "Kathmandu, Nepal",
//     budget: 120000.00,
//     raised_amount: 120000.00,
//     status: "completed",
//     start_date: "2023-03-01",
//     end_date: "2023-11-15",
//     featured: false
//   },
//   {
//     id: 3,
//     title: "Emergency Medical Supply Drop",
//     slug: "emergency-medical-supply-drop",
//     short_description: "Delivering critical trauma kits, antibiotics, and surgical supplies to frontline medical clinics.",
//     description: "<p>Supply chains have broken down, leaving doctors without basic necessities. This project funds direct air-drops of medical gear...</p>",
//     image: "https://images.unsplash.com/photo-1584515933487-779824d29309?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80",
//     location: "Aleppo, Syria",
//     budget: 75000.00,
//     raised_amount: 15400.00,
//     status: "active",
//     start_date: "2024-05-01",
//     end_date: null,
//     featured: true
//   },
//   {
//     id: 4,
//     title: "Women's Agricultural Co-op",
//     slug: "womens-agricultural-co-op",
//     short_description: "Providing seeds, tools, and sustainable farming training to 50 women to establish a community food cooperative.",
//     description: "<p>By empowering women with agricultural independence, we secure food lines for the entire village...</p>",
//     image: "https://images.unsplash.com/photo-1595841696677-6489ff3f8cd1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80",
//     location: "Cusco, Peru",
//     budget: 15000.00,
//     raised_amount: 2500.00,
//     status: "draft",
//     start_date: "2024-09-01",
//     end_date: "2025-09-01",
//     featured: false
//   }
// ];

// const progressPercentage = computed(() => {
//   if (!props.project.budget || props.project.budget == 0) return 0;
//   let percent = (props.project.raised_amount / props.project.budget) * 100;
//   return percent > 100 ? 100 : Math.round(percent);
// });
</script>
<template>
  <PublicLayout>
    <div class="relative h-[50vh] bg-ngo-blue">
      <div class="absolute inset-0">
        <img :src="project.image" class="w-full h-full object-cover opacity-50" />
      </div>
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center px-4">
          <span class="bg-ngo-green text-white px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wider mb-4 inline-block">
            {{ project.status }}
          </span>
          <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4">{{ project.title }}</h1>
          <p class="text-xl text-gray-200 flex items-center justify-center">
             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            {{ project.location }}
          </p>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <div class="lg:col-span-2 prose prose-lg text-gray-600" v-html="project.description">
          </div>

        <div class="lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-ngo-orange sticky top-28">
            <h3 class="text-2xl font-bold text-ngo-blue mb-6">Project Funding</h3>
            
            <div class="mb-4">
              <div class="flex justify-between text-sm font-bold mb-2">
                <span class="text-ngo-green text-xl">${{ project.raised_amount }}</span>
                <span class="text-gray-500 mt-1">of ${{ project.budget }}</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-ngo-green h-3 rounded-full" :style="{ width: progressPercentage + '%' }"></div>
              </div>
            </div>

            <p class="text-sm text-gray-500 mb-8">{{ progressPercentage }}% funded. Every dollar helps us reach our goal faster.</p>
            
            <a :href="`/donate?project=${project.id}`" class="block w-full text-center bg-ngo-orange hover:bg-orange-600 text-white font-bold py-4 rounded-xl text-lg transition">
              Donate to this Project
            </a>
          </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>

