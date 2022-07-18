<template>
    <div>
        <!-- <div class="row"> -->
        <router-link to="/product" class="btn btn-primary">All Product</router-link>
        <!-- </div> -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-4">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                                    </div>
                                    <form @submit.prevent="employeeInsert" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="exampleFormControlSelect1">Product Name</label>
                                                    <input type="text" v-model="form.product_name" class="form-control"
                                                        id="exampleInputFirstName"
                                                        placeholder="Enter Your Product Name">
                                                    <small class="text-danger" v-if="errors.product_name">{{
                                                            errors.product_name[0]
                                                    }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="exampleFormControlSelect1">Product Code</label>
                                                    <input type="text" v-model="form.product_code" class="form-control"
                                                        id="exampleInputFirstName"
                                                        placeholder="Enter Your Product Code">
                                                    <small class="text-danger" v-if="errors.product_code">{{
                                                            errors.product_code[0]
                                                    }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="exampleFormControlSelect1">Product Category</label>
                                                    <select class="form-control" id="exampleFormControlSelect1"
                                                        v-model="form.category_id">
                                                        <option :value="category.id" v-for="category in categories">{{
                                                                category.category_name
                                                        }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="exampleFormControlSelect1">Product Supplier</label>
                                                    <select class="form-control" id="exampleFormControlSelect1"
                                                        v-model="form.supplier_id">
                                                        <option>1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label for="exampleFormControlSelect1">Product Root</label>
                                                    <input type="text" v-model="form.root" class="form-control"
                                                        id="exampleInputFirstName">
                                                    <small class="text-danger" v-if="errors.root">{{
                                                            errors.root[0]
                                                    }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="exampleFormControlSelect1">Buying Price</label>
                                                    <input type="text" v-model="form.buying_price" class="form-control"
                                                        id="exampleInputFirstName">
                                                    <small class="text-danger" v-if="errors.buying_price">{{
                                                            errors.buying_price[0]
                                                    }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="exampleFormControlSelect1">Selling Price</label>
                                                    <input type="text" v-model="form.selling_price" class="form-control"
                                                        id="exampleInputFirstName">
                                                    <small class="text-danger" v-if="errors.selling_price">{{
                                                            errors.selling_price[0]
                                                    }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="exampleFormControlSelect1">Buying Date</label>
                                                    <input type="date" v-model="form.buying_date" class="form-control"
                                                        id="exampleInputFirstName">
                                                    <small class="text-danger" v-if="errors.buying_date">{{
                                                            errors.buying_date[0]
                                                    }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="exampleFormControlSelect1">Product Quantity</label>
                                                    <input type="text" v-model="form.product_quantity"
                                                        class="form-control" id="exampleInputFirstName"
                                                        placeholder="Enter your Quantity">
                                                    <small class="text-danger" v-if="errors.product_quantity">{{
                                                            errors.product_quantity[0]
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
                                                        <small class="text-danger" v-if="errors.image">{{
                                                                errors.image[0]
                                                        }}</small>
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.image" style="width: 40px; height: 40px;">
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
                category_id: null,
                product_name: null,
                product_code: null,
                root: null,
                buying_price: null,
                selling_price: null,
                supplier_id: null,
                buying_date: null,
                image: null,
                product_quantity: null,
            },
            errors: {},
            categories: {},
            suppliers: {}
        }
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
                .then(({ data }) => (this.suppliers))
                .catch(error => this.errors = error.response.data.errors)
        },
        created() {
            axios.get('/api/category/')
                .then(({ data }) => (this.categories = data))

            axios.get('/api/supplier/')
                .then(({ data }) => (this.suppliers = data))
        }
    }
}
</script>

<style>
</style>
