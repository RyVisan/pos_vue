<template>
    <div>
        <!-- <div class="row"> -->
        <router-link to="/store-product" class="btn btn-primary">Add Product</router-link>
        <input type="text" v-model="searchTerm" class="form-control mt-4" placeholder="Search....."
            style="width: 300px;">
        <!-- </div> -->
        <div class="row">
            <div class="col-lg-12 my-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Stock</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Photo</th>
                                    <th>Category</th>
                                    <th>Buying Price</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in filterSearch" :key="product.id">
                                    <td>{{ product.product_name }}</td>
                                    <td>{{ product.product_code }}</td>
                                    <td><img :src="product.image" id="em_photo"></td>
                                    <td>{{ product.category.category_name }}</td>
                                    <td>{{ product.buying_price }}</td>
                                    <td v-if="product.product_quantity >= 1 && product.product_quantity <= 5"><span
                                            class="badge badge-warning">Low</span></td>
                                    <td v-else-if="product.product_quantity >= 6"><span
                                            class="badge badge-success">Avialable</span></td>
                                    <td v-else=""><span class="badge badge-danger">Stock Out</span>
                                    </td>
                                    <td>{{ product.product_quantity }}</td>
                                    <td>
                                        <router-link :to="{ name: 'edit-stock', params: { id: product.id } }"
                                            class="btn btn-sm btn-primary">Edit</router-link>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
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
            products: [],
            searchTerm: ''
        }
    },
    computed: {
        filterSearch() {
            return this.products.filter(product => {
                return product.product_name.match(this.searchTerm)
            })
        }
    },
    methods: {
        allProduct() {
            axios.get('/api/product/')
                .then(({ data }) => (this.products = data))
                .catch()
        },
        deleteProduct(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/product/' + id)
                        .then(() => {
                            this.products = this.products.filter(product => {
                                return product.id != id
                            })
                        })
                        .catch(() => {
                            this.$router.push({ name: 'product' })
                        })
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }
    },
    created() {
        this.allProduct()
    }
}
</script>

<style>
#em_photo {
    width: 40px;
    height: 40px;
}
</style>
