//start authencicate
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
//end authenticate

let home = require('./components/home.vue').default;

//Employee Component
let storeemployee = require('./components/employee/create.vue').default;
let employee = require('./components/employee/index.vue').default;
let editemployee = require('./components/employee/edit.vue').default;

//Supplier Component
let storesupplier = require('./components/supplier/create.vue').default;
let supplier = require('./components/supplier/index.vue').default;
let editesupplier = require('./components/supplier/edit.vue').default;

//Category Component
let storecategory = require('./components/category/create.vue').default;
let category = require('./components/category/index.vue').default;
let editecategory = require('./components/category/edit.vue').default;

//Product Component
let storeproduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editeproduct = require('./components/product/edit.vue').default;

//Expense Component
let storeexpense = require('./components/expense/create.vue').default;
let expense = require('./components/expense/index.vue').default;
let editeexpense = require('./components/expense/edit.vue').default;

//Salary Component
let salary = require('./components/salary/all_employee.vue').default;
let paysalary = require('./components/salary/create.vue').default;
let allsalary = require('./components/salary/index.vue').default;
let viewsalary = require('./components/salary/view.vue').default;
let editsalary = require('./components/salary/edit.vue').default;

//Stock Component
let stock = require('./components/product/stock.vue').default;

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/home', component: home, name: 'home' },

    //Employee Routes
    { path: '/store-employee', component: storeemployee, name: 'store-employee' },
    { path: '/employee', component: employee, name: 'employee' },
    { path: '/edit-employee/:id', component: editemployee, name: 'edit-employee' },

    //Supplier Routes
    { path: '/store-supplier', component: storesupplier, name: 'store-supplier' },
    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/edit-supplier/:id', component: editesupplier, name: 'edit-supplier' },

    //Category Routes
    { path: '/store-category', component: storecategory, name: 'store-category' },
    { path: '/category', component: category, name: 'category' },
    { path: '/edit-category/:id', component: editecategory, name: 'edit-category' },

    //Product Routes
    { path: '/store-product', component: storeproduct, name: 'store-product' },
    { path: '/product', component: product, name: 'product' },
    { path: '/edit-product/:id', component: editeproduct, name: 'edit-product' },

    //Expense Routes
    { path: '/store-expense', component: storeexpense, name: 'store-expense' },
    { path: '/expense', component: expense, name: 'expense' },
    { path: '/edit-expense/:id', component: editeexpense, name: 'edit-expense' },

    //Salary Routes
    { path: '/given-salary', component: salary, name: 'given-salary' },
    { path: '/pay-salary/:id', component: paysalary, name: 'pay-salary' },
    { path: '/salary', component: allsalary, name: 'salary' },
    { path: '/view-salary/:id', component: viewsalary, name: 'view-salary' },
    { path: '/edit-salary/:id', component: editsalary, name: 'edit-salary' },

    //Stock Routes
    { path: '/stock', component: stock, name: 'stock' }
]