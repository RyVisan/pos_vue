<template>
    <div>
        <!-- <div class="row"> -->
        <router-link to="/store-employee" class="btn btn-primary">Add Employee</router-link>
        <input type="text" v-model="searchTerm" class="form-control mt-4" placeholder="Search....."
            style="width: 300px;">
        <!-- </div> -->
        <div class="row">
            <div class="col-lg-12 my-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Phone</th>
                                    <th>Salary</th>
                                    <th>Joining Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="employee in filterSearch" :key="employee.id">
                                    <td>{{ employee.name }}</td>
                                    <td><img :src="employee.photo" id="em_photo"></td>
                                    <td>{{ employee.phone }}</td>
                                    <td>{{ employee.salary }}</td>
                                    <td>{{ employee.joining_date }}</td>
                                    <td>
                                        <router-link :to="{ name: 'pay-salary', params: { id: employee.id } }"
                                            class="btn btn-sm btn-primary">Pay Salary</router-link>
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
            employees: [],
            searchTerm: ''
        }
    },
    computed: {
        filterSearch() {
            return this.employees.filter(employee => {
                return employee.name.match(this.searchTerm)
            })
        }
    },
    methods: {
        allEmployee() {
            axios.get('/api/employee/')
                .then(({ data }) => (this.employees = data))
                .catch()
        }
    },
    created() {
        this.allEmployee()
    }
}
</script>

<style>
#em_photo {
    width: 40px;
    height: 40px;
}
</style>
