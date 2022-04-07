<template>
    <div class="relative py-6 md:py-14">  
        <image-component></image-component>
        <div class="relative container m-auto px-6 text-gray-500 md:px-12 xl:px-40">
            <div class="m-auto md:w-8/12 lg:w-4/12">
                <div class="rounded-xl bg-white shadow-xl border border-gray-200">
                    <div class="py-10 px-10 md:px-16">
                        <div class="space-y-4">
                            <h2 class="mb-8 text-2xl text-cyan-900 font-bold">Please sign up to <br>continue.</h2>
                        </div>
                        <div class="mt-8 grid">
                            <label for="username" >Firstname</label>
                            <input v-model="form.firstname" name="firstname" type="text" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter firstname...' />
                            <span v-if="errors.firstname" class="text-red-500">{{ errors.firstname[0] }}</span>

                            <label for="username" class="mt-4">Lastname</label>
                            <input v-model="form.lastname" name="lastname" type="text" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter lastname...' />
                            <span v-if="errors.lastname" class="text-red-500">{{ errors.lastname[0] }}</span>

                            <label for="email" class="mt-4">Email</label>
                            <input v-model="form.email" name="email" type="email" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter email...' />
                            <span v-if="errors.email" class="text-red-500">{{ errors.email[0] }}</span>

                            <label for="email" class="mt-4">Date of Birth</label>
                            <input v-model="form.dateOfBirth" name="dateOfBirth" type="date" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter email...' />
                            <span v-if="errors.dateOfBirth" class="text-red-500">{{ errors.dateOfBirth[0] }}</span>

                            <label for="password" class="mt-4">Password</label>
                            <input v-model="form.password" name="password" type="password" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter password...' />
                            <span v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</span>

                            <label for="cfmPassword" class="mt-4">Confirm Password</label>
                            <input v-model="form.password_confirmation" name="password_confirmation" type="password" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter confirmation password...' />
                            <span v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</span>

                            <div class="flex items-center justify-center mt-8">
                                <button @click.prevent="register" :disabled="submitting" type="submit" 
                                    class="py-2 px-4 bg-blue-800 w-32 text-white rounded">{{ submitting ? 'Signing up...' : 'Signup' }}</button>
                            </div>
                        </div>

                        <div class="mt-12 space-y-4 text-gray-600 text-center mb-2">
                            <p class="text-sm">Already have an account yet? <router-link :to="{path: '/'}" class="underline">Sign-in here</router-link>.</p>
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
            success: false,
            form: {
                firstname: '',
                lastname: '',
                email: '',
                dateOfBirth: '',
                password: '',
                password_confirmation: ''
            },
            errors:[]
        }
    },
    methods: {
        async register(){

            this.submitting = true;

            await axios.post('/api/register', this.form)
            .then((res) => {

                alert('Registered successfully!');

                if(res.status === 200 && res.statusText === 'OK'){

                    this.$router.push({path: '/'});
                }
            })
            .catch((error) => {

                this.submitting = false;
                this.errors = error.response.data.errors;
            })
        }
    },
}
</script>