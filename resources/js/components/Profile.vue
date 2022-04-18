<template>
    <div>
        <navigation-bar />

        
        <div class="px-4 md:px-32 container mx-auto mt-12 ">
            <div class='grid grid-cols-1 md:grid-cols-2 my-3 bg-white p-6 rounded shadow-lg border border-gray-200'>
                <div class="p-6">
                    <h1 class="font-bold text-gray-700 text-3xl">My Profile</h1>
                    <h3 class="text-semibold text-gray-600 text-lg mt-8">Email: {{this.email}}</h3>
                    <h3 class="text-semibold text-gray-600 text-lg mt-1">Firstname: {{this.firstname}}</h3>
                    <h3 class="text-semibold text-gray-600 text-lg mt-1">Lastname: {{this.lastname}}</h3>
                    <h3 class="text-semibold text-gray-600 text-lg mt-1">Birthdate: {{this.birthdate}}</h3>
                </div>
                <div class="">
                    <div class="py-10 px-10 md:px-16">
                        <div class="space-y-4">
                            <h2 class="mb-8 text-2xl text-cyan-900 font-bold">Please fill up the <br>fields to update.</h2>
                        </div>
                        <div class="mt-8 grid">
                            <label for="username" >Firstname</label>
                            <input v-model="form.firstname" name="firstname" type="text" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter firstname...' />
                            <span v-if="errors.firstname" class="text-red-500">{{ errors.firstname[0] }}</span>

                            <label for="username" class="mt-4">Lastname</label>
                            <input v-model="form.lastname" name="lastname" type="text" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter lastname...' />
                            <span v-if="errors.lastname" class="text-red-500">{{ errors.lastname[0] }}</span>

                            <label for="email" class="mt-4">Date of Birth</label>
                            <input v-model="form.dateOfBirth" name="dateOfBirth" type="date" class='border-2 border-blue-800 rounded py-2 px-4 outline-0' placeholder='Enter email...' />
                            <span v-if="errors.dateOfBirth" class="text-red-500">{{ errors.dateOfBirth[0] }}</span>

                            <div class="flex items-center justify-center mt-8">
                                <button @click.prevent="update" :disabled="submitting" type="submit" 
                                    class="py-2 px-4 bg-blue-800 w-32 text-white rounded">{{ submitting ? 'Updating...' : 'Update' }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Navbar from './Navbar.vue'

export default {
    components: {
        'navigation-bar': Navbar
    },
    data() {
        return {
            id: null,
            email: null,
            firstname: null,
            lastname: null,
            birthdate: null,
            submitting: false,
            form: {
                user_id: null,
                firstname: '',
                lastname: '',
                dateOfBirth: '',
            },
            errors:[]
        }
    },
    methods: {
        async getAuthenticatedUser(){
            await axios.get('/api/user')
            .then((res) => {

                this.id = res.data.id;
            })
            .catch((error) => {
                console.log(error)
                alert('Warning: Please contact the developer.')
            })
        },
        async getMyInfo(){

            await axios.post('/api/my-profile',{user_id: this.id})
            .then((res) => {
                console.log(res)
                this.form.user_id = res.data.info.id
                this.email = res.data.info.email;
                this.firstname = res.data.info.firstname
                this.lastname = res.data.info.lastname
                this.birthdate = res.data.info.birthdate
            })
            .catch((error) => {
                console.log(error)
                alert('Warning: Please contact the developer.')
            })
        },
        async update(){
            this.submitting = true;
            await axios.post('/api/update-my-profile', this.form)
            .then((res) => {
                
                if(res.status === 200 && res.statusText === 'OK')
                {
                    this.submitting = false;
                    alert('Profile updated.')
                    this.getMyInfo();
                }

                console.log(this.form)
            })
            .catch((error) => {
                console.log(error)
                this.submitting = false;
                this.errors = error.response.data.errors;
            })
        }
    },
    async created() {
        await this.getAuthenticatedUser();
        await this.getMyInfo();
    },
}
</script>