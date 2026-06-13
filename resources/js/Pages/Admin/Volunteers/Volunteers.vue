<template>

    <Head title="Manage Volunteers" />

    <AuthenticatedLayout>
        <div class="space-y-6">

            <!-- Top Bar: Search & Add Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="relative w-full sm:max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input v-model="searchQuery" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-ngo-blue focus:border-ngo-blue sm:text-sm transition-colors"
                        placeholder="Search volunteers by name, email, or skills...">
                </div>

                <button @click="openPanel('add')"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-ngo-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ngo-blue dark:focus:ring-offset-gray-900 transition-colors">
                    <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Add Volunteer
                </button>
            </div>

            <!-- Main Data Table -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Volunteer Info</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Contact</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Availability</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="volunteer in filteredVolunteers" :key="volunteer.id"
                                class="even:bg-gray-50 dark:even:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">

                                <!-- Info Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 flex-shrink-0 mr-3 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 flex justify-center items-center">
                                            <img v-if="volunteer.image" :src="`/storage/${volunteer.image}`" alt=""
                                                class="h-full w-full object-cover">
                                            <span v-else class="text-lg font-bold text-gray-400 dark:text-gray-500">
                                                {{ volunteer.name?.charAt(0)?.toUpperCase() || 'V' }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{
                                                volunteer.name }}</div>
                                            <div
                                                class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[150px]">
                                                {{ volunteer.skills || 'General Support' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Column -->
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 space-y-1">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <a :href="`mailto:${volunteer.email}`"
                                            class="hover:text-ngo-blue truncate max-w-[150px]">{{ volunteer.email }}</a>
                                    </div>
                                    <div v-if="volunteer.phone" class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        {{ volunteer.phone }}
                                    </div>
                                </td>

                                <!-- Availability Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        {{ volunteer.availability || 'Anytime' }}
                                    </span>
                                </td>

                                <!-- Status Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span :class="[
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        volunteer.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                                            volunteer.status === 'inactive' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                                                'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'
                                    ]">
                                        {{ volunteer.status ? volunteer.status.charAt(0).toUpperCase() +
                                            volunteer.status.slice(1) : 'Pending' }}
                                    </span>
                                </td>

                                <!-- Actions Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button @click="openDetail(volunteer)"
                                            class="text-gray-400 hover:text-ngo-blue transition-colors"
                                            title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button @click="openPanel('edit', volunteer)"
                                            class="text-gray-400 hover:text-ngo-orange transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button @click="confirmDelete(volunteer.id)"
                                            class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="filteredVolunteers.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No volunteers found matching your search.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Slide-over Panel (Add/Edit Form) -->
            <Teleport to="body">
                <transition enter-active-class="transition-opacity ease-linear duration-300"
                    enter-from-class="opacity-0" enter-to-class="opacity-100"
                    leave-active-class="transition-opacity ease-linear duration-300" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-show="isPanelOpen" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm"
                        @click="closePanel"></div>
                </transition>

                <transition enter-active-class="transition ease-in-out duration-500 transform"
                    enter-from-class="translate-x-full" enter-to-class="translate-x-0"
                    leave-active-class="transition ease-in-out duration-500 transform" leave-from-class="translate-x-0"
                    leave-to-class="translate-x-full">
                    <div v-show="isPanelOpen" class="fixed inset-y-0 right-0 z-50 flex pointer-events-none pl-10">
                        <div
                            class="pointer-events-auto h-full w-screen max-w-md bg-white dark:bg-[#1e1e1e] shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col overflow-y-scroll custom-scrollbar transition-[max-width] duration-300 ease-in-out">

                            <!-- Header -->
                            <div class="bg-ngo-blue px-4 py-6 sm:px-6 shadow-md z-10 shrink-0">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white" id="slide-over-title">
                                        {{ isEditing ? 'Edit Volunteer' : 'Add New Volunteer' }}
                                    </h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button @click="closePanel"
                                            class="rounded-md text-blue-200 hover:text-white focus:outline-none transition-colors">
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Body -->
                            <div class="relative flex-1 px-4 py-6 sm:px-6">
                                <form class="space-y-6">
                                    <div
                                        class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg mb-6">
                                        <label
                                            class="block text-sm font-bold text-ngo-blue dark:text-blue-400 mb-1">Link
                                            to Registered Account (Optional)</label>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">If this volunteer has a
                                            user account on your website, link it here.</p>
                                        <select v-model="form.user_id"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-3 py-2 border transition-colors">
                                            <option :value="null">-- No Linked Account --</option>
                                            <option v-for="user in users" :key="user.id" :value="user.id">
                                                {{ user.name }} ({{ user.email }})
                                            </option>
                                        </select>
                                        <p v-if="form.errors.user_id" class="mt-1 text-xs text-red-500">{{
                                            form.errors.user_id }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full
                                            Name</label>
                                        <input v-model="form.name" type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-3 py-2 border transition-colors">
                                        <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name
                                        }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                            Address</label>
                                        <input v-model="form.email" type="email"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-3 py-2 border transition-colors">
                                        <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{
                                            form.errors.email }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone
                                            Number (Optional)</label>
                                        <input v-model="form.phone" type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-3 py-2 border transition-colors">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skills
                                            / Expertise</label>
                                        <input v-model="form.skills" type="text"
                                            placeholder="e.g. Teaching, Medical, Logistics..."
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-3 py-2 border transition-colors">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Availability</label>
                                            <select v-model="form.availability"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-3 py-2 border transition-colors">
                                                <option value="Anytime">Anytime</option>
                                                <option value="Weekdays">Weekdays</option>
                                                <option value="Weekends">Weekends</option>
                                                <option value="Evenings">Evenings</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                            <select v-model="form.status"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-ngo-blue focus:ring-ngo-blue sm:text-sm px-3 py-2 border transition-colors">
                                                <option value="pending">Pending</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile
                                            Image (Optional)</label>
                                        <input type="file" @input="form.image = $event.target.files[0]" accept="image/*"
                                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-ngo-blue file:text-white hover:file:bg-blue-700 transition-colors cursor-pointer">
                                    </div>


                                        <!-- <input 
                      type="file" 
                      @input="form.image = $event.target.files[0]"
                      accept="image/*"
                      class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-ngo-blue file:text-white hover:file:bg-blue-700 transition-colors cursor-pointer"
                    > -->


                                </form>
                            </div>

                            <!-- Footer -->
                            <div
                                class="shrink-0 border-t border-gray-200 dark:border-gray-800 px-4 py-4 sm:px-6 bg-gray-50 dark:bg-[#121212]">
                                <div class="flex justify-end space-x-3">
                                    <button @click="closePanel" type="button"
                                        class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                                        Cancel
                                    </button>
                                    <button @click="submitForm" :disabled="form.processing" type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-ngo-blue px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-ngo-blue focus:ring-offset-2 dark:focus:ring-offset-gray-900 disabled:opacity-50 transition-colors">
                                        {{ form.processing ? 'Saving...' : (isEditing ? 'Save Changes' : 'Add Volunteer') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </transition>
            </Teleport>

            <!-- View Details Modal -->
            <Teleport to="body">
                <transition enter-active-class="transition-opacity ease-out duration-300" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="transition-opacity ease-in duration-200"
                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <div v-show="isDetailModalOpen" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm"
                        @click="closeDetail"></div>
                </transition>

                <transition enter-active-class="transition ease-out duration-300 transform"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="transition ease-in duration-200 transform"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="isDetailModalOpen"
                        class="fixed inset-0 z-[70] z-50 flex items-center justify-center p-4 sm:p-6 pointer-events-none">
                        <div v-if="selectedVolunteer"
                            class="pointer-events-auto w-full max-w-md bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-2xl overflow-hidden flex flex-col">

                            <!-- Cover Header & Avatar -->
                            <div class="h-24 bg-ngo-blue relative">
                                <button @click="closeDetail"
                                    class="absolute top-4 right-4 text-white/80 hover:text-white focus:outline-none transition-colors z-10">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="px-6 pb-6 relative -mt-12">
                                <div class="flex justify-center mb-4">
                                    <div
                                        class="h-24 w-24 rounded-full border-4 border-white dark:border-[#1e1e1e] bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden shadow-sm">
                                        <img v-if="selectedVolunteer.image" :src="`/storage/${selectedVolunteer.image}`"
                                            class="h-full w-full object-cover">
                                        <span v-else class="text-4xl font-bold text-gray-400 dark:text-gray-500">
                                            {{ selectedVolunteer.name?.charAt(0)?.toUpperCase() || 'V' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-center mb-6">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{
                                        selectedVolunteer.name }}</h3>
                                    <p class="text-sm text-ngo-blue font-medium mt-1">{{ selectedVolunteer.skills ||
                                        'General Support' }}</p>

                                    <div class="mt-2 flex justify-center">
                                        <span :class="[
                                            'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
                                            selectedVolunteer.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                                                selectedVolunteer.status === 'inactive' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                                                    'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400'
                                        ]">
                                            {{ selectedVolunteer.status ?
                                                selectedVolunteer.status.charAt(0).toUpperCase() +
                                                selectedVolunteer.status.slice(1) : 'Pending' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-4 border-t border-gray-100 dark:border-gray-800 pt-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Email</p>
                                            <p class="text-sm text-gray-900 dark:text-white"><a
                                                    :href="`mailto:${selectedVolunteer.email}`"
                                                    class="hover:underline">{{ selectedVolunteer.email }}</a></p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Phone</p>
                                            <p class="text-sm text-gray-900 dark:text-white">{{ selectedVolunteer.phone
                                                || 'Not provided' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Availability
                                            </p>
                                            <p class="text-sm text-gray-900 dark:text-white">{{
                                                selectedVolunteer.availability || 'Anytime' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="selectedVolunteer?.user" class="mt-3 flex justify-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        Linked to User Account
                                    </span>
                                </div>
                            </div>

                            <div
                                class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 flex justify-end space-x-3 border-t border-gray-100 dark:border-gray-800">
                                <button @click="closeDetail"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    Close
                                </button>
                                <button @click="closeDetail(); openPanel('edit', selectedVolunteer)"
                                    class="px-4 py-2 text-sm font-medium text-white bg-ngo-blue hover:bg-blue-700 rounded-md shadow-sm transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Data
                                </button>
                            </div>

                        </div>
                    </div>
                </transition>
            </Teleport>

            <!-- Delete Confirmation Modal -->
            <ConfirmDeleteModal :show="isDeleteModalOpen" title="Delete Volunteer"
                message="Are you sure you want to remove this volunteer from the database? This action cannot be undone."
                :processing="isDeleting" @close="isDeleteModalOpen = false" @confirm="executeDelete" />

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import ConfirmDeleteModal from '@/Components/ConfirmDeleteModal.vue';

// --- Props from Laravel ---
const props = defineProps({
    volunteers: {
        type: [Array, Object],
        required: true,
        default: () => []
    },
    users: {
        type: Array,
        required: true,
        default: () => []
    },
    skills: {
        type: Array,
        required: true,
        default: () => []
    },
});

// --- State ---
const searchQuery = ref('');
const isPanelOpen = ref(false);
const isEditing = ref(false);

const isDetailModalOpen = ref(false);
const selectedVolunteer = ref(null);

const isDeleteModalOpen = ref(false);
const volunteerToDelete = ref(null);
const isDeleting = ref(false);

// --- Inertia Form ---
const form = useForm({
    id: null,
    user_id: null, // New field
    name: '',
    email: '',
    phone: '',
    skills: [],
    availability: 'Anytime',
    status: 'pending',
    image: null,
});

// --- Computed ---
const filteredVolunteers = computed(() => {
    const volArray = Array.isArray(props.volunteers) ? props.volunteers : (props.volunteers?.data || []);
    if (!searchQuery.value) return volArray;

    const query = searchQuery.value.toLowerCase();
    return volArray.filter(v =>
        (v?.name || '').toLowerCase().includes(query) ||
        (v?.email || '').toLowerCase().includes(query) ||
        (v?.skills || '').toLowerCase().includes(query)
    );
});

// --- Methods: Panel ---
const openPanel = (mode, data = null) => {
    if (mode === 'edit' && data) {
        isEditing.value = true;
        form.id = data.id;
        form.user_id = data.user_id; // Map this!
        form.name = data.name;
        form.email = data.email;
        form.phone = data.phone;
        form.skills = data.skills;
        form.availability = data.availability || 'Anytime';
        form.status = data.status || 'pending';
        form.image = data.image;
    } else {
        isEditing.value = false;
        form.reset();
    }
    isPanelOpen.value = true;
};

const closePanel = () => {
    isPanelOpen.value = false;
    setTimeout(() => {
        form.reset();
        form.clearErrors();
    }, 300);
};

// --- Methods: Form Submission ---
const submitForm = () => {
    if (isEditing.value) {
        // Spoof PUT request for file uploads
        form.transform((data) => ({
            ...data,
            _method: 'put',
        })).post(`/admin/volunteers/${form.id}`, {
            preserveScroll: true,
            onSuccess: () => closePanel(),
        });
    } else {
        form.post('/admin/volunteers', {
            preserveScroll: true,
            onSuccess: () => closePanel(),
        });
    }
};

// --- Methods: Details ---
const openDetail = (volunteer) => {
    selectedVolunteer.value = volunteer;
    isDetailModalOpen.value = true;
};

const closeDetail = () => {
    isDetailModalOpen.value = false;
    setTimeout(() => {
        selectedVolunteer.value = null;
    }, 300);
};

// --- Methods: Deletion ---
const confirmDelete = (id) => {
    volunteerToDelete.value = id;
    isDeleteModalOpen.value = true;
};

const executeDelete = () => {
    isDeleting.value = true;
    router.delete(`/admin/volunteers/${volunteerToDelete.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            isDeleteModalOpen.value = false;
            isDeleting.value = false;
            volunteerToDelete.value = null;
        },
        onError: () => {
            isDeleting.value = false;
        }
    });
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    height: 6px;
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.5);
    border-radius: 10px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(75, 85, 99, 0.5);
}
</style>