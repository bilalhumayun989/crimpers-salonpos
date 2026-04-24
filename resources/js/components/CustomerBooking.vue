<template>
  <div class="min-h-screen bg-[#faf5ff] font-sans">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-purple-100 shadow-sm">
      <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-indigo-600">
          SalonMaster
        </h1>
        <div class="flex gap-4">
          <v-btn href="/login" variant="text" color="purple-darken-2" class="font-bold">Staff Login</v-btn>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-purple-900 text-white py-20 px-4 text-center relative overflow-hidden">
      <!-- Decorative circles -->
      <div class="absolute -top-24 -left-24 w-64 h-64 bg-purple-600 rounded-full blur-3xl opacity-50"></div>
      <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-indigo-600 rounded-full blur-3xl opacity-50"></div>
      
      <div class="relative z-10 max-w-2xl mx-auto">
        <h2 class="text-5xl font-extrabold mb-6">Book Your Appointment</h2>
        <p class="text-lg text-purple-200 mb-8">Premium salon services at your fingertips. No signup required.</p>
      </div>
    </div>

    <!-- Booking Section -->
    <div class="max-w-6xl mx-auto px-4 py-12 -mt-10 relative z-20">
      <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-8 border border-purple-50">
        
        <v-stepper v-model="step" class="elevation-0 bg-transparent" hide-actions>
          <v-stepper-header class="elevation-0 shadow-none">
            <v-stepper-item :complete="step > 1" value="1" color="purple">Select Service</v-stepper-item>
            <v-divider></v-divider>
            <v-stepper-item :complete="step > 2" value="2" color="purple">Your Details</v-stepper-item>
            <v-divider></v-divider>
            <v-stepper-item value="3" color="purple">Confirm</v-stepper-item>
          </v-stepper-header>

          <v-stepper-window>
            <!-- Step 1: Select Service -->
            <v-stepper-window-item value="1">
              <div class="py-6">
                <h3 class="text-xl font-bold text-center text-purple-900 mb-8">What would you like to book?</h3>
                
                <div v-for="category in categories" :key="category.id" class="mb-8">
                  <h4 class="text-lg font-bold text-slate-700 border-b border-purple-100 pb-2 mb-4">{{ category.name }}</h4>
                  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div 
                      v-for="service in category.services" 
                      :key="service.id"
                      class="border rounded-2xl p-4 cursor-pointer transition-all duration-300 transform hover:-translate-y-1"
                      :class="selectedService?.id === service.id ? 'border-purple-500 bg-purple-50 shadow-md ring-2 ring-purple-500 ring-opacity-50' : 'border-slate-200 hover:border-purple-300 hover:shadow-sm'"
                      @click="selectedService = service"
                    >
                      <div class="flex justify-between items-start mb-2">
                        <h5 class="font-bold text-slate-800">{{ service.name }}</h5>
                        <v-icon v-if="selectedService?.id === service.id" color="purple" icon="mdi-check-circle"></v-icon>
                      </div>
                      <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500"><v-icon size="small" icon="mdi-clock-outline" class="mr-1"></v-icon>{{ service.duration }} min</span>
                        <span class="font-bold text-purple-600">${{ parseFloat(service.price).toFixed(2) }}</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="flex justify-end mt-8">
                  <v-btn 
                    color="purple-darken-2" 
                    size="large" 
                    class="rounded-xl px-8" 
                    @click="step = 2"
                    :disabled="!selectedService"
                  >
                    Continue <v-icon icon="mdi-arrow-right" class="ml-2"></v-icon>
                  </v-btn>
                </div>
              </div>
            </v-stepper-window-item>

            <!-- Step 2: Details -->
            <v-stepper-window-item value="2">
              <div class="py-6 max-w-md mx-auto">
                <h3 class="text-xl font-bold text-center text-purple-900 mb-8">Enter your details</h3>
                
                <v-form ref="formRef" @submit.prevent="step = 3">
                  <v-text-field
                    v-model="customer.name"
                    label="Full Name"
                    variant="outlined"
                    color="purple"
                    :rules="[v => !!v || 'Name is required']"
                    class="mb-4"
                  ></v-text-field>

                  <v-text-field
                    v-model="customer.phone"
                    label="Phone Number"
                    variant="outlined"
                    color="purple"
                    :rules="[v => !!v || 'Phone number is required']"
                    class="mb-4"
                  ></v-text-field>

                  <v-text-field
                    v-model="customer.date"
                    label="Preferred Date & Time"
                    type="datetime-local"
                    variant="outlined"
                    color="purple"
                    :rules="[v => !!v || 'Date and time are required']"
                    class="mb-8"
                  ></v-text-field>

                  <div class="flex justify-between">
                    <v-btn variant="text" @click="step = 1">Back</v-btn>
                    <v-btn 
                      color="purple-darken-2" 
                      size="large" 
                      type="submit"
                      class="rounded-xl px-8"
                    >
                      Next Step <v-icon icon="mdi-arrow-right" class="ml-2"></v-icon>
                    </v-btn>
                  </div>
                </v-form>
              </div>
            </v-stepper-window-item>

            <!-- Step 3: Confirm -->
            <v-stepper-window-item value="3">
              <div class="py-6 max-w-md mx-auto text-center">
                <v-icon icon="mdi-calendar-check" color="purple" size="64" class="mb-4"></v-icon>
                <h3 class="text-2xl font-bold text-purple-900 mb-2">Confirm Booking</h3>
                <p class="text-slate-500 mb-8">Please review your booking details below.</p>
                
                <div class="bg-purple-50 rounded-2xl p-6 mb-8 text-left border border-purple-100">
                  <div class="mb-4">
                    <span class="text-xs font-bold text-purple-400 uppercase tracking-wider">Service</span>
                    <p class="text-lg font-bold text-slate-800">{{ selectedService?.name }}</p>
                    <p class="text-purple-600 font-bold">${{ parseFloat(selectedService?.price || 0).toFixed(2) }}</p>
                  </div>
                  <v-divider class="my-4"></v-divider>
                  <div>
                    <span class="text-xs font-bold text-purple-400 uppercase tracking-wider">Details</span>
                    <p class="font-medium text-slate-700">{{ customer.name }}</p>
                    <p class="text-slate-600">{{ customer.phone }}</p>
                    <p class="text-slate-600 mt-2">{{ formatDateTime(customer.date) }}</p>
                  </div>
                </div>

                <div class="flex justify-between">
                  <v-btn variant="text" @click="step = 2">Back</v-btn>
                  <v-btn 
                    color="green-darken-1" 
                    size="large" 
                    class="rounded-xl px-8 font-bold"
                    @click="submitBooking"
                    :loading="submitting"
                  >
                    Confirm Booking
                  </v-btn>
                </div>
              </div>
            </v-stepper-window-item>
          </v-stepper-window>
        </v-stepper>

        <!-- Success Message -->
        <div v-if="bookingSuccess" class="py-12 px-4 text-center">
           <v-icon icon="mdi-check-circle" color="green" size="80" class="mb-4"></v-icon>
           <h2 class="text-3xl font-bold text-slate-800 mb-2">Booking Confirmed!</h2>
           <p class="text-slate-500 mb-8">We've received your booking request. See you soon!</p>
           <v-btn color="purple-darken-2" variant="tonal" rounded="xl" @click="resetBooking">Book Another Service</v-btn>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  categories: {
    type: Array,
    required: true
  }
});

const step = ref(1);
const formRef = ref(null);
const selectedService = ref(null);
const submitting = ref(false);
const bookingSuccess = ref(false);

const customer = ref({
  name: '',
  phone: '',
  date: ''
});

const formatDateTime = (datetimeStr) => {
  if (!datetimeStr) return '';
  const date = new Date(datetimeStr);
  return date.toLocaleString('en-US', { 
    weekday: 'short', 
    month: 'short', 
    day: 'numeric', 
    hour: 'numeric', 
    minute: '2-digit'
  });
};

const submitBooking = async () => {
    submitting.value = true;
    try {
        // In a real app, send to API: 
        // await axios.post('/api/bookings', { service_id: selectedService.value.id, ...customer.value });
        
        // Simulating API call
        setTimeout(() => {
            submitting.value = false;
            bookingSuccess.value = true;
            step.value = 4; // Hide stepper
        }, 1000);
    } catch (e) {
        console.error(e);
        submitting.value = false;
        alert("There was an error processing your booking.");
    }
};

const resetBooking = () => {
    step.value = 1;
    selectedService.value = null;
    customer.value = { name: '', phone: '', date: '' };
    bookingSuccess.value = false;
};
</script>
