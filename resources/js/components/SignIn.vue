<template>
    <div class="relative py-16 ">  
        <image-component></image-component>
        <div class="relative container m-auto px-6 text-gray-500 md:px-12 xl:px-40">
            <div class="m-auto md:w-8/12 lg:w-4/12">
                <div class="rounded-xl bg-white shadow-xl border border-gray-200">
                    <div class="p-6 sm:p-16">
                        <div class="space-y-4">
                            <h2 class="mb-8 text-2xl text-cyan-900 font-bold">Please sign in to <br>continue.</h2>
                        </div>
                        <div class="mt-14 grid">
                            <label for="email" >Username</label>
                            <input v-model="form.email" name="email" type="email" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter email...' />
                            <span v-if="errors.email" class="text-red-500">{{ errors.email[0] }}</span>

                            <label for="password" class=" mt-4">Password</label>
                            <input v-model="form.password" type="password" name="password" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter password...' />
                            <span v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</span>

                            <div class="flex items-center justify-center mt-8">
                                <button @click.prevent="login" type="submit" :disabled="submitting"
                                class="py-2 px-4 bg-blue-800 w-32 text-white rounded">{{ submitting ? 'Signing in...' : 'Signin' }}</button>
                            </div>
                        </div>

                        <div class="mt-20 space-y-4 text-gray-600 text-center mb-2">
                            <p class="text-sm">Don't have an account yet? <router-link :to="{path: '/sign-up'}" class="underline">Sign-up here</router-link>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Image from './Image';

export default {
    components: {
        'image-component': Image
    },
    data() {
        return {
            submitting: false,
            form: {
                email: '',
                password: ''
            },
            errors:[]
        }
    },
    methods: {
        async login(){

            this.submitting = true;

            await axios.post('/api/login', this.form)
            .then((res) => {

                if(res.status === 200 && res.statusText === 'OK'){

                    this.$router.push({path: '/home'});
                }
            })
            .catch((error) => {
                this.submitting = false;
                console.log(error)
                this.errors = error.response.data.errors;
            })
        }
    },
}
</script>