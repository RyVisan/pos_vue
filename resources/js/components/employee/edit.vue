<template>
    <div>
        <!-- <div class="row"> -->
        <router-link to="/employee" class="btn btn-primary">All Employee</router-link>
        <!-- </div> -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-4">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Update Employee</h1>
                                    </div>
                                    <form @submit.prevent="employeeInsert" enctype="multipart/form-data">
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
                                                    <input type="text" v-model="form.salary" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Salary">
                                                    <small class="text-danger" v-if="errors.salary">{{
                                                            errors.salary[0]
                                                    }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="date" v-model="form.joining_date" class="form-control"
                                                        id="exampleInputFirstName">
                                                    <small class="text-danger" v-if="errors.joining_date">{{
                                                            errors.joining_date[0]
                                                    }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" v-model="form.nid" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Nid">
                                                    <small class="text-danger" v-if="errors.nid">{{ errors.nid[0]
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
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
                name: null,
                email: null,
                address: null,
                salary: null,
                joining_date: null,
                nid: null,
                phone: null,
                photo: null,
            },
            errors: {}
        }
    },
    created() {
        let id = this.$route.params.id
        axios.get('/api/employee/' + id)
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
                    this.form.photo = event.target.result
                    console.log(event.target.result);
                };
                reader.readAsDataURL(file);
            }
        },
        employeeInsert() {
            axios.post('/api/employee', this.form)
                .then(() => {
                    this.$router.push({ name: 'employee' })
                    Notification.success()
                })
                .catch(error => this.errors = error.response.data.errors)
        },
    }
}
</script>

<style>
</style>
