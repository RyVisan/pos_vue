<template>
    <div>
        <!-- <div class="row"> -->
        <router-link to="/expense" class="btn btn-primary">All Expense</router-link>
        <!-- </div> -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-4">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Update Expense</h1>
                                    </div>
                                    <form @submit.prevent="expenseUpdate" autocomplete="off">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1"><b>Expense
                                                                Details</b></label>
                                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                                            rows="3" v-model="form.detials"></textarea>
                                                        <small class="text-danger" v-if="errors.detials">{{
                                                                errors.detials[0]
                                                        }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="exampleFormControlTextarea1"><b>Expense
                                                            Amount</b></label>
                                                    <input type="text" v-model="form.amount" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Amount">
                                                    <small class="text-danger" v-if="errors.amount">{{
                                                            errors.amount[0]
                                                    }}</small>
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
                detials: '',
                amount: ''
            },
            errors: {},
            expenses: {}
        }
    },
    created() {
        let id = this.$route.params.id
        axios.get('/api/expense/' + id)
            .then(({ data }) => (this.form = data))
            .catch(console.log('error'))
    },
    methods: {
        expenseUpdate() {
            let id = this.$route.params.id
            axios.patch('/api/expense/' + id, this.form)
                .then(() => {
                    this.$router.push({ name: 'expense' })
                    Notification.success()
                })
                .catch(error => this.errors = error.response.data.errors)
        },
    }
}
</script>

<style>
</style>
