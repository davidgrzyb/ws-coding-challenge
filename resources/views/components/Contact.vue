<template>
    <div>
        <header class="mx-auto max-w-lg">
            <a href="#">
                <h1 class="text-4xl font-semibold text-white text-center">Contact Us</h1>
            </a>
        </header>

        <main class="bg-white mx-auto max-w-lg p-8 md:p-12 mt-10 mb-6 rounded-lg shadow-2xl">
            <section class="text-center">
                <p class="text-gray-600 text-sm md:text-lg px-0 md:px-10">Leave your inquiry below and we will get back to you within 24 hours!</p>
            </section>

            <section v-if="errors" class="bg-red-400 text-white rounded p-4 mt-8">
                <p class="">Oops!</p>
                <ul class="mt-2">
                    <li v-for="error in errors" :key="error[0]">
                        {{ error[0] }}
                    </li>
                </ul>
            </section>

            <section class="mt-10">
                <form @submit.prevent="submitInquiry" class="flex flex-col mx-auto">
                    <div class="mb-6 pt-3 rounded bg-gray-200">
                        <label class="block text-gray-700 text-sm font-bold mb-2 mx-3" for="name">Name *</label>
                        <input
                            type="text"
                            id="name"
                            v-model="name"
                            :class="{ 'border-red-500' : this.errors && 'name' in this.errors }"
                            class="bg-gray-200 rounded appearance-none w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-600 transition duration-500 px-3 pb-3"
                        >
                    </div>
                    <div class="mb-6 pt-3 rounded bg-gray-200">
                        <label class="block text-gray-700 text-sm font-bold mb-2 mx-3" for="email">Email *</label>
                        <input
                            type="text"
                            id="email"
                            v-model="email"
                            :class="{ 'border-red-500' : this.errors && 'email' in this.errors }"
                            class="bg-gray-200 rounded appearance-none w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-600 transition duration-500 px-3 pb-3"
                        >
                    </div>
                    <div class="mb-6 pt-3 rounded bg-gray-200">
                        <label class="block text-gray-700 text-sm font-bold mb-2 mx-3" for="phone">Phone *</label>
                        <input 
                            type="text" 
                            id="phone" 
                            v-model="phone"
                            :class="{ 'border-red-500' : this.errors && 'phone' in this.errors }" 
                            class="bg-gray-200 rounded appearance-none w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-600 transition duration-500 px-3 pb-3"
                        >
                    </div>
                    <div class="mb-6 pt-3 rounded bg-gray-200">
                        <label class="block text-gray-700 text-sm font-bold mb-2 mx-3" for="message">Message *</label>
                        <textarea
                            type="text"
                            id="message"
                            v-model="message"
                            rows="5"
                            :class="{ 'border-red-500' : this.errors && 'message' in this.errors }"
                            class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-blue-600 transition duration-500 resize-none px-3 -mb-2"
                        ></textarea>
                    </div>
                    <p v-if="success" class="text-center text-green-600 font-bold mb-2">Your inquiry has been submitted successfully!</p>
                    <button :disabled="sending" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 mt-4 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Send Inquiry</button>
                </form>
            </section>
        </main>
    </div>
</template>

<script>
    export default {
        name: 'Contact',
        data() {
            return {
                'name': null,
                'email': null,
                'phone': null,
                'message': null,
                'success': false,
                'errors': null,
                'sending': false,
            }
        },
        methods: {
            submitInquiry() {
                this.sending = true;

                const xhr = new XMLHttpRequest();

                xhr.onload = () => {
                    if (xhr.status === 201) {
                        this.handleSuccessfulSubmit();
                    } else if (xhr.status === 422) {
                        const errors = JSON.parse(xhr.responseText).errors;
                        this.handleErrors(errors);
                    } else {
                        console.log('An unknown error has occurred.');
                    }
                }

                const payload = {
                    'name': this.name,
                    'email': this.email,
                    'phone': this.phone,
                    'message': this.message
                };

                xhr.open('POST', '/api/inquiry/create');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.send(JSON.stringify(payload));
            },
            handleSuccessfulSubmit() {
                this.success = true;
                this.name = this.email = this.phone = this.message = this.errors = null;
                this.sending = false;
            },
            handleErrors(errors) {
                this.errors = errors;
                this.success = this.sending = false;
            }
        }
    }
</script>