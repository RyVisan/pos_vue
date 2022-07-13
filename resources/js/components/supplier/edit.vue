<template>
    <div>
        <!-- <div class="row"> -->
        <router-link to="/supplier" class="btn btn-primary">All Supplier</router-link>
        <!-- </div> -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-4">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Update Supplier</h1>
                                    </div>
                                    <form @submit.prevent="employeeUpdate" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" v-model="form.name" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Full Name">
                                                    <small class="text-danger" v-if="errors.name">{{ errors.name[0]
                                                    }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" v-model="form.email" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Email">
                                                    <small class="text-danger" v-if="errors.email">{{
                                                            errors.email[0]
                                                    }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" v-model="form.address" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Address">
                                                    <small class="text-danger" v-if="errors.address">{{
                                                            errors.address[0]
                                                    }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" v-model="form.shopname" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Shop Name">
                                                    <small class="text-danger" v-if="errors.shopname">{{
                                                            errors.shopname[0]
                                                    }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" v-model="form.phone" class="form-control"
                                                        id="exampleInputFirstName"
                                                        placeholder="Enter your phone Number">
                                                    <small class="text-danger" v-if="errors.phone">{{
                                                            errors.phone[0]
                                                    }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile"
                                                            @change="onFileSelected">
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.photo" style="width: 40px; height: 40px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: '/' })
        }
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                address: '',
                shopname: '',
                phone: '',
                photo: '',
                newphoto: '',
            },
            errors: {}
        }
    },
    created() {
        let id = this.$route.params.id
        axios.get('/api/supplier/' + id)
            .then(({ data }) => (this.form = data))
            .catch(console.log('error'))
    },
    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048576) {
                Notification.image_validation()
            } else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.newphoto = event.target.result
                };
                reader.readAsDataURL(file);
            }
        },
        employeeUpdate() {
            let id = this.$route.params.id
            axios.patch('/api/supplier/' + id, this.form)
                .then(() => {
                    this.$router.push({ name: 'supplier' })
                    Notification.success()
                })
                .catch(error => this.errors = error.response.data.errors)
        },
    }
}
</script>

<style>
</style>
