<template>
    <div>
        <!-- <div class="row"> -->
        <router-link to="/store-expense" class="btn btn-primary">Add Expense</router-link>
        <input type="text" v-model="searchTerm" class="form-control mt-4" placeholder="Search....."
            style="width: 300px;">
        <!-- </div> -->
        <div class="row">
            <div class="col-lg-12 my-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Details</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="expense in filterSearch" :key="expense.id">
                                    <td>{{ expense.detials }}</td>
                                    <td>{{ expense.amount }}</td>
                                    <td>{{ expense.expense_date }}</td>
                                    <td>
                                        <router-link :to="{ name: 'edit-expense', params: { id: expense.id } }"
                                            class="btn btn-sm btn-primary">Edit</router-link>
                                        <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger"
                                            style="color: white;">Delete</a>
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
            expenses: [],
            searchTerm: ''
        }
    },
    computed: {
        filterSearch() {
            return this.expenses.filter(expense => {
                return expense.detials.match(this.searchTerm);
            })
        }
    },
    methods: {
        allExpense() {
            axios.get('/api/expense/')
                .then(({ data }) => (this.expenses = data))
                .catch()
        },
        deleteExpense(id) {
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
                    axios.delete('/api/expense/' + id)
                        .then(() => {
                            this.expenses = this.expenses.filter(expense => {
                                return expense.id != id
                            })
                        })
                        .catch(() => {
                            this.$router.push({ name: 'expense' })
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
        this.allExpense()
    }
}
</script>

<style>
#em_photo {
    width: 40px;
    height: 40px;
}
</style>
